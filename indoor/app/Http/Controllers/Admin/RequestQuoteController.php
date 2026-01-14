<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RequestQuote\RequestQuoteStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestQuoteRequest;
use App\Http\Requests\UpdateRequestQuoteRequest;
use App\Jobs\SendAdminRequestQuote;
use App\Jobs\SendQuoteNotificationJob;
use App\Models\ProviderDetail;
use App\Models\RequestQuote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RequestQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = RequestQuote::query()
                ->with('provider')
                ->orderBy('created_at', 'desc');

            if ($request->has('provider_filter')) {
                if ($request->provider_filter === 'with_provider') {
                    $query->whereNotNull('provider_id');
                } elseif ($request->provider_filter === 'without_provider') {
                    $query->whereNull('provider_id');
                }
            }

            return DataTables::of($query)
                ->editColumn('created_at', function ($requestQuote) {
                    return $requestQuote->created_at->format('m/d/Y');
                })
                ->editColumn('available_at', function ($requestQuote) {
                    return $requestQuote->available_at
                        ? $requestQuote->available_at->format('m/d/Y H:i')
                        : null;
                })
                ->make();
        }

        return view('admin.requestQuotes.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestQuoteRequest $request): JsonResponse
    {
        $availableAt = null;

        // Calculate available_at based on provider's plan
        if ($request->input('provider_id')) {
            /** @var ProviderDetail $provider */
            $provider = ProviderDetail::query()->with('plan')->find($request->input('provider_id'));

            if ($provider && $provider->plan) {
                $delayHours = $provider->plan->getLimit('lead_delay_hours', 0);
                if ($delayHours > 0) {
                    $availableAt = now()->addHours($delayHours);
                }
            }
        }

        $requestQuote = RequestQuote::query()
            ->create([
                'category_id' => $request->input('category_id'),
                'sub_category_id' => $request->input('sub_category_id'),
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'city' => $request->input('city'),
                'processed' => boolval($request->input('provider_id')),
                'contact_number' => $request->input('contact_number'),
                'state' => $request->input('state'),
                'zipcode' => $request->input('zipcode'),
                'details' => $request->input('details'),
                'provider_id' => $request->input('provider_id'),
                'available_at' => $availableAt,
                'status' => RequestQuoteStatusEnum::NEW->value,
            ]);

        $files = $request->file('documents');
        if ($files) {
            foreach ($files as $file) {
                $filePath = $file->store('request-quote/documents', 'public');
                $requestQuote->documents()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'type' => 'document',
                ]);
            }
        }

        SendAdminRequestQuote::dispatch(
            $requestQuote,
        );

        // Send delayed notification to provider if there's a delay
        if ($request->input('provider_id')) {
            if ($availableAt) {
                // Dispatch job with delay
                SendQuoteNotificationJob::dispatch($requestQuote)
                    ->delay($availableAt);
            } else {
                // Send immediately
                SendQuoteNotificationJob::dispatch($requestQuote);
            }
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestQuote $requestQuote)
    {
        $requestQuote->load(['category', 'subCategory', 'provider']);

        $providers = ProviderDetail::query()
            ->whereHas('user', function ($query) {
                $query
                    ->whereNotNull('email_verified_at')
                    ->where('is_verified', true);
            })
            ->get();

        return view('admin.requestQuotes.show', [
            'providers' => $providers,
            'requestQuote' => $requestQuote,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequestQuoteRequest $request, RequestQuote $requestQuote)
    {
        $oldProviderId = $requestQuote->getOriginal('provider_id');

        $requestQuote->update($request->validated());

        if (is_null($oldProviderId) && !is_null($requestQuote->provider_id)) {
            SendQuoteNotificationJob::dispatch($requestQuote);
        }

        return to_route('admin.requestQuotes.show', $requestQuote);
    }

    /**
     * Toggle the processed status of the request quote.
     */
    public function toggleProcessed(RequestQuote $requestQuote)
    {
        $requestQuote->processed = ! $requestQuote->processed;
        $requestQuote->save();

        return response()->json([
            'status' => 'success',
            'processed' => $requestQuote->processed,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestQuote $requestQuote)
    {
        $requestQuote->delete();

        return response()->json(['status' => 'success']);
    }
}
