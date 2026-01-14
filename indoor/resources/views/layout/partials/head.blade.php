<!-- Favicons -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/img/favicons/site.webmanifest') }}">

@if (Route::is([
    'provider.testimonials.index',
    'provider.google-reviews.index',
    'provider.facebook-reviews.index',
    'provider.request-quotes.index',
    'provider.provider-messages.index',
    'provider.messages.index',
    ]))
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables/datatables.min.css') }}">
@endif

@if (Route::is(['index']))
    <link rel="stylesheet" href="{{ url('assets/plugins/aos/aos.css') }}">
@endif
<!-- Main CSS -->
@vite(['resources/css/app.css'])
