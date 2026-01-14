<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.head_admin')
</head>

<body>
    <div class="main-wrapper">
        @if (
            !Route::is([
                'wallet-history',
                'change-password',
                'facebook-api',
                'google-api',
                'php-mail',
                'smtp',
                'nexmo',
                'paypal',
                'aws-storage',
                'signin',
                'forget-password',
                'signup',
            ]))
            @include('layout.partials.header_admin')
            @include('layout.partials.sidebar_admin')
        @endif
        @yield('content')
    </div>

    @if (Route::is(['index_admin']))
        <div id="overlayer">
            <span class="loader">
                <span class="loader-inner"></span>
            </span>
        </div>
    @endif

    @include('layout.partials.footer_admin-script')

</body>

</html>
