<x-mail::message>
    {{ $user->name }},<br>
    You have new review. You can view it at the following link
    {{ route('provider.testimonials.index') }}<br>

    {{ config('app.name') }}
</x-mail::message>
