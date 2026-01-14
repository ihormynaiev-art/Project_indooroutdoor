<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Load target structure from JSON
$json = json_decode(file_get_contents(__DIR__.'/indooroutdoor_category_taxonomy_2025.json'), true);

// Build target structure
$target = [];
foreach ($json as $cat) {
    $target[$cat['category']] = $cat['services'];
}

// Parent category mapping
$parentMapping = [
    'Concrete, Brick, Pavers & Stone' => 'Concrete, Brick & Pavers',
    'Electrical & Computers' => 'Electrical',
    'Basements' => 'Basement & Waterproofing',
    'Bathrooms' => 'Bathroom Remodeling',
    'Appliances' => 'Appliance Repair',
    'Cleaning & Restoration Service' => 'Cleaning Services',
    'Garages, Doors, Openers' => 'Garages, Doors & Openers',
];

echo "=== MIGRATION ANALYSIS ===\n\n";

// Categories to delete completely
$categoriesToDelete = ['Additions & Remodels', 'Cabinets & Countertops'];
echo "Categories to DELETE completely:\n";
foreach ($categoriesToDelete as $cat) {
    echo "  - $cat\n";
}
echo "\n";

// Categories to rename
echo "Categories to RENAME:\n";
foreach ($parentMapping as $old => $new) {
    echo "  - '$old' → '$new'\n";
}
echo "\n";

// New categories to add
$dbCats = DB::table('categories')->whereNull('parent_id')->pluck('name')->toArray();
echo "New categories to ADD:\n";
foreach (array_keys($target) as $targetCat) {
    // Check if exists in DB (considering renames)
    $exists = false;
    if (in_array($targetCat, $dbCats)) {
        $exists = true;
    }
    foreach ($parentMapping as $oldName => $newName) {
        if ($newName === $targetCat && in_array($oldName, $dbCats)) {
            $exists = true;
        }
    }
    if (! $exists) {
        echo "  - $targetCat (".count($target[$targetCat])." services)\n";
    }
}
echo "\n";

// Analyze subcategories
echo "=== SUBCATEGORY ANALYSIS ===\n\n";

$dbParents = DB::table('categories')->whereNull('parent_id')->get();

foreach ($dbParents as $dbParent) {
    $dbSubs = DB::table('categories')->where('parent_id', $dbParent->id)->pluck('name')->toArray();

    // Check target name
    $targetName = $parentMapping[$dbParent->name] ?? $dbParent->name;

    if (in_array($dbParent->name, $categoriesToDelete)) {
        echo "{$dbParent->name} → DELETE ENTIRELY (".count($dbSubs)." subcategories)\n";

        continue;
    }

    if (! isset($target[$targetName])) {
        echo "{$dbParent->name} → NOT FOUND IN TARGET!\n";

        continue;
    }

    $targetSubs = $target[$targetName];

    // Find what to keep, add, remove
    $toKeep = array_intersect($dbSubs, $targetSubs);
    $toRemove = array_diff($dbSubs, $targetSubs);
    $toAdd = array_diff($targetSubs, $dbSubs);

    if (! empty($toRemove) || ! empty($toAdd)) {
        echo "\n{$dbParent->name} → {$targetName}:\n";
        echo '  Current: '.count($dbSubs).' | Target: '.count($targetSubs)."\n";
        echo '  Keep: '.count($toKeep).' | Remove: '.count($toRemove).' | Add: '.count($toAdd)."\n";

        if (! empty($toRemove)) {
            echo "  To REMOVE:\n";
            foreach (array_slice($toRemove, 0, 5) as $sub) {
                echo "    - $sub\n";
            }
            if (count($toRemove) > 5) {
                echo '    ... and '.(count($toRemove) - 5)." more\n";
            }
        }

        if (! empty($toAdd)) {
            echo "  To ADD:\n";
            foreach (array_slice($toAdd, 0, 5) as $sub) {
                echo "    - $sub\n";
            }
            if (count($toAdd) > 5) {
                echo '    ... and '.(count($toAdd) - 5)." more\n";
            }
        }
    }
}

echo "\n=== SUMMARY ===\n";
echo 'Current: '.DB::table('categories')->whereNull('parent_id')->count().' parents, '.DB::table('categories')->whereNotNull('parent_id')->count()." subcategories\n";
echo 'Target: '.count($target).' parents, '.array_sum(array_map('count', $target))." subcategories\n";
