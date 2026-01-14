<?php

namespace App\Http\Controllers;

use App\Models\ProviderDetail;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')
            ->scopes(['pages_show_list', 'pages_read_engagement', 'pages_read_user_content'])
            ->redirect();
    }

    public function callback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = Auth::user();

        $user->providerDetail->update([
            'facebook_id' => $fbUser->getId(),
            'facebook_token' => $fbUser->token,
        ]);

        return redirect()->route('provider.reviews.settings.edit')
            ->with('success', 'Facebook connected successfully!');
    }

    public function disconnect(ProviderDetail $providerDetail)
    {
        $providerDetail->facebook_last_request_at = null;
        $providerDetail->facebook_id = null;
        $providerDetail->facebook_token = null;
        $providerDetail->facebook_page_id = null;
        $providerDetail->facebook_page_token = null;
        $providerDetail->facebook_page_name = null;

        $providerDetail->facebookReviews()->delete();

        $providerDetail->save();

        return redirect()->route('provider.reviews.settings.edit')
            ->with('success', 'Facebook disconnected successfully!');
    }
}
