<div class="content-sidelink float-start">
    <div class="content-sidelinkheading">
        <h6>Settings</h6>
    </div>
    <div class="content-sidelinkmenu">
        <ul>
            <li>
                <h5>General Settings</h5>
            </li>
            <li><a class="{{ Request::is('admin/localization') ? 'active' : '' }}"
                    href="{{ url('admin/localization') }}">Localization </a></li>
            <li><a class="{{ Request::is('admin/account-settings') ? 'active' : '' }}"
                    href="{{ url('admin/account-settings') }}">Account Settings </a></li>
            <li><a class="{{ Request::is('admin/security', 'admin/device-management', 'admin/login-activity') ? 'active' : '' }}"
                    href="{{ url('admin/security') }}">Security</a></li>
            <li><a class="{{ Request::is('admin/social-profiles') ? 'active' : '' }}"
                    href="{{ url('admin/social-profiles') }}">Social Profiles </a></li>
            <li><a class="{{ Request::is('admin/notifications') ? 'active' : '' }}"
                    href="{{ url('admin/notifications') }}">Notifications</a></li>
            <li><a class="{{ Request::is('admin/connected-apps') ? 'active' : '' }}"
                    href="{{ url('admin/connected-apps') }}">Connected Apps</a></li>
            <li><a class="{{ Request::is('admin/appointment-settings') ? 'active' : '' }}"
                    href="{{ url('admin/appointment-settings') }}">Appointment Settings</a></li>
        </ul>
        <ul>
            <li>
                <h5>Website Settings</h5>
            </li>
            <li><a class="{{ Request::is('admin/site-information') ? 'active' : '' }}"
                    href="{{ url('admin/site-information') }}">Site Information</a></li>
            <li><a class="{{ Request::is('admin/seo-settings') ? 'active' : '' }}"
                    href="{{ url('admin/seo-settings') }}">Seo Settings</a></li>
            <li><a class="{{ Request::is('admin/preference-settings') ? 'active' : '' }}"
                    href="{{ url('admin/preference-settings') }}">Preference Settings</a></li>
            <li><a class="{{ Request::is('admin/appearance') ? 'active' : '' }}"
                    href="{{ url('admin/appearance') }}">Appearance </a></li>
            <li>
                <h4>Frontend Settings</h4>
            </li>
            <li class="submenu-sidelink"><a class="{{ Request::is('admin/header-settings') ? 'active' : '' }}"
                    href="{{ url('admin/header-settings') }}">Header Settings</a></li>
            <li class="submenu-sidelink"><a class="{{ Request::is('admin/footer-settings') ? 'active' : '' }}"
                    href="{{ url('admin/footer-settings') }}">Footer Settings</a></li>
            <li><a class="{{ Request::is('admin/authentication-settings') ? 'active' : '' }}"
                    href="{{ url('admin/authentication-settings') }}">Authentication Settings</a></li>
            <li><a class="{{ Request::is('admin/social-authentication') ? 'active' : '' }}"
                    href="{{ url('admin/social-authentication') }}">Social Authentication</a></li>
            <li><a class="{{ Request::is('admin/language') ? 'active' : '' }}"
                    href="{{ url('admin/language') }}">Language </a></li>
            <li><a class="{{ Request::is('admin/typography-settings') ? 'active' : '' }}"
                    href="{{ url('admin/typography-settings') }}">Typography Settings</a></li>
        </ul>
        <ul>
            <li>
                <h5>System Settings</h5>
            </li>
            <li><a class="{{ Request::is('admin/email-settings') ? 'active' : '' }}"
                    href="{{ url('admin/email-settings') }}">Email Settings </a></li>
            <li><a class="{{ Request::is('admin/sms-settings') ? 'active' : '' }}"
                    href="{{ url('admin/sms-settings') }}">SMS Settings</a></li>
            <li><a class="{{ Request::is('admin/gdpr-settings') ? 'active' : '' }}"
                    href="{{ url('admin/gdpr-settings') }}">GDPR Settings </a></li>
            <li><a class="{{ Request::is('admin/calendar-settings') ? 'active' : '' }}"
                    href="{{ url('admin/calendar-settings') }}">Calendar Settings</a></li>
        </ul>
        <ul>
            <li>
                <h5>Financial Settings</h5>
            </li>
            <li><a class="{{ Request::is('admin/payment-gateways') ? 'active' : '' }}"
                    href="{{ url('admin/payment-gateways') }}">Payment Gateways</a></li>
            <li><a class="{{ Request::is('admin/payment-settings') ? 'active' : '' }}"
                    href="{{ url('admin/payment-settings') }}">Payment Settings</a></li>
            <li><a class="{{ Request::is('admin/tax-rates') ? 'active' : '' }}"
                    href="{{ url('admin/tax-rates') }}">Tax Rates</a></li>
            <li><a class="{{ Request::is('admin/currencies', 'admin/currency-settings') ? 'active' : '' }}"
                    href="{{ url('admin/currencies') }}">Currencies</a></li>
        </ul>
        <ul>
            <li>
                <h5><a class="{{ Request::is('admin/service-settings') ? 'active' : '' }}"
                        href="{{ url('admin/service-settings') }}">Service Settings</a></h5>
            </li>
        </ul>
        <ul>
            <li>
                <h5><a class="{{ Request::is('admin/provider-settings') ? 'active' : '' }}"
                        href="{{ url('admin/provider-settings') }}">Provider Settings</a></h5>
            </li>
        </ul>
        <ul>
            <li>
                <h5>Other Settings</h5>
            </li>
            <li><a class="{{ Request::is('admin/storage-settings') ? 'active' : '' }}"
                    href="{{ url('admin/storage-settings') }}">Storage Settings</a></li>
            <li><a class="{{ Request::is('admin/ban-ip-address') ? 'active' : '' }}"
                    href="{{ url('admin/ban-ip-address') }}">Ban IP Address</a></li>
            <li><a class="{{ Request::is('admin/cronjob') ? 'active' : '' }}"
                    href="{{ url('admin/cronjob') }}">Cronjob</a></li>
            <li>
                <h4>Backup</h4>
            </li>
            <li class="submenu-sidelink"><a class="{{ Request::is('admin/system-backup') ? 'active' : '' }}"
                    href="{{ url('admin/system-backup') }}">System Backup</a></li>
            <li class="submenu-sidelink"><a class="{{ Request::is('admin/database-backup') ? 'active' : '' }}"
                    href="{{ url('admin/database-backup') }}">Database Backup</a></li>
            <li><a class="{{ Request::is('admin/system-information') ? 'active' : '' }}"
                    href="{{ url('admin/system-information') }}">System Information</a></li>
        </ul>
    </div>
</div>
