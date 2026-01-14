<!-- Delete -->
@if (!Route::is(['review-type', 'pages-list', 'page-list', 'currencies', 'system-backup', 'database-backup']))
    <div class="modal fade" id="delete-item" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
@endif
@if (Route::is(['review-type']))
    <div class="modal fade" id="delete-review-type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
@endif
@if (Route::is(['pages-list']))
    <div class="modal fade" id="delete-pages" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
@endif
@if (Route::is(['page-list']))
    <div class="modal fade" id="delete-page" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
@endif
@if (Route::is(['blogs-comments']))
    <div class="modal fade" id="delete-comment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
@endif
@if (Route::is(['currencies']))
    <div class="modal fade" id="delete-currency" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
@endif
@if (Route::is(['system-backup', 'database-backup']))
    <div class="modal fade" id="delete-backup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
@endif
<div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
        <div class="modal-header model-sub">
            <h5 class="modal-title" id="delete-item">{{ $title1 }}</h5>
            <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                <i class="fe fe-x"></i>
            </button>
        </div>
        @if (
            !Route::is([
                'sub-categories',
                'admin.magazines',
                'pending-services',
                'deleted-services',
                'inactive-services',
                'review-type',
                'sales-transactions',
                'tax-rates',
                'pages-list',
                'page-list',
                'blogs-categories',
                'blogs-comments',
                'countries',
                'states',
                'cities',
                'testimonials',
                'faq',
                'admin-earnings',
                'provider-earnings',
                'user-list',
                'user-customers',
                'user-providers',
                'delete-account-requests',
                'email-templates',
                'sms-templates',
                'menu-management',
                'plugins-manager',
                'contact-messages',
                'abuse-reports',
                'announcements',
                'language',
                'currencies',
                'ban-ip-address',
                'system-backup',
                'database-backup',
                'all-blog',
                'pending-blog',
                'inactive-blog',
                'payment-settings',
            ]))
            <form action="{{ url('admin/categories') }}">
        @endif
        @if (Route::is(['sub-categories']))
            <form action="{{ url('admin/sub-categories') }}">
        @endif
        @if (Route::is(['admin.magazines']))
            <form action="{{ url('admin/services') }}">
        @endif
        @if (Route::is(['pending-services']))
            <form action="{{ url('admin/pending-services') }}">
        @endif
        @if (Route::is(['deleted-services']))
            <form action="{{ url('admin/deleted-services') }}">
        @endif
        @if (Route::is(['inactive-services']))
            <form action="{{ url('admin/inactive-services') }}">
        @endif
        @if (Route::is(['review-type']))
            <form action="{{ url('admin/review-type') }}">
        @endif
        @if (Route::is(['sales-transactions']))
            <form action="{{ url('admin/sales-transactions') }}">
        @endif
        @if (Route::is(['tax-rates']))
            <form action="{{ url('admin/tax-rates') }}">
        @endif
        @if (Route::is(['pages-list', 'page-list']))
            <form action="{{ url('admin/pages-list') }}">
        @endif
        @if (Route::is(['blogs-categories']))
            <form action="{{ url('admin/blogs-categories') }}">
        @endif
        @if (Route::is(['blogs-comments']))
            <form action="{{ url('admin/blogs-comments') }}">
        @endif
        @if (Route::is(['countries']))
            <form action="{{ url('admin/countries') }}">
        @endif
        @if (Route::is(['states']))
            <form action="{{ url('admin/states') }}">
        @endif
        @if (Route::is(['cities']))
            <form action="{{ url('admin/cities') }}">
        @endif
        @if (Route::is(['testimonials']))
            <form action="{{ url('admin/testimonials') }}">
        @endif
        @if (Route::is(['faq']))
            <form action="{{ url('admin/faq') }}">
        @endif
        @if (Route::is(['admin-earnings']))
            <form action="{{ url('admin/admin-earnings') }}">
        @endif
        @if (Route::is(['provider-earnings']))
            <form action="{{ url('admin/provider-earnings') }}">
        @endif
        @if (Route::is(['user-list']))
            <form action="{{ url('admin/user-list') }}">
        @endif
        @if (Route::is(['user-customers']))
            <form action="{{ url('admin/user-customers') }}">
        @endif
        @if (Route::is(['user-providers']))
            <form action="{{ url('admin/user-providers') }}">
        @endif
        @if (Route::is(['delete-account-requests']))
            <form action="{{ url('admin/delete-account-requests') }}">
        @endif
        @if (Route::is(['marketing-coupons']))
            <form action="{{ url('admin/marketing-coupons') }}">
        @endif
        @if (Route::is(['marketing-service']))
            <form action="{{ url('admin/marketing-service') }}">
        @endif
        @if (Route::is(['marketing-featured']))
            <form action="{{ url('admin/marketing-featured') }}">
        @endif
        @if (Route::is(['marketing-newsletter']))
            <form action="{{ url('admin/marketing-newsletter') }}">
        @endif
        @if (Route::is(['email-templates']))
            <form action="{{ url('admin/email-templates') }}">
        @endif
        @if (Route::is(['sms-templates']))
            <form action="{{ url('admin/sms-templates') }}">
        @endif
        @if (Route::is(['menu-management']))
            <form action="{{ url('admin/menu-management') }}">
        @endif
        @if (Route::is(['plugins-manager']))
            <form action="{{ url('admin/plugins-manager') }}">
        @endif
        @if (Route::is(['contact-messages']))
            <form action="{{ url('admin/contact-messages') }}">
        @endif
        @if (Route::is(['abuse-reports']))
            <form action="{{ url('admin/abuse-reports') }}">
        @endif
        @if (Route::is(['announcements']))
            <form action="{{ url('admin/announcements') }}">
        @endif
        @if (Route::is(['language']))
            <form action="{{ url('admin/language') }}">
        @endif
        @if (Route::is(['currencies']))
            <form action="{{ url('admin/currencies') }}">
        @endif
        @if (Route::is(['ban-ip-address']))
            <form action="{{ url('admin/ban-ip-address') }}">
        @endif
        @if (Route::is(['system-backup']))
            <form action="{{ url('admin/system-backup') }}">
        @endif
        @if (Route::is(['database-backup']))
            <form action="{{ url('admin/database-backup') }}">
        @endif
        @if (Route::is(['all-blog']))
            <form action="{{ url('admin/all-blog') }}">
        @endif
        @if (Route::is(['pending-blog']))
            <form action="{{ url('admin/pending-blog') }}">
        @endif
        @if (Route::is(['inactive-blog']))
            <form action="{{ url('admin/pending-blog') }}">
        @endif
        @if (Route::is(['payment-settings']))
            <form action="{{ url('admin/payment-settings') }}">
        @endif

        <div class="modal-body pt-0">
            <p class="text-muted mb-0">Are you sure want to delete?</p>
            <div class="d-flex gap-2 justify-content-end mt-4">
                <button id="approve-delete" type="button" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
<!-- /Delete -->
