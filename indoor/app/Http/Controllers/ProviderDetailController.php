<?php

namespace App\Http\Controllers;

use App\Contracts\HasReviewDate;
use App\Http\Requests\ProviderDetail\UpdateProviderDetailRequest;
use App\Jobs\OptimizeImageJob;
use App\Models\Category;
use App\Models\ProviderDetail;
use App\Models\ReviewToken;
use App\Models\User;
use App\Services\ProfileViewTracker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProviderDetailController extends Controller
{
    public function __construct(
        private ProfileViewTracker $profileViewTracker
    ) {}

    public function edit(Request $request): View
    {
        $request->user()->load([
            'providerDetail',
            'providerDetail.logo',
            'providerDetail.background',
            'providerDetail.categories',
            'providerDetail.subCategories',
            'providerDetail.portfolioImages',
            'providerDetail.adImages',
        ]);

        /** @var ProviderDetail $providerDetail */
        $providerDetail = $request->user()->providerDetail;

        $categories = Category::with([
            'subCategories' => fn ($q) => $q->where('is_active', true),
        ])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->get();
        $selectedCategories = $providerDetail->categories->pluck('id')->toArray();
        $subCategories = Category::whereNotNull('parent_id')
            ->with(['parent' => function ($query) {
                $query->select('id', 'name');
            }])->whereHas('parent', function ($query) {
                $query->where('is_active', true);
            })
            ->where('is_active', true)
            ->get(['id', 'name', 'parent_id']);

        $logoPath = $providerDetail->logo ?
            url('storage/'.$providerDetail->logo->path) :
            url()->asset('/assets/img/profiles/avatar-02.jpg');

        $backgroundPath = $providerDetail->background ?
            url('storage/'.$providerDetail->background->path) :
            url()->asset('/assets/img/profiles/background.jpg');

        $imagesIdsJson = $providerDetail->portfolioImages()->pluck('id')->toJson();

        return view('provider.details.edit', [
            'user' => $request->user(),
            'categories' => $categories,
            'subCategories' => $subCategories,
            'providerDetail' => $providerDetail,
            'logoPath' => $logoPath,
            'backgroundPath' => $backgroundPath,
            'imagesIdsJson' => $imagesIdsJson,
            'selectedCategories' => $selectedCategories,
            'selectedSubCategories' => $providerDetail->subCategories->pluck('id')->toArray(),
        ]);
    }

    public function editById(Request $request, User $user): View
    {
        $user->load([
            'providerDetail',
            'providerDetail.logo',
            'providerDetail.background',
            'providerDetail.categories',
            'providerDetail.subCategories',
            'providerDetail.portfolioImages',
        ]);

        $providerDetail = $user->providerDetail;

        $categories = Category::with([
            'subCategories' => fn ($q) => $q->where('is_active', true),
        ])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->get();
        $selectedCategories = $providerDetail->categories->pluck('id')->toArray();
        $subCategories = Category::whereNotNull('parent_id')
            ->with(['parent' => function ($query) {
                $query->select('id', 'name');
            }])->whereHas('parent', function ($query) {
                $query->where('is_active', true);
            })
            ->where('is_active', true)
            ->get(['id', 'name', 'parent_id']);

        $logoPath = $providerDetail->logo ?
            url('storage/'.$providerDetail->logo->path) :
            url()->asset('/assets/img/profiles/avatar-02.jpg');

        $backgroundPath = $providerDetail->background ?
            url('storage/'.$providerDetail->background->path) :
            url()->asset('/assets/img/profiles/background.jpg');

        $imagesIdsJson = $providerDetail->portfolioImages()->pluck('id')->toJson();

        return view('provider.details.edit', [
            'user' => $request->user(),
            'categories' => $categories,
            'subCategories' => $subCategories,
            'providerDetail' => $providerDetail,
            'logoPath' => $logoPath,
            'backgroundPath' => $backgroundPath,
            'imagesIdsJson' => $imagesIdsJson,
            'selectedCategories' => $selectedCategories,
            'selectedSubCategories' => $providerDetail->subCategories->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProviderDetail $providerDetail, UpdateProviderDetailRequest $request): RedirectResponse
    {
        $logo = $request->file('logo');
        if ($logo) {
            $filePath = $logo->store('logotypes', 'public');
            $providerDetail->logo()->updateOrCreate([
                'fileable_id' => $providerDetail->id,
                'fileable_type' => get_class($providerDetail),
            ], [
                'name' => $logo->getClientOriginalName(),
                'path' => $filePath,
                'type' => 'logo',
            ]);
        }

        $background = $request->file('background');
        if ($background) {
            $filePath = $background->store('backgrounds', 'public');
            $providerDetail->background()->updateOrCreate([
                'fileable_id' => $providerDetail->id,
                'fileable_type' => get_class($providerDetail),
            ], [
                'name' => $background->getClientOriginalName(),
                'path' => $filePath,
                'type' => 'background',
            ]);
        }

        $providerDetail->categories()->sync($request->input('categories'));
        $providerDetail->subCategories()->sync($request->input('sub_categories'));

        $updateData = [
            'business_name' => $request->input('business_name'),
            'phone' => $request->input('phone'),
            'description' => $request->input('description'),
            'x_url' => $request->input('x_url'),
            'facebook_url' => $request->input('facebook_url'),
            'website_url' => $request->input('website_url'),
            'instagram_url' => $request->input('instagram_url'),
            'youtube_url' => $request->input('youtube_url'),
        ];

        if ($request->user()->hasRole(['admin', 'super admin'])) {
            $updateData['plan_id'] = $request->input('plan_id');
            $providerDetail->user->update(['email' => $request->input('email')]);
        }

        $providerDetail->update($updateData);

        $imagesIds = json_decode($request->input('images'));

        $providerDetail->load('portfolioImages');

        $providerDetail->portfolioImages()->whereNotIn('id', $imagesIds)->delete();

        if ($request->input('order')) {
            $prio = explode(',', $request->input('order'));
            foreach ($prio as $index => $id) {
                if (strpos($id, 'new-') === false) {
                    $image = $providerDetail->portfolioImages->find($id);
                    $image->prio = $index;
                    $image->save();
                } else {
                    $newImageIndex = substr($id, 4);
                    $newImageFile = $request->file('files.'.$newImageIndex);
                    if ($newImageFile) {
                        $filePath = $newImageFile->store('portfolios', 'public');
                        $providerDetail->portfolioImages()->create([
                            'name' => $newImageFile->getClientOriginalName(),
                            'path' => $filePath,
                            'type' => 'portfolio',
                            'prio' => $index,
                        ]);
                    }
                }
            }
            OptimizeImageJob::dispatch($providerDetail);
        }
        $routeName = $request->user()->hasRole(['admin', 'super admin']) ? 'admin.contractors.index' : 'provider.details.edit';
        $status = $request->user()->hasRole(['admin', 'super admin'])
            ? Str::limit($providerDetail->business_name, 15, '...') . ' showcase page has been updated.'
            : 'Success! Your showcase page has been updated.';

        return redirect()->route($routeName)->with('status', $status);
    }

    /**
     * @throws \Exception
     */
    public function show(ProviderDetail $providerDetail): View
    {
        $providerDetail->load([
            'logo',
            'background',
            'user',
            'certificates',
            'adImages',
            'plan',
            'categories' => fn ($q) => $q
                ->orderBy('name')
                ->where('is_active', true)
                ->with([
                    'subCategories' => fn ($sub) => $sub
                        ->where('is_active', true)
                        ->whereHas('providerDetailsForSub', function ($p) use ($providerDetail) {
                            $p->where('provider_detail_id', $providerDetail->id)
                                ->where(function ($cond) {
                                    $today = now()->toDateString();

                                    $cond
                                        ->where('is_license_required', false)
                                        ->orWhere(function ($q2) use ($today) {
                                            $q2->where('is_license_required', true)
                                                ->where('license_expires_on', '>', $today);
                                        });
                                });
                        }),
                ]),
        ]);

        // Filter out categories without subcategories
        $providerDetail->setRelation('categories', $providerDetail->categories->filter(function ($category) {
            return $category->subCategories->isNotEmpty();
        }));

        if ($providerDetail->plan->canShowIndoorOutdoorReviews()) {
            $providerDetail->load(['testimonials' => fn ($q) => $q->orderByDesc('created_at')]);
        }

        if ($providerDetail->plan->canShowGoogleReviews()) {
            $providerDetail->load(['googleReviews' => fn ($q) => $q
                ->where('is_hide', false)
                ->orderByDesc('date')]);
        }

        if ($providerDetail->plan->canShowFacebookReviews()) {
            $providerDetail->load(['facebookReviews' => fn ($q) => $q
                ->where('is_hide', false)
                ->orderByDesc('reviewed_at')]);
        }

        $reviews = collect()
            ->when($providerDetail->plan->canShowIndoorOutdoorReviews(), fn($c) => $c->merge($providerDetail->testimonials))
            ->when($providerDetail->plan->canShowGoogleReviews(), fn($c) => $c->merge($providerDetail->googleReviews))
            ->when($providerDetail->plan->canShowFacebookReviews(), fn($c) => $c->merge($providerDetail->facebookReviews))
            ->sortByDesc(fn (HasReviewDate $review) => $review->getReviewDate())
            ->values();

        $categoriesIds = $providerDetail->categories
            ->pluck('id')
            ->toArray();

        $subcategoriesIds = $providerDetail->categories->flatMap(function (Category $category) {
            return $category->subCategories->pluck('id');
        })->toArray();

        $this->profileViewTracker->track($providerDetail, request());

        $averageRating = $providerDetail->countAvgRating();

        return view('provider.details.show', compact([
            'providerDetail',
            'reviews',
            'categoriesIds',
            'subcategoriesIds',
            'averageRating',
        ]));
    }

    public function removeLogo(ProviderDetail $providerDetail): JsonResponse
    {
        if ($providerDetail->logo) {
            $providerDetail->logo()->delete();
        }

        return response()->json([
            'status' => 'success',
            'imgSrc' => url()->asset('/assets/img/profiles/avatar-02.jpg'),
        ]);
    }

    public function removeBackground(ProviderDetail $providerDetail)
    {
        if ($providerDetail->background) {
            $providerDetail->background()->delete();
        }

        return response()->json([
            'status' => 'success',
            'imgSrc' => url()->asset('/assets/img/profiles/background.jpg'),
        ]);
    }

    public function generateReviewLink(ProviderDetail $providerDetail): JsonResponse
    {
        $token = Str::random(40);
        $expires_at = now()->addWeek();

        ReviewToken::create([
            'provider_detail_id' => $providerDetail->id,
            'token' => $token,
            'expires_at' => $expires_at,
        ]);

        $link = route('testimonials.create', ['providerDetail' => $providerDetail->id, 'token' => $token]);

        $message = "Thank you for choosing $providerDetail->business_name!\nWe’d love to hear about your experience. Your feedback helps us improve and helps others find us. It only takes a minute! Here's the link:\n$link \nThanks so much for your support!";

        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }
}
