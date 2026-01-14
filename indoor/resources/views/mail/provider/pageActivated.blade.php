<x-mail::message>
{{ $user->name }},<br>
Congratulations, the contractor page for {{ $user->providerDetail?->business_name }} has been created on
{{ route('index') }}<br>
As a valued IndoorOutdoor Resource advertising partner, your custom contractor page is provided as
part of your advertising plan.

You can access your contractor page and begin customization through the link below.<br>
{{ route('profile.edit') }}<br>
Customize Your Page Now!<br>
What you need to do once logged in.<br>
• Select all the categories of service that your business offers.<br>
• Provide contact information and add a description of your business and its services.<br>
• Upload images of your work for the portfolio portion of your page.<br>
• Upload customer testimonials.<br>
• Upload all applicable licenses and insurance information for your business.<br>
For support, Click here.

{{ config('app.name') }}
</x-mail::message>
