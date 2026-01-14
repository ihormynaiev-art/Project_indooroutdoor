<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleReviewToggleRequest;
use App\Models\FacebookReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class FacebookReviewController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $providerDetail = $request->user()->providerDetail;

        if ($request->ajax()) {
            return DataTables::of(
                FacebookReview::query()
                    ->where('provider_detail_id', $providerDetail->id)
                    ->latest('reviewed_at')
            )->editColumn('reviewed_at', function ($message) {
                return $message->reviewed_at->format('d M Y');
            })->make();
        }

        return view('provider.facebook-reviews.index', ['providerDetail' => $providerDetail]);
    }

    public function show(FacebookReview $facebookReview, Request $request)
    {
        if ($request->user()->cannot('view', $facebookReview)) {
            abort(403);
        }

        return view('provider.facebook-reviews.show', compact('facebookReview'));
    }

    public function toggle(GoogleReviewToggleRequest $request)
    {
        FacebookReview::query()
            ->where('id', $request->id)
            ->update(['is_hide' => ! $request->show]);

        return response()->json(['status' => 'success']);
    }
}
