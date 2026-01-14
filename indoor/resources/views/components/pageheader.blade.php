 <!-- Page Header -->
 <div class="page-header">
     <div class="row">
         <div class="col-md-4">
             <div class="provider-subtitle">
                 <h6>{{ $title }}</h6>
             </div>
         </div>
         @if (!Route::is(['provider-availability', 'provider-holiday']))
             <div class="col-md-8 d-flex align-items-center justify-content-md-end flex-wrap">
                 @if (!Route::is(['provider-payout']))
                     <div class="review-sort me-2">
                         <p>Sort</p>
                         @if (!Route::is(['provider-reviews']))
                         @livewire('provider-plan-select-component')
                         @endif
                         @if (Route::is(['provider-reviews']))
                             <select class="select">
                                 <option>Newest</option>
                                 <option>Highest</option>
                                 <option>Lowest</option>
                             </select>
                         @endif
                     </div>
                     @if (Route::is(['provider-coupons', 'provider-offers', 'provider-earnings']))
                         <div class="grid-listview me-2">
                             <ul>
                                 <li>
                                     <a href="javascript:void(0);">
                                         <i class="feather-filter"></i>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     @endif
                     @if (
                         !Route::is([
                             'provider-reviews',
                             'provider-services',
                             'provider-services-list',
                             'provider-coupons',
                             'provider-offers',
                             'provider-earnings',
                         ]))
                         <div class="grid-listview">
                             <ul>
                                 <li>
                                     <a href="javascript:void(0);">
                                         <i class="feather-filter"></i>
                                     </a>
                                 </li>
                                 @if (
                                     !Route::is([
                                         'provider-dashboard',
                                         'provider-services',
                                         'provider-coupons',
                                         'provider-offers',
                                         'provider-reviews',
                                         'provider-earnings',
                                         'provider-services-list',
                                     ]))
                                     <li>
                                         <a href="{{ url('provider-book-details') }}"
                                             class="{{ Request::is('provider-book-details') ? 'active' : '' }}">
                                             <i class="feather-calendar"></i>
                                         </a>
                                     </li>
                                     <li>
                                         <a href="{{ url('provider-services') }}"
                                             class="{{ Request::is('provider-services') ? 'active' : '' }}">
                                             <i class="feather-grid"></i>
                                         </a>
                                     </li>
                                     <li>
                                         <a href="{{ url('provider-booking') }}"
                                             class="{{ Request::is('provider-booking') ? 'active' : '' }}">
                                             <i class="feather-list"></i>
                                         </a>
                                     </li>
                                 @endif
                                 @if (Route::is(['provider-services', 'provider-services-list']))
                                     <li>
                                         <a href="{{ url('provider-services') }}"
                                             class="{{ Request::is('provider-services') ? 'active' : '' }}">
                                             <i class="feather-grid"></i>
                                         </a>
                                     </li>
                                     <li>
                                         <a href="{{ url('provider-services-list') }}"
                                             class="{{ Request::is('provider-services-list') ? 'active' : '' }}">
                                             <i class="feather-list"></i>
                                         </a>
                                     </li>
                                 @endif
                             </ul>
                         </div>
                     @endif
                     @if (Route::is(['provider-services', 'provider-services-list']))
                         <div class="grid-listview me-2">
                             <ul>
                                 <li>
                                     <a href="javascript:void(0);">
                                         <i class="feather-filter"></i>
                                     </a>
                                 </li>
                                 <li>
                                     <a href="{{ url('provider-services') }}"
                                         class="{{ Request::is('provider-services') ? 'active' : '' }}">
                                         <i class="feather-grid"></i>
                                     </a>
                                 </li>
                                 <li>
                                     <a href="{{ url('provider-services-list') }}"
                                         class="{{ Request::is('provider-services-list') ? 'active' : '' }}">
                                         <i class="feather-list"></i>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     @endif
                     @if (Route::is(['provider-coupons']))
                         <button class="btn btn-primary add-set" data-bs-toggle="modal" data-bs-target="#add-coupon"><i
                                 class="feather-plus"></i> Add Coupon</button>
                     @endif
                     @if (Route::is(['provider-offers']))
                         <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#add-coupon"
                             class="btn btn-primary add-set"><i class="feather-plus"> </i>New Offer</a>
                     @endif
                     @if (Route::is(['provider-services', 'provider-services-list']))
                         <a href="{{ url('create-service') }}" class="btn btn-primary add-set"><i
                                 class="feather-plus me-2"></i>Add Service</a>
                     @endif

                 @endif
                 @if (Route::is(['provider-payout']))
                     <a href="javascript:;" class="btn btn-primary add-set" data-bs-toggle="modal"
                         data-bs-target="#add-payout"><i class="feather-settings me-2"></i>Set Payout</a>
                 @endif
             </div>
         @endif
         @if (Route::is(['provider-holiday']))
             <div class="col-md-8">
                 <div class="leave-action text-md-end">
                     <a href="javascript:;" class="btn btn-secondary"><i class="feather-file-text"></i> Leave
                         History</a>
                     <a href="javascript:;" class="btn btn-secondary" data-bs-toggle="modal"
                         data-bs-target="#add-holiday"><i class="feather-plus"></i> Add Holiday</a>
                     <a href="javascript:;" class="btn btn-primary add-set" data-bs-toggle="modal"
                         data-bs-target="#add-leave"><i class="feather-plus"></i> Add Leave</a>
                 </div>
             </div>
         @endif
     </div>
 </div>
 <!-- /Page Header -->
