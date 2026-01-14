<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SearchAutocompleteController extends Controller
{
    public function __invoke(Request $request): void
    {
        if (! empty($search = $request->get('query'))) {
            $categories = Category::query()
                ->where('name', 'like', '%'.$search.'%')
                ->orderBy('prio')
                ->orderBy('name')
                ->where('is_active', true)
                ->limit(10)
                ->get();

            $output = '';
            if (! empty($categories->count())) {
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($categories as $category) {
                    if (empty($category->parent_id)) {
                        $output .= '<li><a href="'.route('catalog.index', ['categories' => [$category->slug]]).'">'.$category->name.'</a></li>';
                    } else {
                        $output .= '<li><a href="'.route('catalog.index', ['sub_categories' => [$category->id]]).'">'.$category->name.'</a></li>';
                    }
                }
                $output .= '</ul>';
            }

            echo $output;
        }
    }
}
