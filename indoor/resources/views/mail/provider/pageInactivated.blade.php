<x-mail::message>
{{ $user->name }},<br>
The contractor page for {{ $user->providerDetail->business_name }} is now inactive.<br>
Contact your account representative to activate.

If you have any thoughts on how to improve the contractor page experience for both the homeowner and
contractor - I'm open to suggestions.

{{ config('app.name') }}
</x-mail::message>
