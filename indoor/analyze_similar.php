<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Load JSON
$json = json_decode(file_get_contents(__DIR__.'/indooroutdoor_category_taxonomy_2025.json'), true);
$target = [];
foreach ($json as $cat) {
    $target[$cat['category']] = $cat['services'];
}

// Parent mapping
$parentMapping = [
    'Concrete, Brick, Pavers & Stone' => 'Concrete, Brick & Pavers',
    'Electrical & Computers' => 'Electrical',
    'Basements' => 'Basement & Waterproofing',
    'Bathrooms' => 'Bathroom Remodeling',
    'Appliances' => 'Appliance Repair',
    'Cleaning & Restoration Service' => 'Cleaning Services',
    'Garages, Doors, Openers' => 'Garages, Doors & Openers',
];

function similarity($str1, $str2)
{
    similar_text(strtolower($str1), strtolower($str2), $percent);

    return $percent;
}

function containsKeywords($str1, $str2)
{
    $words1 = preg_split('/[\s\-\/\(\),&]+/', strtolower($str1));
    $words2 = preg_split('/[\s\-\/\(\),&]+/', strtolower($str2));

    // Remove common words
    $stopWords = ['install', 'repair', 'service', 'the', 'and', 'or', 'a', 'an', 'of', 'to', 'in', 'for'];
    $words1 = array_filter($words1, fn ($w) => strlen($w) > 2 && ! in_array($w, $stopWords));
    $words2 = array_filter($words2, fn ($w) => strlen($w) > 2 && ! in_array($w, $stopWords));

    $common = array_intersect($words1, $words2);

    if (empty($words1) || empty($words2)) {
        return 0;
    }

    return (count($common) / max(count($words1), count($words2))) * 100;
}

echo "=== ANALYZING SIMILAR SUBCATEGORIES ===\n\n";

$totalMatches = 0;
$suggestions = [];

$dbParents = DB::table('categories')->whereNull('parent_id')->get();

foreach ($dbParents as $dbParent) {
    $targetName = $parentMapping[$dbParent->name] ?? $dbParent->name;

    if (! isset($target[$targetName])) {
        continue;
    }

    $dbSubs = DB::table('categories')
        ->where('parent_id', $dbParent->id)
        ->pluck('name', 'id')
        ->toArray();

    $targetSubs = $target[$targetName];

    $matches = [];

    foreach ($dbSubs as $id => $dbSub) {
        $bestMatch = null;
        $bestScore = 0;

        foreach ($targetSubs as $targetSub) {
            // Skip if exact match (already handled)
            if ($dbSub === $targetSub) {
                continue;
            }

            // Calculate similarity
            $simScore = similarity($dbSub, $targetSub);
            $keyScore = containsKeywords($dbSub, $targetSub);

            $avgScore = ($simScore + $keyScore) / 2;

            if ($avgScore > $bestScore && $avgScore >= 40) {
                $bestScore = $avgScore;
                $bestMatch = $targetSub;
            }
        }

        if ($bestMatch) {
            $matches[] = [
                'parent' => $targetName,
                'old' => $dbSub,
                'new' => $bestMatch,
                'score' => round($bestScore),
            ];
            $totalMatches++;
        }
    }

    if (! empty($matches)) {
        $suggestions[$targetName] = $matches;
    }
}

echo "Found $totalMatches potential matches:\n\n";

foreach ($suggestions as $parent => $matches) {
    echo "=== $parent ===\n";
    foreach ($matches as $match) {
        $confidence = $match['score'] >= 70 ? '🟢 HIGH' : ($match['score'] >= 50 ? '🟡 MEDIUM' : '🟠 LOW');
        echo "  [{$match['score']}% $confidence]\n";
        echo "    Old: {$match['old']}\n";
        echo "    New: {$match['new']}\n\n";
    }
}

echo "\n=== STATISTICS ===\n";
echo "Total potential renames: $totalMatches\n";

$highConfidence = 0;
$mediumConfidence = 0;
$lowConfidence = 0;

foreach ($suggestions as $matches) {
    foreach ($matches as $match) {
        if ($match['score'] >= 70) {
            $highConfidence++;
        } elseif ($match['score'] >= 50) {
            $mediumConfidence++;
        } else {
            $lowConfidence++;
        }
    }
}

echo "High confidence (≥70%): $highConfidence\n";
echo "Medium confidence (50-69%): $mediumConfidence\n";
echo "Low confidence (40-49%): $lowConfidence\n";

echo "\n=== IMPACT ===\n";
echo "If we rename these subcategories:\n";
echo "  ✅ SAVED: $totalMatches subcategories with their provider relations\n";

// Calculate how many will still be deleted
$totalToDelete = 0;
foreach ($dbParents as $dbParent) {
    $targetName = $parentMapping[$dbParent->name] ?? $dbParent->name;
    if (! isset($target[$targetName])) {
        continue;
    }

    $dbSubCount = DB::table('categories')->where('parent_id', $dbParent->id)->count();
    $matched = isset($suggestions[$targetName]) ? count($suggestions[$targetName]) : 0;
    $targetCount = count($target[$targetName]);

    $willDelete = $dbSubCount - $matched;
    $totalToDelete += $willDelete;
}

echo "  ❌ DELETED: ~$totalToDelete subcategories (no match found)\n";
echo "  ✅ ADDED: New subcategories without DB match\n";

echo "\n💡 RECOMMENDATION: Add rename mapping to preserve provider relations!\n";
