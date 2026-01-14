<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @hasrole('provider')
                    <li class="{{ Route::is('provider.explanation') ? 'active' : '' }}">
                        <a href="{{ route('provider.explanation') }}">
                            <i class="feather-book-open"></i>
                            <span>Explanation</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('provider.details.edit') ? 'active' : '' }}">
                        <a href="{{ route('provider.details.edit') }}">
                            <i class="feather-user"></i>
                            <span>Contractor Profile Setup</span>
                        </a>
                    </li>
                    <x-nav.provider.licenses />
                    <li
                        class="submenu {{ Route::is('provider.testimonials.index') ? 'active' : '' }}">
                        <a href="{{ url('provider-settings') }}">
                            <i class="feather-book"></i>
                            <span>Reviews</span>
                            <span class="menu-arrow"></span></a>
                        <ul>
                            <li class="{{ Route::is('provider.reviews.settings.edit') ? 'active' : '' }}">
                                <a class="{{ Route::is('provider.reviews.settings.edit') ? 'active' : '' }}"
                                   href="{{ route('provider.reviews.settings.edit') }}">
                                    <i class="feather-settings"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('provider.testimonials.index', 'provider.testimonials.show') ? 'active' : '' }}">
                                <a class="{{ Route::is('provider.testimonials.index', 'provider.testimonials.show') ? 'active' : '' }}"
                                    href="{{ route('provider.testimonials.index') }}">
                                    <i class="feather-star"></i>
                                    <span>Indoor Outdoor</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('provider.google-reviews.index', 'provider.google-reviews.show') ? 'active' : '' }}">
                                <a class="{{ Route::is('provider.google-reviews.index', 'provider.google-reviews.show') ? 'active' : '' }}"
                                    href="{{ route('provider.google-reviews.index') }}">
                                    <i class="feather-chrome"></i>
                                    <span>Google</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('provider.facebook-reviews.index', 'provider.facebook-reviews.show') ? 'active' : '' }}">
                                <a class="{{ Route::is('provider.facebook-reviews.index', 'provider.facebook-reviews.show') ? 'active' : '' }}"
                                    href="{{ route('provider.facebook-reviews.index') }}">
                                    <i class="feather-facebook"></i>
                                    <span>Facebook</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <x-nav.provider.request-quotes />
                    <x-nav.provider.messages />
                @endhasrole
                <li
                    class="submenu {{ Route::is('profile.edit') ? 'active' : '' }}">
                    <a href="{{ url('provider-settings') }}"><i class="feather-settings"></i>
                        <span>Settings</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="{{ Route::is('profile.edit') ? 'active' : '' }}">Account
                                Settings</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        this.closest('form').submit();"
                        >
                            <i class="feather-log-out"></i><span class="logout">Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
            <div class="menu-bottom">
                <a href="javascript:;" class="select-set"><i class="feather-settings"></i></a>
                <div class="dropdown-menu user-drop" id="dropboxes">
                    <ul class="set-menu">
                        <li>
                            <a href="{{ route('profile.edit') }}">
                                <i class="feather-user me-2"></i> Your Account
                            </a>
                        </li>
                        @hasrole('provider')
                            <li>
                                <a href="{{ route('provider.verification') }}">
                                    <i class="feather-check-circle me-2"></i> Identity Verification
                                </a>
                            </li>
                        @endhasrole
                    </ul>
                    <ul class="help-menu">
                        <li>
                            <a href="{{ route('terms-condition') }}">
                                Terms of Condition
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy-policy') }}">
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Sidebar -->
