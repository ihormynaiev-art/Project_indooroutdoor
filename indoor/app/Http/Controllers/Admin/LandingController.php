<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Landing\StoreLandingRequest;
use App\Http\Requests\Landing\UpdateLandingRequest;
use App\Models\Landing;
use App\Models\ProviderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                User::query()
                    ->with(['providerDetail.landing', 'providerDetail.plan'])
                    ->role('provider')
                    ->whereHas('providerDetail.plan', function ($query) {
                        $query->whereRaw("JSON_EXTRACT(config, '$.features.landing') = true");
                    })
                    ->orderBy('created_at', 'desc')
            )->editColumn('created_at', function ($message) {
                return $message->created_at?->format('m/d/Y');
            })->make();
        }

        return view('admin.landings.index');
    }

    public function create(ProviderDetail $providerDetail)
    {
        $providerDetail->load('portfolioImages');

        return view('admin.landings.create', compact('providerDetail'));
    }

    public function store(StoreLandingRequest $request)
    {
        $landing = Landing::query()
            ->create([
                'provider_detail_id' => $request->input('provider_detail_id'),
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'is_published' => $request->boolean('is_published'),
                'custom_description' => $request->input('custom_description'),
                'use_custom_description' => $request->boolean('use_custom_description'),
                'use_custom_portfolio' => $request->boolean('use_custom_portfolio'),
            ]);

        // Save hero image
        if ($request->hasFile('hero_image')) {
            $heroFile = $request->file('hero_image');
            $heroPath = $heroFile->store("landings/{$landing->id}/hero", 'public');

            $landing->heroImage()->create([
                'name' => $heroFile->getClientOriginalName(),
                'path' => $heroPath,
                'type' => 'hero_image',
                'prio' => 0,
            ]);
        }

        // Save offer image
        if ($request->hasFile('offer_image')) {
            $offerFile = $request->file('offer_image');
            $offerPath = $offerFile->store("landings/{$landing->id}/offer", 'public');

            $landing->offerImage()->create([
                'name' => $offerFile->getClientOriginalName(),
                'path' => $offerPath,
                'type' => 'offer_image',
                'prio' => 0,
            ]);
        }

        // Save portfolio images if custom portfolio is enabled
        if ($request->boolean('use_custom_portfolio') && $request->hasFile('portfolio_images')) {
            foreach ($request->file('portfolio_images') as $index => $portfolioFile) {
                $portfolioPath = $portfolioFile->store("landings/{$landing->id}/portfolio", 'public');

                $landing->portfolioImages()->create([
                    'name' => $portfolioFile->getClientOriginalName(),
                    'path' => $portfolioPath,
                    'type' => 'portfolio',
                    'prio' => $index,
                ]);
            }
        }

        return redirect()
            ->route('admin.landings.edit', $landing)
            ->with('status', 'Landing created successfully.');
    }

    public function edit(Landing $landing)
    {
        $landing->load(['heroImage', 'offerImage', 'portfolioImages', 'providerDetail.portfolioImages']);

        return view('admin.landings.edit', [
            'landing' => $landing,
            'providerDetail' => $landing->providerDetail,
        ]);
    }

    public function update(Landing $landing, UpdateLandingRequest $request)
    {
        $landing->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'is_published' => $request->boolean('is_published'),
            'custom_description' => $request->input('custom_description'),
            'use_custom_description' => $request->boolean('use_custom_description'),
            'use_custom_portfolio' => $request->boolean('use_custom_portfolio'),
        ]);

        // Delete hero image if marked for deletion
        if ($request->filled('delete_hero_image') && $landing->heroImage) {
            $landing->heroImage->delete();
        }

        // Update hero image if new file uploaded
        if ($request->hasFile('hero_image')) {
            // Delete old hero image if exists
            if ($landing->heroImage) {
                $landing->heroImage->delete();
            }

            $heroFile = $request->file('hero_image');
            $heroPath = $heroFile->store("landings/{$landing->id}/hero", 'public');

            $landing->heroImage()->create([
                'name' => $heroFile->getClientOriginalName(),
                'path' => $heroPath,
                'type' => 'hero_image',
                'prio' => 0,
            ]);
        }

        // Delete offer image if marked for deletion
        if ($request->filled('delete_offer_image') && $landing->offerImage) {
            $landing->offerImage->delete();
        }

        // Update offer image if new file uploaded
        if ($request->hasFile('offer_image')) {
            // Delete old offer image if exists
            if ($landing->offerImage) {
                $landing->offerImage->delete();
            }

            $offerFile = $request->file('offer_image');
            $offerPath = $offerFile->store("landings/{$landing->id}/offer", 'public');

            $landing->offerImage()->create([
                'name' => $offerFile->getClientOriginalName(),
                'path' => $offerPath,
                'type' => 'offer_image',
                'prio' => 0,
            ]);
        }

        // Handle portfolio images
        if ($request->boolean('use_custom_portfolio')) {
            // Get remaining portfolio image IDs from hidden field
            $remainingIds = json_decode($request->input('portfolio_images_ids', '[]'), true);

            // Delete portfolio images that were removed
            $landing->portfolioImages()->whereNotIn('id', $remainingIds)->delete();

            // Add new portfolio images if uploaded
            if ($request->hasFile('portfolio_images')) {
                $existingCount = count($remainingIds);

                foreach ($request->file('portfolio_images') as $index => $portfolioFile) {
                    $portfolioPath = $portfolioFile->store("landings/{$landing->id}/portfolio", 'public');

                    $landing->portfolioImages()->create([
                        'name' => $portfolioFile->getClientOriginalName(),
                        'path' => $portfolioPath,
                        'type' => 'portfolio',
                        'prio' => $existingCount + $index,
                    ]);
                }
            }
        } else {
            // If custom portfolio is disabled, delete all portfolio images
            $landing->portfolioImages()->delete();
        }

        return redirect()
            ->route('admin.landings.edit', $landing)
            ->with('status', 'Landing updated successfully.');
    }

    public function destroy(Landing $landing)
    {
        $landing->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Landing deleted successfully.',
        ]);
    }
}
