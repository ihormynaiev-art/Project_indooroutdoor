<?php

namespace App\View\Components\Nav\Provider;

use App\Services\CategoryLicenseService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Licenses extends Component
{
    public int $unverifiedLicenses;
    /**
     * Create a new component instance.
     */
    public function __construct(protected CategoryLicenseService  $categoryLicenseService)
    {
        $this->unverifiedLicenses = $this->categoryLicenseService
            ->countUnverified(auth()->user()->providerDetail);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav.provider.licenses');
    }
}
