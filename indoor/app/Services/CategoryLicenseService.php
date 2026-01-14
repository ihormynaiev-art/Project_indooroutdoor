<?php

namespace App\Services;

use App\Models\Category;
use App\Models\ProviderDetail;
use Carbon\Carbon;

class CategoryLicenseService
{
    public function getByProvider(ProviderDetail $provider)
    {
        $categories = Category::query()
            ->where('is_active', 1)
            ->whereHas('providerDetails', function ($query) use ($provider) {
                $query->where('provider_details.id', $provider->id);
            })
            ->with([
                'subCategories' => function ($query) use ($provider) {
                    $query
                        ->where('is_active', 1)
                        ->whereHas('providerDetailsForSub', function ($q) use ($provider) {
                            $q->where('provider_details.id', $provider->id);
                        })
                        ->with(['providerDetailsForSub' => function ($q) use ($provider) {
                            $q->select('provider_details.id')->where('provider_details.id', $provider->id);
                        }]);
                },
            ])
            ->get();

        return $categories->each(function (Category $category) {
            $category->subCategories->each(function (Category $sub) {

                $pivot = $sub->providerDetailsForSub->first()->pivot ?? null;

                $sub->pivot_id = $pivot?->id;
                $sub->license_verified_at = $pivot?->license_verified_at
                    ? Carbon::create($pivot?->license_verified_at)->format('m/d/Y')
                    : '';
                $sub->license_expires_on = $pivot?->license_expires_on
                    ? Carbon::create($pivot?->license_expires_on)->format('m/d/Y')
                    : '';
            });
        });
    }

    public function countUnverified(ProviderDetail $provider): int
    {
        return $provider->subCategories()
            ->where('categories.is_license_required', true)
            ->where(function ($query) {
                $query->whereNull('provider_detail_sub_category.license_verified_at')
                    ->orWhere('provider_detail_sub_category.license_expires_on', '<', Carbon::now());
            })
            ->distinct()
            ->count();
    }
}
