<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestimonialRequest;
use App\Jobs\NewReview;
use App\Models\ProviderDetail;
use App\Models\ReviewToken;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $providerDetail = $request->user()->providerDetail;

        if ($request->ajax()) {
            return DataTables::of(Testimonial::query()->where('provider_detail_id', $providerDetail->id))->make();
        }

        return view('provider.testimonials.index', ['providerDetail' => $providerDetail]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProviderDetail $providerDetail, string $token, Request $request)
    {
        $providerDetail->load('user');
        $reviewToken = ReviewToken::where('token', $token)->where('provider_detail_id', $providerDetail->id)->first();

        if (! $reviewToken || $reviewToken->expires_at < now()) {
            return redirect()->route('index')->with('error', 'This review link is no longer valid.');
        }

        return view('provider.testimonials.create', compact('providerDetail', 'reviewToken'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $token, StoreTestimonialRequest $request): JsonResponse
    {
        $reviewToken = ReviewToken::where('token', $token)->first();

        $providerDetail = ProviderDetail::with(['user'])->find($request->input('provider_detail_id'));

        if (! $reviewToken || $reviewToken->expires_at < now()) {
            return response()->json([
                'status' => 'error',
                'message' => 'This review link is no longer valid.',
            ], 422);
        }

        $testimonial = Testimonial::create([
            'provider_detail_id' => $request->input('provider_detail_id'),
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'review' => $request->input('review'),
            'email' => $request->input('email'),
            'nickname' => $request->input('nickname'),
            'would_recommend' => $request->input('would_recommend'),
        ]);

        $files = $request->file('files');
        if ($files && $testimonial) {
            foreach ($files as $file) {
                $mime = $file->getMimeType();
                if ($mime == 'video/mp4') {
                    $filePath = $file->store('testimonial_video', 'public');
                    $testimonial->videos()->create([
                        'name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                        'type' => 'video',
                    ]);
                } else {
                    $filePath = $file->store('testimonial_images', 'public');
                    $testimonial->images()->create([
                        'name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                    ]);
                }
            }
        }
        NewReview::dispatch($providerDetail->user);
        $reviewToken->delete();

        return response()->json(['status' => 'success']);
    }

    public function show(Testimonial $testimonial, Request $request)
    {
        if ($request->user()->cannot('view', $testimonial)) {
            abort(403);
        }
        $testimonial->load('images', 'videos');

        return view('provider.testimonials.show', compact('testimonial'));
    }
}
