<div class="header">
    <div class="header-left">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ URL::asset('/admin_assets/img/logo.svg') }}" alt="Logo" width="30" height="30">
        </a>
        <a href="{{ route('admin.dashboard') }}" class=" logo-small">
            <img src="{{ URL::asset('/admin_assets/img/logo-small.svg') }}" alt="Logo" width="30"
                height="30">
        </a>
    </div>
    <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
        <i class="fas fa-align-left"></i>
    </a>
    <div class="justify-content-end">
        <ul class="nav user-menu">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="viewsite"><i class="fe fe-globe me-2"></i>View Site</a>
            </li>
            <li class="nav-item  has-arrow dropdown-heads ">
                <a href="javascript:void(0);" class="win-maximize">
                    <i class="fe fe-maximize"></i>
                </a>
            </li>

            <!-- User Menu -->
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img class="rounded-circle" src="{{ URL::asset('/admin_assets/img/user.jpg') }}"
                            width="40" alt="Admin">
                        <span class="animate-circle"></span>
                    </span>
                    <span class="user-content">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </span>
                </a>
                <div class="dropdown-menu menu-drop-user">
                    <div class="profilemenu ">
                        <div class="user-detials">
                            <a href="{{ route('profile.edit') }}">
                                <span class="profile-image">
                                    <img src="{{ URL::asset('/admin_assets/img/user.jpg') }}" alt="img"
                                        class="profilesidebar">
                                </span>
                                <span class="profile-content">
                                    <span>{{ Auth::user()->name }}</span>
                                    <span>{{ Auth::user()->email }}</span>
                                </span>
                            </a>
                        </div>
                        <div class="subscription-menu">
                            <ul>
                                <li>
                                    <a href="{{ route('profile.edit') }}">Profile</a>
                                </li>
                            </ul>
                        </div>
                        <form class="subscription-logout" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                     this.closest('form').submit();"
                            >
                                <span>Log Out</span>
                            </a>
                        </form>
                    </div>
                </div>
            </li>
            <!-- /User Menu -->
        </ul>
    </div>

</div>
