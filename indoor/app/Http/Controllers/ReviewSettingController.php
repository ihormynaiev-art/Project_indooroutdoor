<?php

namespace App\Http\Controllers;

use App\Models\ProviderDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ReviewSettingController extends Controller
{
    public function edit(Request $request): View
    {
        /** @var ProviderDetail $providerDetail */
        $providerDetail = $request->user()->providerDetail;

        $facebookPages = [];
        if (config('services.facebook.client_id') && config('services.facebook.client_secret')) {
            if ($providerDetail->facebook_token && ! $providerDetail->facebook_page_id) {
                $response = Http::get('https://graph.facebook.com/me/accounts', [
                    'access_token' => $providerDetail->facebook_token,
                ]);

                $facebookPages = $response->json('data', []);
            }
        }

        return view('provider.reviews.settings.edit', [
            'user' => $request->user(),
            'providerDetail' => $providerDetail,
            'facebookPages' => $facebookPages,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProviderDetail $providerDetail, Request $request): RedirectResponse
    {
        $providerDetail->update([
            'google_place_id' => $request->input('google_place_id'),
            'google_formatted_address' => $request->input('google_formatted_address'),
            'facebook_page_id' => $request->input('facebook_page_id'),
            'facebook_page_token' => $request->input('facebook_page_token'),
            'facebook_page_name' => $request->input('facebook_page_name'),
        ]);

        $routeName = $request->user()->hasRole(['admin', 'super admin'])
            ? 'admin.users.index'
            : 'provider.reviews.settings.edit';

        $status = $request->user()->hasRole(['admin', 'super admin'])
            ? $providerDetail->business_name.' review settings has been updated.'
            : 'Success! Your review settings has been updated.';

        return redirect()->route($routeName)->with('status', $status);
    }
}
