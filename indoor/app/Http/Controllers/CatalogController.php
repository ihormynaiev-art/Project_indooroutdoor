<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProviderDetail;
use App\Services\SearchTrackingService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CatalogController extends Controller
{
    public function __construct(
        private SearchTrackingService $searchTrackingService
    ) {}

    public function index(Request $request)
    {
        $categories = $request->input('categories', []);
        $subCategories = $request->input('sub_categories', []);
        $search = $request->input('search');
        $searchResponse = false;
        $emptySearch = false;
        if ((empty($categories) && empty($subCategories) && empty($search))) {
            $providers = new LengthAwarePaginator([], 0, 12);
            $emptySearch = true;
        } else {
            $query = ProviderDetail::select('provider_details.*')
                ->with('portfolioImages')
                ->leftJoin('plans', 'provider_details.plan_id', '=', 'plans.id')
                ->whereHas('user', fn ($q) => $q->where('is_verified', true))
                ->withAvg('testimonials', 'rating');

            if ($request->has('categories')) {
                $query->whereHas('categories', fn ($q) => $q->whereIn('slug', $request->input('categories')));
                $searchResponse = true;
            }

            if ($request->has('sub_categories')) {
                $query->whereHas('subCategories', fn ($q) => $q->whereIn('categories.id', $request->input('sub_categories')));

                $categorySlugs = $request->input('categories', []);
                $parentSlugs = $this->getParentSlug($request->input('sub_categories'))->toArray();
                $request->merge(['categories' => array_merge($categorySlugs, $parentSlugs)]);
                $searchResponse = true;
            }

            if ($request->input('categories')) {
                $this->addSelectionsByCategorySlugs($request->input('categories'));
                $searchResponse = true;
            }

            if ($request->has('rating')) {
                $query->havingRaw($this->buildRatingHavingRaw($request->input('rating')));
                $searchResponse = true;
            }

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%'.$request->search.'%')
                        ->orWhere('business_name', 'like', '%'.$request->search.'%')
                        ->orWhereHas('user', function ($q1) use ($request) {
                            $q1->where('name', 'like', '%'.$request->search.'%');
                        })->orWhereHas('categories', function ($q1) use ($request) {
                            $q1->where('name', 'like', '%'.$request->search.'%');
                        })->orWhereHas('subCategories', function ($q1) use ($request) {
                            $q1->where('name', 'like', '%'.$request->search.'%');
                        });
                });

                $searchResponse = true;
            }

            $providers = $query
                ->orderByRaw("COALESCE(JSON_EXTRACT(plans.config, '$.features.search_priority'), 0) DESC")
                ->orderBy('provider_details.business_name', $request->query('sort', 'asc'))
                ->paginate(12);

            // Track search appearances - record all providers visible on this page
            if ($providers->count() > 0) {
                $providerIds = $providers->pluck('id')->toArray();
                $this->searchTrackingService->trackMultipleAppearances($providerIds, $request);
            }
        }

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

        $subCategories = $categories->flatMap(function ($category) {
            return $category->subCategories;
        })->sortBy('prio')->sortBy('name');

        $currentQueryParams = request()->query();
        $newQueryParams = collect($currentQueryParams)->except('sort');

        $sortArr = [
            'asc' => [
                'name' => 'A -> Z',
                'href' => route('catalog.index', $newQueryParams->merge(['sort' => 'asc'])->toArray()),
            ],
            'desc' => [
                'name' => 'Z -> A',
                'href' => route('catalog.index', $newQueryParams->merge(['sort' => 'desc'])->toArray()),
            ],
        ];

        return view('catalog', [
            'providers' => $providers,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'emptySearch' => $emptySearch,
            'sortArr' => $sortArr,
            'searchResponse' => $searchResponse,
        ]);
    }

    public function getParentSlug($ids)
    {
        return Category::whereHas('subCategories', fn ($q) => $q->whereIn('id', $ids))
            ->pluck('slug');
    }

    protected function buildRatingHavingRaw($ratings): string
    {
        $conditions = [];
        foreach ($ratings as $rating) {
            if ($rating == 5) {
                $conditions[] = 'testimonials_avg_rating = 5';
            } else {
                $conditions[] = '(testimonials_avg_rating >= '.($rating - 0.5).' AND testimonials_avg_rating < '.($rating + 0.5).')';
            }
        }

        return implode(' OR ', $conditions);
    }

    protected function addSelectionsByCategorySlugs(array $categoriesSlugs): static
    {
        Category::whereIn('slug', $categoriesSlugs)->increment('selections');

        return $this;
    }
}
