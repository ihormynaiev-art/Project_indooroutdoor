<?php

namespace App\Providers;

use App\Services\GooglePlacesApi;
use App\Services\Review\GoogleReviewsService;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GooglePlacesApi::class, function ($app) {
            return new GooglePlacesApi;
        });

        $this->app->singleton(GoogleReviewsService::class, function ($app) {
            return new GoogleReviewsService(
                $app->make(GooglePlacesApi::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
