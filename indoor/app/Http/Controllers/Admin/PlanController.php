<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::of(Plan::query()->orderBy('sort_order'))->make();
        }

        return view('admin.plans.index');
    }

    public function edit(Plan $plan): View
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Plan $plan, UpdatePlanRequest $request)
    {
        $config = [
            'features' => [
                'max_portfolio_photos' => (int) $request->input('config.features.max_portfolio_photos'),
                'show_map' => (bool) $request->input('config.features.show_map', false),
                'show_promo_block' => (bool) $request->input('config.features.show_promo_block', false),
                'seo_follow' => (bool) $request->input('config.features.seo_follow', false),
                'search_priority' => (bool) $request->input('config.features.search_priority', false),
                'landing' => (bool) $request->input('config.features.landing', false),
            ],
            'reviews' => [
                'indooroutdoor' => (bool) $request->input('config.reviews.indooroutdoor', false),
                'google' => (bool) $request->input('config.reviews.google', false),
                'facebook' => (bool) $request->input('config.reviews.facebook', false),
            ],
            'contact_buttons' => [
                'message_provider' => (bool) $request->input('config.contact_buttons.message_provider', false),
                'request_quote' => (bool) $request->input('config.contact_buttons.request_quote', false),
                'share_profile' => (bool) $request->input('config.contact_buttons.share_profile', false),
            ],
            'ad_buttons' => [
                'view_ad' => (bool) $request->input('config.ad_buttons.view_ad', false),
                'view_magazine' => (bool) $request->input('config.ad_buttons.view_magazine', false),
            ],
            'limits' => [
                'lead_delay_hours' => (int) $request->input('config.limits.lead_delay_hours'),
            ],
            'admin' => [
                'requires_approval' => (bool) $request->input('config.admin.requires_approval', false),
                'auto_publish' => (bool) $request->input('config.admin.auto_publish', false),
            ],
        ];

        $plan->update([
            'display_name' => $request->input('display_name'),
            'is_active' => (bool) $request->input('is_active', true),
            'sort_order' => (int) $request->input('sort_order', 0),
            'config' => $config,
        ]);

        return to_route('admin.plans.edit', ['plan' => $plan])
            ->with('status', "Plan '{$plan->display_name}' has been updated successfully.");
    }
}
