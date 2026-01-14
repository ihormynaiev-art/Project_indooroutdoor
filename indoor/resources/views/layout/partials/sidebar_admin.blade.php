<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ URL::asset('admin_assets/img/logo.png') }}" class="img-fluid logo" alt="Logo">
            </a>
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ URL::asset('admin_assets/img/logo-small.svg') }}" class="img-fluid logo-small"
                    alt="Logo">
            </a>
        </div>
        <div class="siderbar-toggle">
            <label class="switch" id="toggle_btn">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title m-0">
                    <h6>Home</h6>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="fe fe-grid"></i>
                        <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="{{ route('admin.admins.index') }}"
                       class="{{ Route::is('admin.admins.index', 'admin.admins.show') ? 'active' : '' }}">
                        <i class="fe fe-shield"></i>
                        <span>Admins</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="
                            {{ Route::is(
                                'admin.categories.index',
                                'admin.categories.edit',
                                'admin.categories.create'
                            ) ? 'active' : '' }}"
                    ><i class="fe fe-file-text"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.logos.index') }}"
                       class="
                            {{ Route::is(
                                'admin.logos.index',
                                'admin.logos.edit',
                                'admin.logos.create'
                            ) ? 'active' : '' }}"
                    ><i class="fe fe-image"></i>
                        <span>Home Page Logos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.edition.edit') }}"
                       class="{{ Route::is('admin.edition.edit') ? 'active' : '' }}"
                    ><i class="fe fe-briefcase"></i>
                        <span>E-dition</span>
                    </a>
                </li>
                <li class="menu-title">
                    <h6>Users</h6>
                </li>
                <li>
                    <a href="{{ route('admin.homeowners.index') }}"
                       class="{{ Route::is('admin.homeowners.index', 'admin.homeowners.show') ? 'active' : '' }}">
                        <i class="fe fe-users"></i>
                        <span>Homeowners</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.contractors.index') }}"
                       class="{{ Route::is('admin.contractors.index', 'admin.contractors.edit') ? 'active' : '' }}">
                        <i class="fe fe-briefcase"></i>
                        <span>Contractors</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.landings.index') }}"
                       class="{{ Route::is('admin.landings.index', 'admin.landings.edit') ? 'active' : '' }}">
                        <i class="fe fe-box"></i>
                        <span>Landings</span>
                    </a>
                </li>
                <x-nav.admin.licenses />
                <li>
                    <a href="{{ route('admin.testimonials.index') }}"
                       class="{{ Route::is('admin.testimonials.index') ? 'active' : '' }}"><i class="fe fe-star"></i>
                        <span>Testimonials</span>
                    </a>
                </li>
                <li class="menu-title">
                    <h6>Plans</h6>
                </li>
                <li>
                    <a href="{{ route('admin.plans.index') }}"
                       class="{{ Route::is('admin.plans.index', 'admin.plans.edit') ? 'active' : '' }}">
                        <i class="fe fe-package"></i>
                        <span>Plans</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.invite-codes.index') }}"
                       class="{{ Route::is('admin.invite-codes.index') ? 'active' : '' }}">
                        <i class="fe fe-code"></i>
                        <span>Invite Codes</span>
                    </a>
                </li>
                <li class="menu-title m-0">
                    <h6>SMS</h6>
                </li>
                <li>
                    <a href="{{ route('admin.sms-templates.index') }}"
                       class="{{ Route::is('admin.sms-templates.index', 'admin.sms-templates.edit') ? 'active' : '' }}">
                        <i class="fe fe-database"></i>
                        <span>Sms Templates</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.sms-messages.index') }}"
                       class="{{ Route::is('admin.sms-messages.index') ? 'active' : '' }}">
                        <i class="fe fe-message-circle"></i>
                        <span>Sms Messages</span>
                    </a>
                </li>
                <li class="menu-title">
                    <h6>Messages</h6>
                </li>
                <li>
                    <a href="{{ route('admin.contactMessages.index') }}"
                       class="{{ Route::is('admin.contactMessages.index') ? 'active' : '' }}"><i class="fe fe-message-square"></i>
                        <span>Contact messages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.requestQuotes.index') }}"
                       class="{{ Route::is('admin.requestQuotes.index', 'admin.requestQuotes.show') ? 'active' : '' }}"><i class="fe fe-file-text"></i>
                        <span>Request Quotes</span>
                    </a>
                </li>

                <li class="menu-title">
                    <h6>Settings</h6>
                </li>
                <li>
                    <a href="{{ route('admin.settings.mail.edit') }}"
                       class="{{ Route::is('admin.settings.mail.edit') ? 'active' : '' }}"><i class="fe fe-mail"></i>
                        <span>Mail Settings</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            this.closest('form').submit();"
                        >
                            <i class="fe fe-log-out"></i><span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
