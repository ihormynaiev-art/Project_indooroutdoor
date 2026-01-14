<!DOCTYPE html>
<html>
<body>
<div style="display: flex; justify-content: center;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="180">
</div>
<p>{{ $providerMessage->providerDetail->user->name }},</p>

<p>You have a new message.<br>
    You can view it at the following link:<br>
    <a href="{{ route('provider.provider-messages.index') }}">Open Messages</a></p>

<p><strong>From:</strong><br> {{ $providerMessage->contact }}</p>

<p><strong>Message:</strong><br> {{ $providerMessage->message }}</p>

@if($providerMessage->images->isNotEmpty())
    <p><strong>Images:</strong><br>
    @foreach($providerMessage->images as $image)
        <div class="col-md-3 col-sm-12">
            <div>
                <a target="_blank" href="{{ url('storage/' . $image->path) }}">
                    <img width="300" src="{{ url('storage/' . $image->path) }}" alt="Image - {{ $loop->index }}">
                </a>
            </div>
        </div>
    @endforeach
@endif

<p>{{ config('app.name') }}</p>
</body>
</html>
