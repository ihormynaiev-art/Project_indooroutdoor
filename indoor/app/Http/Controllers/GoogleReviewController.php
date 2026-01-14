<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleReviewToggleRequest;
use App\Models\GoogleReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class GoogleReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $providerDetail = $request->user()->providerDetail;

        if ($request->ajax()) {
            return DataTables::of(
                GoogleReview::query()
                    ->where('place_id', $providerDetail->google_place_id)
                    ->latest('date')
            )->editColumn('date', function ($message) {
                return $message->date->format('d M Y');
            })->make();
        }

        return view('provider.google-reviews.index', ['providerDetail' => $providerDetail]);
    }

    public function show(GoogleReview $googleReview, Request $request)
    {
        if ($request->user()->cannot('view', $googleReview)) {
            abort(403);
        }

        return view('provider.google-reviews.show', compact('googleReview'));
    }

    public function toggle(GoogleReviewToggleRequest $request)
    {
        GoogleReview::query()
            ->where('id', $request->id)
            ->update(['is_hide' => ! $request->show]);

        return response()->json(['status' => 'success']);
    }
}
