<x-mail::message>
    New contractor registered.<br>
    <a href="{{ route('admin.details.editById', $user->id) }}">{{ $user->name }}</a><br>

    {{ config('app.name') }}
</x-mail::message>
