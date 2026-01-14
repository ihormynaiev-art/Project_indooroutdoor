<?php

namespace App\View\Composers;

use App\Models\Magazine;
use Illuminate\View\View;

class EditionComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $magazine = Magazine::where('is_active', true)
            ->orderBy('prio')
            ->first();

        $view->with('menuMagazine', $magazine);
    }
}
