<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProviderDetail;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $users = User::with(['roles', 'providerDetail'])->get();
        $providersCount = $users->filter(
            fn ($user) => $user->roles->where('name', 'provider')->toArray()
        )->count();

        $homeownersCount = $users->filter(fn ($user) => $user->roles->isEmpty())->count();
        $visitors = Visit::count();

        $categoriesData = Category::query()
            ->whereNull('parent_id')
            ->withCount('providerDetails')
            ->get();

        $providersData = ProviderDetail::query()
            ->select([
                'provider_details.id',
                'provider_details.business_name',
                DB::raw('COUNT(profile_views.id) as views'),
            ])
            ->leftJoin('profile_views', 'provider_details.id', '=', 'profile_views.provider_detail_id')
            ->groupBy('provider_details.id', 'provider_details.business_name')
            ->get();

        return view('admin.index', compact(
            'providersCount',
            'homeownersCount',
            'visitors',
            'categoriesData',
            'providersData'
        ));
    }
}
