<x-mail::message>
# New contact message

Name : {{ $name }} <br>
Email : {{ $email }} <br>
Message : {{ $message }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
