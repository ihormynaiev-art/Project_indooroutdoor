<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\VerifyEmailCustom;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::getHomePage());
        }

        $this->sendVerificationEmail();

        return back()->with('status', 'verification-link-sent');
    }

    protected function sendVerificationEmail()
    {
        request()->user()->notify(new VerifyEmailCustom);
    }
}
