<?php error_reporting(0); ?>
@if (!Route::is(['provider-signup','user-signup','password-recovery','reset-password','phone-otp','email-otp']))
    @if (
        !Route::is([
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
            'profile.edit'
        ]))
        <!-- Header -->
        @if (Route::is(['index']))
            <header class="header header-one">
        @endif
        @if (!Route::is(['index']))
            <header class="header">
        @endif
        @if (!Route::is(['index-3']))
            <div class="container">
        @endif
        <nav class="navbar navbar-expand-lg header-nav">
            <div class="navbar-header">
                @if (
                    !Route::is([
                        'signup',
                        'user-signup',
                        'provider-signup',
                        'login',
                        'reset-password',
                        'password-recovery',
                        'phone-otp',
                        'email-otp',
                        'free-trial',
                    ]))
                    <a id="mobile_btn" href="javascript:void(0);">
                        <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                        </span>
                    </a>
                @endif
                <a href="{{ url('/') }}" class="navbar-brand logo">
                    <img src="{{ URL::asset('/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                </a>

                <a href="{{ url('/') }}" class="navbar-brand logo-small">
                    <img src="{{ URL::asset('/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="{{ url('/') }}" class="menu-logo">
                        <img src="{{ URL::asset('/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i></a>
                </div>
                <ul class="main-nav">
                @if (Route::is(['contact-us', 'signup', 'reset-password']))
                    <li class="has-submenu">
                    </li>
                @endif
                <li
                    class=" {{ Request::is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li
                    class="has-submenu">
                    <a data-bs-toggle="modal" data-bs-title="QUOTATION FORM" data-bs-target="#request-quote" href="javascript:void(0);">Request Quote</a>
                </li>
                <li class="has-submenu {{ Route::is('catalog.index') ? 'active' : '' }}">
                    <a href="{{ route('catalog.index') }}" id="menu-services" >Services <i class="fas fa-chevron-down"></i></a>
                    <div class="menu-sub-category">
                        <ul class="submenu topsubmenu">
                            @if($menuCategories)
                                @foreach($menuCategories as $category)
                                    <li class="has-submenu">
                                        <a href="{{ route('catalog.index', ['categories' => [ $category->slug ]]) }}">{{ $category->name }}</a>
                                        <div class="sub-menu-sub-category">
                                            <ul class="submenu">
                                                @if(isset($category->subCategories))
                                                    @foreach($category->subCategories as $subCategory)
                                                        <li>
                                                            <a href="{{ route('catalog.index', [ 'sub_categories' => [ $subCategory->id ]]) }}">
                                                                {{ $subCategory->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </li>
                <li
                    class="">
                    <a href="{{ route('edition.show') }}">E-dition</a>
                </li>
                @if(Auth::user())
                    @hasanyrole(['admin', 'super admin'])
                        <li class="login-link">
                            <a href="{{ route('admin.dashboard') }}">Admin</a>
                        </li>
                    @else
                        <li class="login-link">
                            <a href="{{ route('profile.edit') }}">Profile</a>
                        </li>
                    @endhasanyrole
                    <li class="login-link">
                        <form method="POST" class="m-0" action="{{ route('logout') }}">
                            @csrf
                            <a
                                class="dropdown-item"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                     this.closest('form').submit();"
                            >
                                <span> Logout</span>
                            </a>
                        </form>
                    </li>
                @else
                    <li class="login-link">
                        <a href="{{ url('signup') }}">Register</a>
                    </li>
                    <li class="login-link">
                        <a href="{{ url('login') }}">Login</a>
                    </li>
                @endif
                    <li class="login-link">
                        <a href="{{ url('contact-us') }}">Contact Us</a>
                    </li>
                </ul>
            </div>
            @if (Route::is([
                    'signup',
                    'user-signup',
                    'provider-signup',
                    'login',
                    'reset-password',
                    'password-recovery',
                    'phone-otp',
                    'email-otp',
                    'free-trial',
                ]))
                <ul class="nav header-navbar-rht">
                    @if (!Route::is(['password-recovery']))
                        <li class="nav-item">
                            @if (!Route::is(['login', 'reset-password', 'phone-otp', 'email-otp']))
                                <a class="nav-link header-login" href="{{ url('login') }}"><img src="{{ URL::asset('/assets/img/login_icon.png') }}" alt="Log In Image">Login</a>
                            @elseif (Route::is(['login', 'reset-password', 'phone-otp', 'email-otp']))
                                <a class="nav-link header-login" href="{{ url('signup') }}">Sign Up</a>
                            @endif
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link header-login" href="{{ url('login') }}"><img src="{{ URL::asset('/assets/img/login_icon.png') }}" alt="Log In Image">Login</a>
                        </li>
                        <li class="nav-item">/</li>
                        <li class="nav-item">
                            <a class="nav-link header-reg" href="{{ url('signup') }}">Sign Up</a>
                        </li>
                    @endif
                </ul>
            @endif
            @if (
                !Route::is([
                    'signup',
                    'user-signup',
                    'provider-signup',
                    'login',
                    'reset-password',
                    'password-recovery',
                    'phone-otp',
                    'email-otp',
                    'free-trial',
                    'customer-dashboard',
                    'booking-details',
                    'customer-booking',
                    'customer-favourite',
                    'customer-wallet',
                    'customer-reviews',
                    'customer-chat',
                    'customer-profile',
                    'security-settings',
                    'customer-notifications',
                    'connected-apps',
                    'invoice',
                    'login-email',
                    'login-phone',
                    'login-phone1',
                    'notification',
                    'success',
                    'customer-booking-calendar',
                    'provider-signup-payment',
                    'provider-signup-subscription',
                    'service-details2',
                    'device-management',
                    'login-activity',
                ]))
                <ul class="nav header-navbar-rht">
                    @if (!Auth::user())
                        <li class="nav-item">
                            <a class="nav-link header-login" href="{{ url('login') }}"><img src="{{ URL::asset('/assets/img/login_icon.png') }}" alt="Log In Image">Login</a>
                        </li>
                        <li class="nav-item">/</li>
                        <li class="nav-item">
                            <a class="nav-link header-reg" href="{{ url('signup') }}">Sign Up</a>
                        </li>
                    @endif
                </ul>
            @endif
            @if (Route::is([
                    'login-email',
                    'login-phone',
                    'login-phone1',
                    'success',
                    'provider-signup-payment',
                    'provider-signup-subscription',
                ]))
                <ul class="nav header-navbar-rht log-rht">
                    @if (
                        !Route::is([
                            'user-signup',
                            'provider-signup',
                            'login',
                            'reset-password',
                            'password-recovery',
                            'phone-otp',
                            'email-otp',
                            'free-trial',
                            'login-email',
                            'login-phone',
                            'login-phone1',
                            'provider-signup-payment',
                            'provider-signup-subscription',
                        ]))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('login') }}">Login</a>
                        </li>
                    @endif
                </ul>
            @endif
            @if (Auth::user())
                <ul class="nav header-navbar-rht noti-pop-detail">
                    <!-- User Menu -->
                    <li class="nav-item dropdown has-arrow account-item">
                        <a href="javascript:;" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <div class="user-infos">
                                <span class="user-img">
                                    <img src="{{ Auth::user()->providerDetail?->logo ?  url('storage/' . Auth::user()->providerDetail->logo->path) : url()->asset('/assets/img/profiles/avatar-02.jpg') }}"
                                        class="rounded-circle" alt="User Image">
                                </span>
                                <div class="user-info">
                                    <h6>{{ Auth::user()->name }}</h6>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end emp">
                            @hasanyrole(['admin', 'super admin'])
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="feather-settings me-2"></i> Admin
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="feather-user me-2"></i> Profile
                                </a>
                            @endhasanyrole
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a
                                    class="dropdown-item"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                     this.closest('form').submit();"
                                >
                                    <i class="feather-log-out me-2"></i><span> Logout</span>
                                </a>
                            </form>
                        </div>
                    </li>
                    <!-- /User Menu -->
                </ul>
            @endif
        </nav>
        </div>
        </header>
        <!-- /Header -->
    @endif
    @if (Route::is([
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
            'profile.edit'
        ]))
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="sidebar-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ URL::asset('/assets/img/logo.png') }}" class="img-fluid logo" alt="">
                    </a>
                    <a href="{{ url('/') }}">
                        <img src="{{ URL::asset('/assets/img/logo.png') }}" style="max-width: 100px;" class="img-fluid logo-small"
                            alt="">
                    </a>
                </div>
                <div class="siderbar-toggle">
                    <label class="switch" id="toggle_btn">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <a class="mobile_btns" id="mobile_btns" href="javascript:void(0);">
                <i class="fas fa-align-left"></i>
            </a>
            <div class="header-split">
                <div class="page-headers">
                </div>
                <ul class="nav user-menu noti-pop-detail">
                    @if(auth()->user()->hasRole('provider'))
                        <li class="nav-item">
                            <a href="{{ route('provider.details.show', auth()->user()->providerDetail->slug) }}"
                               class="viewsite"
                                target="_blank"><i class="feather-link me-2"></i>Preview page</a>
                        </li>
                    @endif
                    <!-- Notifications -->
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="viewsite"><i class="feather-globe me-2"></i>View
                            Site</a>
                    </li>
                    <li class="nav-item  has-arrow dropdown-heads ">
                        <a href="javascript:;" class="win-maximize">
                            <i class="feather-maximize"></i>
                        </a>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown has-arrow account-item">
                        <a href="javascript:;" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <div class="user-infos">
                                <span class="user-img">
                                    <img src="{{ Auth::user()->providerDetail?->logo ?  url('storage/' . Auth::user()->providerDetail->logo->path) : url()->asset('/assets/img/profiles/avatar-02.jpg')  }}"
                                        class="rounded-circle" alt="User Image">
                                </span>
                                <div class="user-info">
                                    <h6>{{ Auth::user()->name }}</h6>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end emp">
                            @hasanyrole(['admin', 'super admin'])
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="feather-settings me-2"></i> Admin
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="feather-user me-2"></i> Profile
                                </a>
                            @endhasanyrole
                            <form method="POST" class="m-0" action="{{ route('logout') }}">
                                @csrf
                                <a
                                    class="dropdown-item"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                     this.closest('form').submit();"
                                >
                                    <i class="feather-log-out me-2"></i><span> Logout</span>
                                </a>
                            </form>
                        </div>
                    </li>
                    <!-- /User Menu -->
                </ul>
            </div>

        </div>
        <!-- /Header -->
    @endif
@endif
@include('partials.request-quote')
@if(Route::is(['provider.details.show']))
    @include('partials.share-profile')
    @include('partials.message-provider')
@endif
