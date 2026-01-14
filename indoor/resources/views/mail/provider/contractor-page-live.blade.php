<x-mail::message>
# Your Contractor Page is Now Live on IndoorOutdoor!

Hi {{ $user->name }},

Great news—your contractor page on IndoorOutdoor is now live!

Homeowners can now view your profile, explore your services, and reach out directly for quotes. Be sure to check your page and make any updates or enhancements as needed to help put your best foot forward.

<x-mail::button :url="$pageUrl">
View your page
</x-mail::button>

If you have any questions or need help optimizing your listing, we're here to help.

Thanks again for joining the IndoorOutdoor Resource—where Michigan homeowners find trusted professionals.

{{ config('app.name') }}
</x-mail::message>
