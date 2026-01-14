<div class="row align-items-center">
    <div class="col-md-4">
        <div class="widget-title">
            @if (Route::is(['customer-booking', 'customer-booking-calendar']))
                <h4>Booking List</h4>
            @endif
            @if (Route::is(['customer-favourite']))
                <h4>Favorites</h4>
            @endif
        </div>
    </div>

    <div class="col-md-8 d-flex align-items-center justify-content-md-end flex-wrap">
        <div class="review-sort me-2">
            <p>Sort</p>
            @if (Route::is(['customer-booking']))
                <select class="select">
                    <option>Recent</option>
                    <option>Older</option>
                    <option>A to Z</option>
                    <option>Z to A</option>
                </select>
            @endif
            @if (Route::is(['customer-favourite']))
                <select class="select">
                    <option>A -> Z</option>
                    <option>Most helful</option>
                </select>
            @endif
            @if (Route::is(['customer-booking-calendar']))
                <select class="select">
                    <option>A -> Z</option>
                    <option>Most helful</option>
                </select>
            @endif
        </div>
        <div class="grid-listview">
            <ul>
                @if (Route::is(['customer-booking', 'customer-booking-calendar']))
                    <li>
                        <a href="{{ url('customer-booking-calendar') }}"
                            class="{{ Request::is('customer-booking-calendar') ? 'active' : '' }}">
                            <i class="feather-calendar"></i>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="javascript:void(0);">
                        <i class="feather-filter"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ url('customer-favourite') }}"
                        class="{{ Request::is('customer-favourite') ? 'active' : '' }}">
                        <i class="feather-grid"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ url('customer-booking') }}"
                        class="{{ Request::is('customer-booking') ? 'active' : '' }}">
                        <i class="feather-list"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
