<x-mail::message>
    New certificate uploaded by provider.<br>
    Provider: <a href="{{ route('admin.details.editById', $user->id) }}">{{ $user->name }}</a><br>
    Certificate: {{ $file->name }}<br>
    <a href="{{ $url }}">View Certificate</a>

    {{ config('app.name') }}
</x-mail::message>
