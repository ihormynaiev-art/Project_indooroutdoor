<?php

namespace App\Providers;

use App\View\Composers\CategoriesComposer;
use App\View\Composers\EditionComposer;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composers([
            CategoriesComposer::class => 'layout.partials.header',
            EditionComposer::class => 'layout.partials.header',
        ]);
    }
}
