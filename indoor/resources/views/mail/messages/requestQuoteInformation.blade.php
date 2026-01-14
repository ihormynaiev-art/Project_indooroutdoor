<x-mail::message>
# New request quote

Homeowner name : {{ $homeownerName }}

Email: {{ $email }}

Number : {{ $contactNumber }}

City : {{ $city }}

State : {{ $state }}

Category : {{ $category }}

SubCategory : {{ $subCategory }}

Details of project : {{ $details }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
