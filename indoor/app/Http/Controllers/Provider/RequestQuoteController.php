<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestQuote\UpdateRequestQuoteRequest;
use App\Models\RequestQuote;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RequestQuoteController extends Controller
{
    /**
     * Display a listing of the resource for the provider.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = RequestQuote::query()
                ->where('provider_id', auth()->user()->providerDetail->id)
                ->availableToProvider()
                ->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->editColumn('status', function ($requestQuote) {
                    return $requestQuote->status->name();
                })
                ->editColumn('created_at', function ($message) {
                    return $message->created_at?->format('m/d/Y');
                })
                ->make();
        }

        return view('provider.requestQuotes.index');
    }

    /**
     * Display the specified resource for the provider.
     */
    public function show(RequestQuote $requestQuote)
    {
        // Check if the request quote belongs to the authenticated provider
        if ($requestQuote->provider_id !== auth()->user()->providerDetail->id) {
            abort(403, 'Unauthorized action.');
        }

        $requestQuote->load(['category', 'subCategory']);

        $requestQuote->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return view('provider.requestQuotes.show', [
            'requestQuote' => $requestQuote,
        ]);
    }

    public function update(RequestQuote $requestQuote, UpdateRequestQuoteRequest $request)
    {
        if ($requestQuote->provider_id !== auth()->user()->providerDetail->id) {
            abort(403, 'Unauthorized action.');
        }

        $requestQuote->update($request->validated());

        return to_route('provider.request-quotes.show', ['request_quote' => $requestQuote])
            ->with('status', 'Request Quote updated successfully.');
    }
}
