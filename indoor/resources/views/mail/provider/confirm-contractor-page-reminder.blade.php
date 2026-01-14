<x-mail::message>
# Reminder: Confirm Your Contractor Page on IndoorOutdoor

Hi {{ $user->name }},

Thanks for signing up to create your contractor page on IndoorOutdoor—you're just one quick step away from going live!

To complete your registration, please confirm your email address by clicking the verification link:


@component('mail::button', ['url' => $verificationUrl])
    Verify Email
@endcomponent

✅ Once you verify, we'll review your listing and publish it so homeowners can start connecting with you.

Need us to resend the verification email? Just reply to this message and we'll take care of it.

Looking forward to getting you live on the site!

{{ config('app.name') }}
</x-mail::message>
