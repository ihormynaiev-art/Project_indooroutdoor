<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoriesComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $categories = Cache::rememberForever('categories.menu', function () {
            return Category::with([
                'subCategories' => fn ($q) => $q->where('is_active', true),
                'subCategories.parent' => fn ($q) => $q->where('is_active', true),
            ])
                ->where('is_active', true)
                ->whereNull('parent_id')
                ->orderBy('prio')
                ->orderBy('name')
                ->get();
        });

        $view->with('menuCategories', $categories);
    }
}
