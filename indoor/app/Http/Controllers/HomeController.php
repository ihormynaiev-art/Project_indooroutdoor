<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HomePageLogo;
use App\Settings\GeneralSettings;

class HomeController extends Controller
{
    public function index(GeneralSettings $settings)
    {
        $logos = HomePageLogo::query()
            ->with('file')
            ->where('is_active', true)
            ->orderBy('prio')
            ->get();

        $topCategories = Category::query()
            ->where('is_active', true)
            ->where('show_in_home_top_slider', true)
            ->orderBy('prio')
            ->get();

        return view('index', compact(['topCategories', 'logos', 'settings']));
    }
}
