<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\FacebookReview;
use App\Models\GoogleReview;
use App\Models\ProviderMessage;
use App\Models\Testimonial;
use App\Observers\CategoryObserver;
use App\Policies\FacebookReviewPolicy;
use App\Policies\GoogleReviewPolicy;
use App\Policies\ProviderMessagePolicy;
use App\Policies\TestimonialPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
        Gate::policy(Testimonial::class, TestimonialPolicy::class);
        Gate::policy(GoogleReview::class, GoogleReviewPolicy::class);
        Gate::policy(FacebookReview::class, FacebookReviewPolicy::class);
        Gate::policy(ProviderMessage::class, ProviderMessagePolicy::class);
        //        URL::forceScheme('https');
    }
}
