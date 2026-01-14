<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="@yield('description')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', env('APP_NAME'))
    </title>
    <meta name="robots" content="index,follow">
    @include('layout.partials.head')
</head>
@if (
    !Route::is([
        'error-404',
        'error-500',
        'choose-signup',
        'signup',
        'provider-signup',
        'login',
        'reset-password',
        'password-recovery',
        'provider.services.index',
        'provider.details.edit',
        'provider.reviews.settings.edit',
        'admin.details.editById',
        'provider.testimonials.index',
        'provider.google-reviews.index',
        'provider.facebook-reviews.index',
        'provider.request-quotes.index',
        'provider.request-quotes.show',
        'provider.provider-messages.index',
        'provider.provider-messages.show',
        'provider.testimonials.show',
        'provider.google-reviews.show',
        'provider.facebook-reviews.show',
        'profile.edit',
        'index'
    ]))

    <body>
@endif
@if (Route::is([
        'provider.services.index',
        'provider.verification',
        'provider.explanation',
        'provider.details.edit',
        'provider.reviews.settings.edit',
        'admin.details.editById',
        'provider.testimonials.index',
        'provider.google-reviews.index',
        'provider.facebook-reviews.index',
        'provider.request-quotes.index',
        'provider.request-quotes.show',
        'provider.provider-messages.index',
        'provider.provider-messages.show',
        'provider.testimonials.show',
        'provider.google-reviews.show',
        'provider.facebook-reviews.show',
        'profile.edit',
    ]))
    <body class="provider-body">
@endif
@if (Route::is([
        'choose-signup',
        'signup',
        'provider-signup',
        'login',
        'reset-password',
        'password-recovery',
    ]))

    <body class="login-body">
@endif
@if (Route::is([
        'error-404',
        'error-500',
    ]))

    <body class="mt-0">
@endif
@if (Route::is(['index']))

    <body class="body-one">
@endif
@if (!Route::is(['error-404', 'error-500', 'session-expired']))
    <div class="main-wrapper">
@endif
@if (Route::is(['session-expired']))
    <div class="main-wrapper error-page">
@endif
@if (
    !Route::is([
        'error-404',
        'error-500',
    ]))
    @include('layout.partials.header')
@endif
@if (Route::is([
        'provider.services.index',
        'provider.verification',
        'provider.explanation',
        'admin.details.editById',
        'provider.details.edit',
        'provider.reviews.settings.edit',
        'provider.testimonials.index',
        'provider.google-reviews.index',
        'provider.facebook-reviews.index',
        'provider.request-quotes.index',
        'provider.request-quotes.show',
        'provider.provider-messages.index',
        'provider.provider-messages.show',
        'provider.testimonials.show',
        'provider.google-reviews.show',
        'provider.facebook-reviews.show',
        'profile.edit'
    ]))
    @include('layout.partials.nav')
@endif
@yield('content')
@if (
    !Route::is([
        'error-404',
        'error-500',
        'choose-signup',
        'signup',
        'provider-signup',
        'login',
        'reset-password',
        'password-recovery',
        'provider.services',
        'admin.details.editById',
        'provider.details.edit',
        'provider.reviews.settings.edit',
        'provider.testimonials.index',
        'provider.google-reviews.index',
        'provider.facebook-reviews.index',
        'provider.request-quotes.index',
        'provider.request-quotes.show',
        'provider.provider-messages.index',
        'provider.provider-messages.show',
        'provider.testimonials.show',
        'provider.google-reviews.show',
        'provider.facebook-reviews.show',
        'profile.edit',
        'provider.verification',
        'provider.explanation',
    ]))
    @include('layout.partials.footer')
@endif
@include('layout.partials.cursor')
</div>
@include('layout.partials.footer-scripts')
</body>

</html>
