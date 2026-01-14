<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMailSettingsRequest;
use App\Settings\MailSetting;
use Illuminate\Http\RedirectResponse;

class MailSettingsController extends Controller
{
    public function edit(MailSetting $mailSetting): \Illuminate\View\View
    {
        return view('admin.settings.mail-settings', ['emails' => $mailSetting->emails_for_new_registered]);
    }

    public function update(UpdateMailSettingsRequest $request, MailSetting $mailSetting): RedirectResponse
    {
        $mailSetting->emails_for_new_registered = $request->input(['email']);
        $mailSetting->save();

        return redirect()->route('admin.settings.mail.edit');
    }
}
