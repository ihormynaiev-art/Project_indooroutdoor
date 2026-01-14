<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UpdateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Starting seeder...\n";
        echo 'Initial subcategories: '.Category::whereNotNull('parent_id')->count()."\n\n";

        $this->cleanInvalidSubcategories();
        echo 'After cleanInvalidSubcategories: '.Category::whereNotNull('parent_id')->count()." subcategories\n\n";

        $this->updateMainCategories();
        echo 'After updateMainCategories: '.Category::whereNotNull('parent_id')->count()." subcategories\n\n";

        $this->syncSubCategories();
        echo 'After syncSubCategories: '.Category::whereNotNull('parent_id')->count()." subcategories\n\n";

        $this->deleteUnusedCategories();
        echo 'After deleteUnusedCategories: '.Category::whereNotNull('parent_id')->count()." subcategories\n\n";

        $this->verifyCategories();
    }

    public function cleanInvalidSubcategories(): void
    {
        // Find and delete subcategories whose parent is itself a subcategory (3rd level nesting)
        $invalidSubcategories = Category::whereNotNull('parent_id')
            ->whereHas('parent', function ($query) {
                $query->whereNotNull('parent_id');
            })
            ->get();

        if ($invalidSubcategories->count() > 0) {
            echo "Cleaning invalid subcategories (3rd level nesting):\n";
            foreach ($invalidSubcategories as $invalid) {
                $parent = Category::find($invalid->parent_id);
                echo "  Deleting: {$invalid->name} (parent: {$parent->name} which is itself a subcategory)\n";
                $invalid->delete();
            }
            echo "Deleted {$invalidSubcategories->count()} invalid subcategories\n";
        }
    }

    public function updateMainCategories(): void
    {
        foreach ($this->updateMainCategoriesData() as $oldCategory => $newCategory) {
            Category::query()
                ->where('name', $oldCategory)
                ->whereNull('parent_id')
                ->update([
                    'name' => $newCategory,
                    'slug' => Str::slug($newCategory),
                ]);
        }

        $existingCategories = Category::query()
            ->whereNull('parent_id')
            ->pluck('name')
            ->toArray();

        $newCategories = array_column($this->newData(), 'category');

        foreach ($newCategories as $categoryName) {
            if (! in_array($categoryName, $existingCategories)) {
                Category::query()
                    ->create([
                        'name' => $categoryName,
                        'slug' => Str::slug($categoryName),
                        'icon_path' => '',
                        'is_active' => true,
                        'prio' => 1,
                    ]);
            }
        }
    }

    public function syncSubCategories(): void
    {
        $totalCreated = 0;
        $totalDeleted = 0;

        foreach ($this->newData() as $categoryData) {
            $parentCategory = Category::where('name', $categoryData['category'])
                ->whereNull('parent_id')
                ->first();

            if (! $parentCategory) {
                continue;
            }

            $newServiceNames = $categoryData['services'];
            $existingSubCategories = $parentCategory->subCategories;

            // Get mapping for the current category
            $subCategoryMapping = $this->getSubCategoryMapping($categoryData['category']);

            // First, check for conflicts: if both old and new names exist, delete the old one
            foreach ($subCategoryMapping as $oldName => $newName) {
                $hasOldName = $existingSubCategories->where('name', $oldName)->isNotEmpty();
                $hasNewName = $existingSubCategories->where('name', $newName)->isNotEmpty();

                // If both old and new names exist, delete the old one to avoid duplicates
                if ($hasOldName && $hasNewName) {
                    echo "    Deleting duplicate: {$parentCategory->name} -> {$oldName} (conflicts with {$newName})\n";
                    $parentCategory->subCategories()
                        ->where('name', $oldName)
                        ->delete();
                }
            }

            // Reload after deleting conflicts
            $existingSubCategories = $parentCategory->subCategories()->get();

            // Now update subcategory names according to the mapping (only non-conflicting ones)
            foreach ($subCategoryMapping as $oldName => $newName) {
                $existingSubCategories
                    ->where('name', $oldName)
                    ->each(function ($subCategory) use ($newName) {
                        $subCategory->update([
                            'name' => $newName,
                            'slug' => Str::slug($newName),
                        ]);
                    });
            }

            // Reload subcategories after update
            $existingSubCategories = $parentCategory->subCategories()->get();

            // Update existing subcategories or add new ones
            $created = 0;
            foreach ($newServiceNames as $serviceName) {
                $existingSubCategory = $existingSubCategories->firstWhere('name', $serviceName);

                if ($existingSubCategory) {
                    // Update only slug, preserve other fields (including images)
                    $existingSubCategory->update([
                        'slug' => Str::slug($serviceName),
                    ]);
                } else {
                    // Create new subcategory
                    echo "    Creating: {$parentCategory->name} -> {$serviceName}\n";
                    Category::create([
                        'name' => $serviceName,
                        'slug' => Str::slug($serviceName),
                        'parent_id' => $parentCategory->id,
                        'icon_path' => '',
                        'is_active' => true,
                        'prio' => 1,
                    ]);
                    $created++;
                }
            }

            // Delete subcategories that are not in the new list
            $deleted = $parentCategory->subCategories()
                ->whereNotIn('name', $newServiceNames)
                ->count();

            $parentCategory->subCategories()
                ->whereNotIn('name', $newServiceNames)
                ->delete();

            if ($created > 0 || $deleted > 0) {
                echo "  {$parentCategory->name}: created {$created}, deleted {$deleted}\n";
            }

            $totalCreated += $created;
            $totalDeleted += $deleted;
        }

        echo "Total created: {$totalCreated}, total deleted: {$totalDeleted}\n";
    }

    public function getSubCategoryMapping(string $parentCategoryName): array
    {
        $mappings = [
            'Appliance Repair' => [
                'Dishwasher Install or Repair' => 'Dishwasher Repair',
                'Refrigerator Install or Repair' => 'Refrigerator Repair',
            ],
            'Basement & Waterproofing' => [
                'Waterproof a basement or Foundation' => 'Foundation Waterproofing',
                'Install or Replace Foundation Drains' => 'Interior Drain Tile Systems',
                'Excavate or Grade the Slope of the Grounds' => 'Exterior Excavation Waterproofing',
                'Sump Pump Installation' => 'Sump Pumps / Backup Systems',
                'Remodel a Basement' => 'Basement Finishing',
            ],
            'Bathroom Remodeling' => [
                'Bathroom Remodeling and Design' => 'Full Bathroom Remodeling',
                'Cabinets and Vanities' => 'Vanities & Countertops',
                'Plumbing' => 'Plumbing Fixtures',
                'Grab Bars and Seat Benches' => 'Accessibility Bathrooms (Walk-In Tubs, Grab Bars)',
            ],
            'Cleaning Services' => [
                'Maid Service' => 'House Cleaning',
                'Carpet - Cleaning' => 'Carpet & Upholstery Cleaning',
                'Exterior House Cleaning' => 'Power Washing',
                'Windows Cleaning' => 'Window Cleaning',
                'Gutters & Downspouts - Clean' => 'Gutter Cleaning',
            ],
            'Concrete, Brick & Pavers' => [
                'Concrete Driveways & Floors - Install' => 'Concrete Driveways',
                'Concrete Patios, Walks & Steps- Install' => 'Concrete Patios & Walks',
                'Concrete Stamped - Install' => 'Stamped / Decorative Concrete',
                'Concrete Flatwork - Repair & Resurface' => 'Concrete Repair / Leveling',
                'Brick or Stone - Tuck-pointing' => 'Brickwork / Masonry',
                'Chimney Repair or Replace' => 'Chimney Repair',
                'Pavers for Driveways & Floors - Install' => 'Paver Installation',
            ],
            'Decks & Porches' => [
                'Deck or Porch - Build or Replace' => 'Deck Construction (Wood)',
                'Deck or Porch - Repair' => 'Deck Repair / Rebuild',
                'Deck, Fence, Patio or Porch - Clean and Seal' => 'Deck Staining / Sealing',
                'Arbor, Pergola or Trellis - Build Custom' => 'Pergolas / Pavilions',
            ],
            'Driveways, Patios & Walks' => [
                'Asphalt Paving - Install' => 'Asphalt Driveways',
                'Concrete Driveways & Floors - Install' => 'Concrete Driveways',
                'Pavers for Driveways & Floors - Install' => 'Paver Driveways',
                'Concrete Patios, Walks & Steps- Install' => 'Patios (Concrete / Paver)',
                'Pavers for Patios, Walks & Steps - Install' => 'Walkways',
                'Asphalt Sealing' => 'Resurfacing / Sealing',
            ],
            'Electrical' => [
                'Electrical Outlets, Panels, Switches & Wiring' => 'Electrical Repair / Troubleshooting',
                'Generators' => 'Generators (Install / Service)',
                'Home Security & Alarms' => 'Smart Home / Low Voltage',
            ],
            'Fences' => [
                'Aluminum or Steel' => 'Aluminum / Steel Fencing',
            ],
            'Finish Carpentry' => [
                'Interior Doors - Install or Replace' => 'Interior Doors (Install / Replace)',
                'Casing (Trim around doors & windows)' => 'Trim / Molding Installation',
            ],
            'Flooring' => [
                'Carpet - Install' => 'Carpet Installation',
                'Ceramic Tile' => 'Tile Flooring',
            ],
            'Garages, Doors & Openers' => [
                'Garage Door - Install or Replace' => 'Garage Door Installation',
                'Garage Organizers - Install' => 'Garage Storage Systems',
                'Concrete Floor Coating-Apply' => 'Garage Floor Coatings (Epoxy)',
            ],
            'Heating & Cooling' => [
                'Furnace & Central Heating' => 'Furnace Installation / Repair',
                'Air Conditioning & Cooling' => 'Air Conditioning Installation / Repair',
                'Ducts & Vents - Cleaning' => 'Duct Cleaning',
            ],
            'Home Furnishings' => [
                'Furniture-Built-in' => 'Furniture Retail',
                'Bedding and Mattresses' => 'Mattresses',
                'Wall Decor' => 'Home Decor & Accessories',
                'Lighting' => 'Lighting Stores',
            ],
            'Insulation' => [
                'Spray Foam Insulation - Install' => 'Spray Foam',
                'Blown-In Insulation - Install or Upgrade' => 'Blown-In / Cellulose',
                'Batt, Rolled or Reflective Insulation - Install or Upgrade' => 'Batt Insulation',
            ],
            'Kitchens' => [
                'Kitchen Remodeling and Design' => 'Full Kitchen Remodeling',
                'Outdoor Kitchen' => 'Kitchen Design',
                'Plumbing' => 'Plumbing Fixtures',
            ],
            'Landscape' => [
                'Landscaping - Design & Installation' => 'Landscape Design',
                'Trees and Shrubs - Trim, Remove, Install' => 'Shrub Trimming / Removal',
                'Outdoor Patios, Steps & Walkways' => 'Hardscapes (Pavers, Walls)',
                'Outdoor Walls & Retaining Walls' => 'Retaining Walls',
                'Spring and Fall Clean-ups' => 'Grading / Sod',
                'Outdoor Lighting - Repair and Installation' => 'Landscape Lighting',
            ],
            'Lawncare & Sprinklers' => [
                'Lawn Care - Maintain and Mow a Lawn' => 'Lawn Mowing / Maintenance',
                'Lawn Care - Fertilize or Treat a Lawn' => 'Fertilization / Weed Control',
                'Landscaping - Sprinkler Systems' => 'Irrigation System Installation',
                'Lawn Care - Aerate a Lawn' => 'Aeration / Overseeding',
            ],
            'Organization' => [
                'Closet' => 'Closet Systems',
                'Kitchen' => 'Pantry Organization',
                'Mudroom' => 'Mudroom Built-ins',
                'Garage' => 'Garage Storage Systems',
            ],
            'Painting & Repairs' => [
                'Interior Painting or Staining' => 'Interior Painting',
                'Exterior Painting or Staining' => 'Exterior Painting',
                'Wallpapering' => 'Wallpaper Installation / Removal',
            ],
            'Roofing & Gutters' => [
                'Roofing - Install or Replace' => 'Roof Replacement',
                'Roofing - Repair' => 'Roof Repair',
                'Gutters' => 'Gutters & Downspouts',
            ],
            'Siding' => [
                'James Hardie- Install or Repair' => 'Fiber Cement Siding',
                'Vinyl - Install or Repair' => 'Vinyl Siding',
                'Wood - Install or Repair' => 'Wood Siding',
            ],
            'Swimming Pools & Spas' => [
                'Swimming Pools' => 'Pool Installation',
                'Swimming Pool -Remodel' => 'Pool Service / Maintenance',
                'Hot Tubs & Spas' => 'Hot Tubs / Spas',
            ],
            'Tile & Stone' => [
                'Ceramic and Porcelain - Install' => 'Tile Floors',
                'Natural Stone (Granite, Marble, Slate, Quartz, etc) - Install' => 'Stone Countertops',
                'Grout: Replace or Repair' => 'Tile Repair / Regrout',
            ],
            'Windows & Doors' => [
                'Windows - Installation & Repair' => 'Window Replacement',
                'Entry Doors - Installation & Repair' => 'Entry Doors',
                'Doorwall - Installation & Repair' => 'Patio / Sliding Doors',
            ],
        ];

        return $mappings[$parentCategoryName] ?? [];
    }

    public function deleteUnusedCategories(): void
    {
        $newCategoryNames = array_column($this->newData(), 'category');

        // Delete main categories that are not in the new list
        $oldCategories = Category::whereNull('parent_id')
            ->whereNotIn('name', $newCategoryNames)
            ->get();

        $deletedMainCategories = 0;
        $deletedSubCategories = 0;

        foreach ($oldCategories as $category) {
            echo "  Deleting main category: {$category->name}\n";
            $subCount = $category->subCategories()->count();
            $deletedSubCategories += $subCount;

            // Delete all subcategories
            $category->subCategories()->delete();
            // Delete the category itself
            $category->delete();
            $deletedMainCategories++;
        }

        echo "Deleted {$deletedMainCategories} main categories and {$deletedSubCategories} subcategories\n";
    }

    public function verifyCategories(): void
    {
        // Expected values from newData()
        $expectedMainCategories = count($this->newData());
        $expectedSubCategories = 0;
        foreach ($this->newData() as $categoryData) {
            $expectedSubCategories += count($categoryData['services']);
        }
        $expectedTotal = $expectedMainCategories + $expectedSubCategories;

        // Actual values from DB
        $actualMainCategories = Category::whereNull('parent_id')->count();
        $actualSubCategories = Category::whereNotNull('parent_id')->count();
        $actualTotal = Category::count();

        echo "\n==================== CATEGORY VERIFICATION ====================\n";
        echo "Main categories:  expected {$expectedMainCategories}, in DB {$actualMainCategories}";
        echo ($expectedMainCategories === $actualMainCategories) ? " ✓\n" : " ✗\n";

        echo "Subcategories:    expected {$expectedSubCategories}, in DB {$actualSubCategories}";
        echo ($expectedSubCategories === $actualSubCategories) ? " ✓\n" : " ✗\n";

        echo "Total categories: expected {$expectedTotal}, in DB {$actualTotal}";
        echo ($expectedTotal === $actualTotal) ? " ✓\n" : " ✗\n";
        echo "===============================================================\n\n";

        if ($expectedTotal !== $actualTotal) {
            throw new \Exception("Category count mismatch! Expected {$expectedTotal}, in DB {$actualTotal}");
        }
    }

    public function updateMainCategoriesData(): array
    {
        return [
            'Appliances' => 'Appliance Repair',
            'Basements' => 'Basement & Waterproofing',
            'Bathrooms' => 'Bathroom Remodeling',
            'Cleaning & Restoration Service' => 'Cleaning Services',
            'Concrete, Brick, Pavers & Stone' => 'Concrete, Brick & Pavers',
            'Electrical & Computers' => 'Electrical',
            'Garages, Doors, Openers' => 'Garages, Doors & Openers',
        ];
    }

    public function newData(): array
    {
        return [
            [
                'category' => 'Appliance Repair',
                'services' => [
                    'Major Appliance Repair',
                    'Refrigerator Repair',
                    'Washer / Dryer Repair',
                    'Oven / Range / Cooktop Repair',
                    'Dishwasher Repair',
                    'Appliance Installation',
                ],
            ],
            [
                'category' => 'Basement & Waterproofing',
                'services' => [
                    'Foundation Waterproofing',
                    'Interior Drain Tile Systems',
                    'Exterior Excavation Waterproofing',
                    'Foundation Crack Repair',
                    'Sump Pumps / Backup Systems',
                    'Egress Windows',
                    'Basement Finishing',
                ],
            ],
            [
                'category' => 'Bathroom Remodeling',
                'services' => [
                    'Full Bathroom Remodeling',
                    'Shower / Tub Replacement',
                    'Tile Showers',
                    'Vanities & Countertops',
                    'Plumbing Fixtures',
                    'Accessibility Bathrooms (Walk-In Tubs, Grab Bars)',
                ],
            ],
            [
                'category' => 'Cleaning Services',
                'services' => [
                    'House Cleaning',
                    'Move-In / Move-Out Cleaning',
                    'Carpet & Upholstery Cleaning',
                    'Power Washing',
                    'Window Cleaning',
                    'Gutter Cleaning',
                ],
            ],
            [
                'category' => 'Concrete, Brick & Pavers',
                'services' => [
                    'Concrete Driveways',
                    'Concrete Patios & Walks',
                    'Stamped / Decorative Concrete',
                    'Concrete Repair / Leveling',
                    'Brickwork / Masonry',
                    'Chimney Repair',
                    'Paver Installation',
                    'Paver Repair / Restoration',
                    'Hardscape Drainage (Patio/Driveway Water Issues)',
                ],
            ],
            [
                'category' => 'Decks & Porches',
                'services' => [
                    'Deck Construction (Wood)',
                    'Deck Construction (Composite)',
                    'Deck Repair / Rebuild',
                    'Deck Staining / Sealing',
                    'Screened-In Porches',
                    'Porches (Open / Enclosed)',
                    'Railings',
                    'Pergolas / Pavilions',
                    'Deck Waterproofing Systems',
                ],
            ],
            [
                'category' => 'Driveways, Patios & Walks',
                'services' => [
                    'Asphalt Driveways',
                    'Concrete Driveways',
                    'Paver Driveways',
                    'Patios (Concrete / Paver)',
                    'Walkways',
                    'Resurfacing / Sealing',
                    'Drainage / Slope Correction (Hardscape)',
                ],
            ],
            [
                'category' => 'Electrical',
                'services' => [
                    'Electrical Repair / Troubleshooting',
                    'Panel Upgrades',
                    'New Circuits / Outlets',
                    'Lighting Installation',
                    'Generators (Install / Service)',
                    'EV Charger Installation',
                    'Smart Home / Low Voltage',
                    'Whole-Home Surge Protection',
                ],
            ],
            [
                'category' => 'Fences',
                'services' => [
                    'Wood Fencing',
                    'Vinyl Fencing',
                    'Aluminum / Steel Fencing',
                    'Chain Link Fencing',
                    'Fence Repair',
                    'Gates / Entry Systems',
                ],
            ],
            [
                'category' => 'Finish Carpentry',
                'services' => [
                    'Trim / Molding Installation',
                    'Interior Doors (Install / Replace)',
                    'Wainscoting / Wall Treatments',
                    'Built-ins / Custom Woodwork',
                    'Stair Railings / Banisters',
                ],
            ],
            [
                'category' => 'Flooring',
                'services' => [
                    'Hardwood Installation',
                    'Hardwood Refinishing',
                    'Luxury Vinyl Plank',
                    'Laminate Flooring',
                    'Carpet Installation',
                    'Tile Flooring',
                ],
            ],
            [
                'category' => 'Garages, Doors & Openers',
                'services' => [
                    'Garage Door Installation',
                    'Garage Door Repair',
                    'Openers / Keypads',
                    'Garage Storage Systems',
                    'Garage Floor Coatings (Epoxy)',
                ],
            ],
            [
                'category' => 'Handyman Services',
                'services' => [
                    'General Home Repairs',
                    'Minor Carpentry',
                    'Minor Plumbing',
                    'Minor Electrical',
                    'TV Mounting',
                    'Caulking / Weatherstripping',
                ],
            ],
            [
                'category' => 'Heating & Cooling',
                'services' => [
                    'Furnace Installation / Repair',
                    'Air Conditioning Installation / Repair',
                    'Boilers',
                    'Heat Pumps / Mini Splits',
                    'Ductless Systems',
                    'Duct Cleaning',
                    'Indoor Air Quality (Humidifiers / Purifiers)',
                ],
            ],
            [
                'category' => 'Home Furnishings',
                'services' => [
                    'Furniture Retail',
                    'Mattresses',
                    'Home Decor & Accessories',
                    'Lighting Stores',
                    'Window Treatments',
                    'Home Organization Products',
                ],
            ],
            [
                'category' => 'Insulation',
                'services' => [
                    'Spray Foam',
                    'Blown-In / Cellulose',
                    'Batt Insulation',
                    'Crawlspace Encapsulation',
                    'Soundproofing',
                ],
            ],
            [
                'category' => 'Kitchens',
                'services' => [
                    'Full Kitchen Remodeling',
                    'Kitchen Design',
                    'Kitchen Cabinets',
                    'Cabinet Refinishing / Painting',
                    'Countertops',
                    'Backsplash Installation',
                    'Plumbing Fixtures',
                ],
            ],
            [
                'category' => 'Landscape',
                'services' => [
                    'Landscape Design',
                    'Planting / Bed Installation',
                    'Hardscapes (Pavers, Walls)',
                    'Retaining Walls',
                    'Outdoor Kitchens',
                    'Firepits & Fire Features',
                    'Yard Drainage (French Drains / Swales)',
                    'Grading / Sod',
                    'Mulch / Stone Installation',
                    'Shrub Trimming / Removal',
                    'Landscape Lighting',
                ],
            ],
            [
                'category' => 'Lawncare & Sprinklers',
                'services' => [
                    'Lawn Mowing / Maintenance',
                    'Fertilization / Weed Control',
                    'Irrigation System Installation',
                    'Irrigation System Repair',
                    'Aeration / Overseeding',
                ],
            ],
            [
                'category' => 'Organization',
                'services' => [
                    'Closet Systems',
                    'Pantry Organization',
                    'Mudroom Built-ins',
                    'Garage Storage Systems',
                    'Basement / Attic Organization',
                ],
            ],
            [
                'category' => 'Painting & Repairs',
                'services' => [
                    'Interior Painting',
                    'Exterior Painting',
                    'Drywall Installation / Repair',
                    'Cabinet Painting / Refinishing',
                    'Wallpaper Installation / Removal',
                    'Carpentry Repairs',
                ],
            ],
            [
                'category' => 'Pest Control',
                'services' => [
                    'General Pest Control',
                    'Rodent Control',
                    'Wildlife Removal',
                    'Termite Treatment',
                    'Mosquito / Tick Control',
                ],
            ],
            [
                'category' => 'Plumbing',
                'services' => [
                    'General Plumbing Repairs',
                    'Water Heaters',
                    'Tankless Water Heaters',
                    'Sump Pumps',
                    'Drain Cleaning',
                    'Pipe Leaks / Repiping',
                    'Garbage Disposals',
                    'Fixture Installation (Sinks, Toilets, Faucets)',
                ],
            ],
            [
                'category' => 'Roofing & Gutters',
                'services' => [
                    'Roof Replacement',
                    'Roof Repair',
                    'Roof Inspections',
                    'Storm Damage / Insurance Work',
                    'Gutters & Downspouts',
                    'Gutter Guards',
                    'Roof Drainage (Runoff Management)',
                ],
            ],
            [
                'category' => 'Security Systems',
                'services' => [
                    'Home Security Systems',
                    'Security Cameras',
                    'Smart Locks & Access Control',
                    'Alarm Installation & Monitoring',
                    'Low Voltage Wiring',
                ],
            ],
            [
                'category' => 'Siding',
                'services' => [
                    'Vinyl Siding',
                    'Fiber Cement Siding',
                    'Wood Siding',
                    'Aluminum Siding',
                    'Siding Repair',
                    'Soffit & Fascia',
                ],
            ],
            [
                'category' => 'Solar Energy',
                'services' => [
                    'Solar Panel Installation',
                    'Solar Repair / Maintenance',
                    'Battery Storage Systems',
                ],
            ],
            [
                'category' => 'Swimming Pools & Spas',
                'services' => [
                    'Pool Installation',
                    'Pool Service / Maintenance',
                    'Openings & Closings',
                    'Hot Tubs / Spas',
                    'Pool Decking',
                ],
            ],
            [
                'category' => 'Tile & Stone',
                'services' => [
                    'Tile Floors',
                    'Bathroom Tile',
                    'Kitchen Backsplash',
                    'Outdoor Tile',
                    'Fireplace Surrounds',
                    'Stone Countertops',
                    'Tile Repair / Regrout',
                ],
            ],
            [
                'category' => 'Windows & Doors',
                'services' => [
                    'Window Replacement',
                    'Window Repair',
                    'Entry Doors',
                    'Patio / Sliding Doors',
                    'Storm Doors',
                    'Skylights',
                    'Door Hardware / Accessories',
                ],
            ],
        ];
    }
}
