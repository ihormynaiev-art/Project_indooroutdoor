<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = json_decode(file_get_contents(public_path('/assets/json/categories.json')));
        foreach ($categories as $category) {
            $icon = file_get_contents($category->icon);
            $slug = Str::slug($category->name);
            $iconPath = 'categoryIcons/'.$slug.'.svg';
            Storage::disk('public')->put($iconPath, $icon);

            $result = Category::firstOrCreate([
                'name' => $category->name,
                'slug' => Str::slug($category->name),
                'prio' => 1,
                'icon_path' => $iconPath,
            ]);

            foreach ($category->subCategories as $subCategory) {
                $icon = file_get_contents($subCategory->icon);
                $slug = Str::slug($subCategory->name);
                $iconPath = 'categoryIcons/'.$slug.'.svg';
                Storage::disk('public')->put($iconPath, $icon);
                $subCategory = Category::firstOrCreate([
                    'name' => $subCategory->name,
                    'slug' => Str::slug($subCategory->name),
                    'prio' => 1,
                    'icon_path' => $iconPath,
                ]);
                $subCategory->parent_id = $result->id;
            }
        }

    }
}
