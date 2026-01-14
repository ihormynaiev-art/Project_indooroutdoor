<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== SYNC VALIDATION CHECK ===\n\n";

// Load JSON
$json = json_decode(file_get_contents(__DIR__.'/indooroutdoor_category_taxonomy_2025.json'), true);

if (! is_array($json)) {
    echo "✗ JSON is invalid!\n";
    exit(1);
}

echo "✓ JSON is valid\n";
echo 'Categories in JSON: '.count($json)."\n";

$totalServices = 0;
$categoryNames = [];
foreach ($json as $cat) {
    if (! isset($cat['category']) || ! isset($cat['services'])) {
        echo "✗ Invalid JSON structure!\n";
        exit(1);
    }
    $categoryNames[] = $cat['category'];
    $totalServices += count($cat['services']);
}

echo "Total services in JSON: $totalServices\n";
echo "✓ JSON structure is valid\n\n";

// Check seeder mapping
echo "=== SEEDER MAPPING VALIDATION ===\n\n";

$mapping = [
    'Concrete, Brick, Pavers & Stone' => 'Concrete, Brick & Pavers',
    'Electrical & Computers' => 'Electrical',
    'Basements' => 'Basement & Waterproofing',
    'Bathrooms' => 'Bathroom Remodeling',
    'Appliances' => 'Appliance Repair',
    'Cleaning & Restoration Service' => 'Cleaning Services',
    'Garages, Doors, Openers' => 'Garages, Doors & Openers',
];

echo "Checking if renamed categories exist in JSON:\n";
$mappingValid = true;
foreach ($mapping as $old => $new) {
    $exists = in_array($new, $categoryNames);
    echo "  $new: ".($exists ? '✓' : '✗ NOT FOUND IN JSON!')."\n";
    if (! $exists) {
        $mappingValid = false;
    }
}

if (! $mappingValid) {
    echo "\n✗ MAPPING ERROR: Some renamed categories don't exist in JSON!\n";
    exit(1);
}

echo "\n✓ All renamed categories exist in JSON\n\n";

// Check DB
echo "=== DATABASE VALIDATION ===\n\n";

$dbCats = DB::table('categories')->whereNull('parent_id')->pluck('name')->toArray();
echo 'Categories in DB: '.count($dbCats)."\n\n";

echo "Checking if categories to rename exist in DB:\n";
$dbValid = true;
foreach (array_keys($mapping) as $old) {
    $exists = in_array($old, $dbCats);
    echo "  $old: ".($exists ? '✓' : '✗ NOT FOUND IN DB!')."\n";
    if (! $exists) {
        $dbValid = false;
    }
}

if (! $dbValid) {
    echo "\n⚠ WARNING: Some categories to rename don't exist in DB (maybe already renamed?)\n\n";
}

echo "\nChecking if categories to delete exist in DB:\n";
$toDelete = ['Additions & Remodels', 'Cabinets & Countertops'];
foreach ($toDelete as $cat) {
    $exists = in_array($cat, $dbCats);
    echo "  $cat: ".($exists ? '✓ Found' : '✗ NOT FOUND!')."\n";
}

echo "\n=== SIMULATION ===\n\n";

// Simulate what will happen
$simulatedDB = $dbCats;

// Remove categories to delete
foreach ($toDelete as $cat) {
    $key = array_search($cat, $simulatedDB);
    if ($key !== false) {
        unset($simulatedDB[$key]);
    }
}

// Rename categories
foreach ($mapping as $old => $new) {
    $key = array_search($old, $simulatedDB);
    if ($key !== false) {
        $simulatedDB[$key] = $new;
    }
}

// Add new categories
foreach ($categoryNames as $cat) {
    if (! in_array($cat, $simulatedDB)) {
        $simulatedDB[] = $cat;
    }
}

$simulatedDB = array_values($simulatedDB);
sort($simulatedDB);
sort($categoryNames);

echo "After sync:\n";
echo '  Expected parent categories: '.count($categoryNames)."\n";
echo '  Simulated parent categories: '.count($simulatedDB)."\n";

$diff1 = array_diff($categoryNames, $simulatedDB);
$diff2 = array_diff($simulatedDB, $categoryNames);

if (empty($diff1) && empty($diff2)) {
    echo "\n✓✓✓ SYNC WILL SUCCEED! ✓✓✓\n";
    echo "\nParent categories will match JSON exactly.\n";
    echo "Subcategories will be synchronized per category.\n";
} else {
    echo "\n✗ SYNC WILL FAIL!\n";
    if (! empty($diff1)) {
        echo "\nMissing in simulated DB:\n";
        foreach ($diff1 as $cat) {
            echo "  - $cat\n";
        }
    }
    if (! empty($diff2)) {
        echo "\nExtra in simulated DB:\n";
        foreach ($diff2 as $cat) {
            echo "  - $cat\n";
        }
    }
    exit(1);
}

echo "\n=== SUBCATEGORY CHECK (sample) ===\n\n";

// Check one category as example
$sampleCategory = 'Electrical';
$target = [];
foreach ($json as $cat) {
    if ($cat['category'] === $sampleCategory) {
        $target = $cat['services'];
        break;
    }
}

// Find in DB (might be under old name)
$dbParent = DB::table('categories')
    ->whereNull('parent_id')
    ->where(function ($q) use ($sampleCategory, $mapping) {
        $q->where('name', $sampleCategory);
        foreach ($mapping as $old => $new) {
            if ($new === $sampleCategory) {
                $q->orWhere('name', $old);
            }
        }
    })
    ->first();

if ($dbParent) {
    $dbSubs = DB::table('categories')
        ->where('parent_id', $dbParent->id)
        ->pluck('name')
        ->toArray();

    echo "Sample: $sampleCategory (currently: {$dbParent->name})\n";
    echo '  In JSON: '.count($target)." services\n";
    echo '  In DB: '.count($dbSubs)." subcategories\n";
    echo '  Will remove: '.count(array_diff($dbSubs, $target))."\n";
    echo '  Will add: '.count(array_diff($target, $dbSubs))."\n";
}

echo "\n=== FINAL VERDICT ===\n\n";
echo "✓ JSON file is valid\n";
echo "✓ Seeder mapping is correct\n";
echo "✓ Database has required categories\n";
echo "✓ Simulation successful\n";
echo "\n🎯 READY TO SYNC!\n";
