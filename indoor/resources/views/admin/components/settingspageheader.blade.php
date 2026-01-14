@if (!Route::is(['gdpr-settings', 'payment-settings','tax-rates','currencies','ban-ip-address','system-backup','database-backup','language']))
    <div class="content-page-header">
@endif
@if (Route::is(['gdpr-settings']))
    <div class="content-page-header d-flex d-flex justify-content-between">
@endif
@if (Route::is(['payment-settings','tax-rates','currencies','ban-ip-address','system-backup','database-backup','language']))
    <div class="content-page-header content-page-headersplit">
@endif
<h5>{{ $titleset }}</h5>

<div class="page-head-btn">
    @if (Route::is(['tax-rates']))
        <div class="list-btn">
            <ul>
                <li class="tax-module">
                    <div class="active-switch me-1">
                        <label class="switch">
                            <input type="checkbox" checked="">
                            <span class="sliders round"></span>
                        </label>
                    </div>
                    <span>Tax Module</span>
                </li>
                <li>
                    <div class="filter-sorting">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="filter-sets"><img
                                        src="{{ URL::asset('admin_assets/img/icons/filter1.svg') }}" class="me-2"
                                        alt="img">Filter</a>
                            </li>
                            <li>
                                <span><img src="{{ URL::asset('admin_assets/img/icons/sort.svg') }}" class="me-2"
                                        alt="img"></span>
                                <div class="review-sort">
                                    <select class="select">
                                        <option>A -> Z</option>
                                        <option>Z -> A</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#add-tax"><i class="fa fa-plus me-2"></i>Create Tax</a>
                </li>
            </ul>
        </div>
    @endif
    @if (Route::is(['language']))
        <a class="btn btn-primary me-2"><i class="fe fe-download-cloud me-2"></i>Web Export</a>
        <a class="btn btn-primaryline"><i class="fe fe-download-cloud me-2"></i>App Export</a>
    @endif
    @if (Route::is(['payment-settings']))
        <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-acc"><i
                class="fa fa-plus me-2"></i>Add Account</a>
    @endif
    @if (Route::is(['currencies']))
        <a class="btn btn-linegrey" href="{{ url('admin/currency-settings') }}"><i class="fe fe-settings"></i></a>
        <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-currency"><i
                class="fa fa-plus me-2"></i>Add Currency</a>
    @endif
    @if (Route::is(['ban-ip-address']))
        <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-tax"><i
                class="fa fa-plus me-2"></i>Ban IP Address</a>
    @endif
    @if (Route::is(['system-backup']))
        <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-tax">Generate
            Backup</a>
    @endif
    @if (Route::is(['database-backup']))
        <a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-tax">Generate
            Database Backup</a>
    @endif
</div>
@if (Route::is(['gdpr-settings', 'provider-settings']))
    <div class="active-switch d-flex align-items-center">
        <h6 class="fs-14">Enable</h6>
        <label class="switch">
            <input type="checkbox" checked="">
            <span class="sliders round"></span>
        </label>
    </div>
@endif
</div>
