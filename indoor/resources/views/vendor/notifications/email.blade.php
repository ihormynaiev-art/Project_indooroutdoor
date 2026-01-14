<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach
@lang("If you're having trouble with the button, ")
<a href="{{$displayableActionUrl}}">click here</a>
@lang("to verify your email.")<br>

@lang("For your security, this link is unique to your account and will expire after 30 minutes.")<br>

@lang("Need help? Contact us at info@indooroutdoor.com.")<br>

@lang("We’re excited to have you join the IndoorOutdoor Resource, where we connect homeowners with top contractors like you!")<br>

@lang('Best Regards'),<br>
<b>The IndoorOutdoor Resource Team</b>


</x-mail::message>
