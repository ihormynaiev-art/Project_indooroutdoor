@if (Route::is(['index-6']))
    <div class="modal fade modal-content-video" id="video" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="video-home">
                        <video controls id="promovideo">
                            <iframe src="https://www.youtube.com/embed/ExJZAegsOis"></iframe>
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if (Route::is(['booking-2']))
    <!-- Modal Succss -->
    <div class="modal fade add-service-modal" id="successmodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p>Booking has been successfully Confirmed on</p>
                    <div class="booking-date-time">
                        <i class="fa-regular fa-clock"> </i> 25 July 2023, 19:00 pm
                    </div>
                    <div class="popup-btn">
                        <a href="{{ url('customer-dashboard') }}" class="btn btn-primary">Go to Dashboard <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Succss -->
@endif
@if (Route::is(['customer-booking-calendar']))
    <!-- Reschedule Appointment -->
    <div class="modal fade custom-modal" id="add-reschedule">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Reschedule Appointment</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label class="col-form-label">Appointment Date</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker"
                                        placeholder="Select appointment date">
                                    <span class="cus-icon"><i class="feather-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Appointment Time</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker"
                                        placeholder="Select appointment date">
                                    <span class="cus-icon"><i class="feather-clock"></i></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Reschedule Appointment -->

    <!-- Cancel Appointment -->
    <div class="modal fade custom-modal" id="alertmsg">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Cancel Appointment</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="msg-alert">
                            <p>Are you sure you want to cnacel <span>John Doe</span> appointment on <span>Oct 28,
                                    2023</span> at time <span>10AM - 12PM</span> </p>
                            <p>You wan't be able to revert this action later?</p>
                        </div>
                        <div class="modal-submit text-end">
                            <a href="javascript:;" class="btn btn-secondary me-2" data-bs-dismiss="modal">Dismiss</a>
                            <button type="submit" class="btn btn-primary">Yes, cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Cancel Appointment -->
@endif
@if (Route::is(['customer-booking']))
    <!-- Add Review -->
    <div class="modal fade custom-modal" id="add-review">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Write A Review</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="customer-booking">
                        <div class="write-review">
                            <div class="review-add">
                                <div class="rev-img">
                                    <img src="{{ URL::asset('/assets/img/services/service-19.jpg') }}" alt="image">
                                </div>
                                <div class="rev-info">
                                    <h6>Computer Services</h6>
                                    <p>Newyork, USA</p>
                                </div>
                            </div>
                            <div class="form-group form-info">
                                <label class="col-form-label">Rate The Service</label>
                                <div class="rating rating-select mb-0">
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                </div>
                            </div>
                            <div class="form-group form-info">
                                <label class="col-form-label">Write your Review</label>
                                <textarea class="form-control" rows="4" placeholder="Please write your review"></textarea>
                            </div>
                            <div class="modal-submit text-end">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Review -->

    <!-- Reschedule -->
    <div class="modal fade custom-modal reshchedule-modal" id="reschedule">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-body">
                    <div class="hide-show" id="show-first">
                        <div class="row">
                            <div class="col-lg-3 d-flex">
                                <div class="modal-active-dots text-center w-100">
                                    <ul>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Date & Time"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/modal-calender-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Date & time</h6>
                                        <p>Select date & time to schedule appointment</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form w-100">
                                    <div class="rechedule-calender">
                                        <div class="book-title">
                                            <h5>Select Date & Time</h5>
                                        </div>
                                        <div id="datetimepickershow"></div>
                                        <div class="pick-slot">
                                            <h6>Pick a Slot for <span> July 18</span></h6>
                                            <div class="token-slot">
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">08:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">08:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">09:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">09:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">10:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">10:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">11:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment" checked>
                                                        <span class="visit-rsn">11:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">12:00 pm</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">12:30 pm</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn disabled" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn" type="button">Next <i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <ul>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Date & Time"></li>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Enter Information"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/booking-info-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Enter Information</h6>
                                        <p>Ad your information for the appointment Booking</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Enter Information</h5>
                                        </div>
                                        <div class="card booking-info-tab h-100">
                                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="pills-guest-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-guest"
                                                        type="button" role="tab" aria-controls="pills-guest"
                                                        aria-selected="true">Book as Guest</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pills-user-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-user"
                                                        type="button" role="tab" aria-controls="pills-user"
                                                        aria-selected="false">Already have an account?</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-guest"
                                                    role="tabpanel" aria-labelledby="pills-guest-tab">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="email" class="form-control"
                                                                        placeholder="Email Address">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Phone Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Address">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="guest-address d-flex">
                                                                    <div class="guest-country w-100 me-2">
                                                                        <div class="form-group">
                                                                            <select class="select">
                                                                                <option>Country</option>
                                                                                <option>US</option>
                                                                                <option>Kuwait</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="guest-city w-100">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="City">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="guest-state-pin d-flex">
                                                                    <div class="guest-state w-100 me-2">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="State">
                                                                        </div>
                                                                    </div>
                                                                    <div class="guest-pin w-100">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Zipcode">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0">
                                                                    <textarea class="form-control" placeholder="Comments"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade guest-user-tab" id="pills-user"
                                                    role="tabpanel" aria-labelledby="pills-user-tab">
                                                    <form>
                                                        <div class="sub-title">
                                                            <h5>Login</h5>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="email" class="form-control"
                                                                        placeholder="Email Address">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Password">
                                                                </div>
                                                            </div>
                                                            <div class="get-new-password">
                                                                <p>Forgot Password ? <a href=""> Click to Get
                                                                        Link</a></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <button class="btn btn-primary w-100">Login</button>
                                                            </div>
                                                        </div>
                                                        <div class="join-user">
                                                            <a href="javascript:;"><i
                                                                    class="fa-solid fa-user me-2"></i>Join as a
                                                                User</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn" type="button">Next <i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <ul>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Date & Time"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Enter Information"></li>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Payment Gateway"></li>
                                        <li class="active-dot"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/payment-gateway-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Payment Gateway</h6>
                                        <p>Select your payment type to pay for appointment</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Payment Gateway</h5>
                                        </div>
                                        <div class="card booking-info-tab h-100">
                                            <div class="payment-card">
                                                <div class="payment-head">
                                                    <div class="payment-title">
                                                        <label class="custom_radio">
                                                            <input type="radio" name="payment" class="card-payment"
                                                                checked="">

                                                        </label>
                                                        <h6>Paypal</h6>
                                                    </div>
                                                    <div class="card-icon">
                                                        <img src="{{ URL::asset('/assets/img/icons/paypal-icon.svg') }}"
                                                            alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment-card payment-bg">
                                                <div class="payment-head">
                                                    <div class="payment-title">
                                                        <label class="custom_radio">
                                                            <input type="radio" name="payment"
                                                                class="card-payment">

                                                        </label>
                                                        <h6>Credit / Debit Card</h6>
                                                    </div>
                                                    <div class="card-icon">
                                                        <img src="{{ URL::asset('/assets/img/card-icon-1.png') }}"
                                                            alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment-card">
                                                <div class="payment-head">
                                                    <div class="payment-title">
                                                        <label class="custom_radio credit-card-option">
                                                            <input type="radio" name="payment"
                                                                class="card-payment">

                                                        </label>
                                                        <h6>Cash on Delivery</h6>
                                                    </div>
                                                    <div class="card-icon">
                                                        <img src="{{ URL::asset('/assets/img/card-icon-2.png') }}"
                                                            alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn submit-btn" type="button">Submit
                                                <i class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li class="droped-item">
                                                    <div class="detail-list">
                                                        <h5>Customer Details <i class="fa-solid fa-circle-info"></i>
                                                        </h5>
                                                        <h6 class="date-red">Testuser</h6>
                                                    </div>
                                                    <ul class="customer-detail-list">
                                                        <li>
                                                            <h6>Email Address</h6>
                                                            <p>john@example.com</p>
                                                        </li>
                                                        <li>
                                                            <h6>Phone Number</h6>
                                                            <p>+1 63993 35556</p>
                                                        </li>
                                                        <li>
                                                            <h6>Address</h6>
                                                            <p>578 Fleming StreetMontgomery, AL 36104</p>
                                                        </li>
                                                        <li>
                                                            <h6>Comments</h6>
                                                            <p>Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry.</p>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <ul>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Tooltip on top"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Enter Information"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Payment Gateway"></li>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Payment Gateway"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/payment-gateway-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Payment Gateway</h6>
                                        <p>Select your payment type to pay for appointment</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Payment Gateway</h5>
                                        </div>
                                        <div class="card booking-info-tab h-100 justify-content-between">
                                            <div>
                                                <div class="sub-title">
                                                    <h5>Saved Cards</h5>
                                                </div>
                                                <div class="card-pay-save">
                                                    <div class="payment-card save-cards">
                                                        <div class="payment-head">
                                                            <div class="payment-title">
                                                                <label class="custom_radio">
                                                                    <input type="radio" name="payment"
                                                                        class="card-payment" checked>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <img src="{{ URL::asset('/assets/img/icons/saved-card-icon.svg') }}"
                                                                    alt="image">
                                                                <h6>Mastercard</h6>
                                                            </div>
                                                            <div class="card-number">
                                                                <span> ********* 1234</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="add-more-card-details">
                                                    <div class="add-more-card">
                                                        <a href="javascript:void(0);"><i
                                                                class="fa-solid fa-circle-plus"></i> Add new card</a>
                                                    </div>
                                                    <div class="hide-cards-group">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Name On Card">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="number" class="form-control"
                                                                placeholder="Card Number">
                                                        </div>
                                                        <div class="card-details d-flex">
                                                            <div class="expiry-date w-100 me-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Expiry Date">
                                                                </div>
                                                            </div>
                                                            <div class="cvv-num w-100">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="CVV Number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="save-later">
                                                            <label class="custom_check">
                                                                <input type="checkbox" name="rememberme"
                                                                    class="rememberme">
                                                                <span class="checkmark"></span>Save for later
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="secure-transaction">
                                                    <span><i class="fa-solid fa-lock"></i></span>
                                                    <p>All transactions are secure and encrypted. Credit card
                                                        information is never stored.</p>
                                                </div>
                                            </div>
                                            <div class="total-price">
                                                <h5>Total Booking Price : <span class="price-value"> $251.36</span>
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn submit-btn" type="button">Next<i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li class="droped-item">
                                                    <div class="detail-list">
                                                        <h5>Customer Details <i class="fa-solid fa-circle-info"></i>
                                                        </h5>
                                                        <h6 class="date-red">Testuser</h6>
                                                    </div>
                                                    <ul class="customer-detail-list">
                                                        <li>
                                                            <h6>Email Address</h6>
                                                            <p>john@example.com</p>
                                                        </li>
                                                        <li>
                                                            <h6>Phone Number</h6>
                                                            <p>+1 63993 35556</p>
                                                        </li>
                                                        <li>
                                                            <h6>Address</h6>
                                                            <p>578 Fleming StreetMontgomery, AL 36104</p>
                                                        </li>
                                                        <li>
                                                            <h6>Comments</h6>
                                                            <p>Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry.</p>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-xl-4 col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/appointment-confirm-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Confirm Order</h6>
                                        <p>Handles different career a accordingly, after a of the for found customary
                                            feedback by happiness</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-9 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Confirmation</h5>
                                        </div>
                                        <div class="card booking-confirmation-info h-100 mb-0">
                                            <div class="card-body">
                                                <div class="appointment-details">
                                                    <div class="details-head">
                                                        <h6>Appointment Details</h6>
                                                        <span>UBID-52</span>
                                                    </div>
                                                    <div class="add-calender">
                                                        <a href=""><span><i
                                                                    class="fa-solid fa-calendar-days"></i></span>Add to
                                                            Calender</a>
                                                    </div>
                                                </div>
                                                <div class="confirmation-product-card">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <div class="service-item">
                                                                <span>
                                                                    <img src="{{ URL::asset('/assets/img/product-confirm-img.jpg') }}"
                                                                        class="img-fluid" alt="image">
                                                                </span>
                                                                <div class="product-info">
                                                                    <h5>Computer Services</h5>
                                                                    <span class="duration">Duration : 30 Min</span>
                                                                    <span class="date-time">July 18, 11:30 am - 12:30
                                                                        pm </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="product-info service-additional">
                                                                <h6>Additional Service</h6>
                                                                <span>Changing Switch Boards</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="product-info service-cost">
                                                                <h6>Total Paid</h6>
                                                                <span>$400</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="customer-provider">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="name-card">
                                                                <h6>Customer</h6>
                                                                <div class="profile-detail">
                                                                    <span class="profile-pic"><img
                                                                            src="{{ URL::asset('/assets/img/profiles/avatar-21.jpg') }}"
                                                                            class="img-fluid" alt="image"></span>
                                                                    <div class="email-name">
                                                                        <span>Adrian</span>
                                                                        <p>testuser@example.com</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="name-card">
                                                                <h6>Provider</h6>
                                                                <div class="profile-detail">
                                                                    <span class="profile-pic"><img
                                                                            src="{{ URL::asset('/assets/img/profiles/avatar-22.jpg') }}"
                                                                            class="img-fluid" alt="image"></span>
                                                                    <div class="email-name">
                                                                        <span>Harrris</span>
                                                                        <a href="">Learn More</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payed-method">
                                                    <span>Payment Method : Debit card</span>
                                                </div>
                                                <div class="field-bottom-btns select-timing justify-content-end">
                                                    <div class="field-btns">
                                                        <button class="btn btn-primary next_btn submit-btn"
                                                            type="button" data-bs-toggle="modal"
                                                            data-bs-target="#successmodal">Confirm Order <i
                                                                class="fa-solid fa-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Reschedule -->

    <!-- Modal Succss -->
    <div class="modal fade add-service-modal booking-success-modal" id="successmodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p>Booking has been successfully Confirmed on</p>
                    <div class="booking-date-time">
                        <i class="fa-regular fa-clock"> </i> 25 July 2023, 19:00 pm
                    </div>
                    <div class="popup-btn">
                        <a href="{{ url('customer-booking') }}" class="btn btn-primary">Go to Dashboard <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Succss -->
@endif
@if (Route::is(['customer-wallet']))
    <!-- Add Wallet -->
    <div class="modal fade custom-modal" id="add-wallet">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Add Wallet</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label class="col-form-label pt-0">Amount</label>
                                <input type="text" class="form-control" placeholder="Enter Amount">
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="bank-selection">
                                        <input type="radio" value="attach_link" id="rolelink" name="attachment"
                                            checked="">
                                        <label for="rolelink">
                                            <img src="{{ URL::asset('/assets/img/paypal.png') }}" alt="Paypal">
                                            <span class="role-check"><i class="fa-solid fa-circle-check"></i></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="bank-selection">
                                        <input type="radio" value="attach_link" id="rolelink1" name="attachment">
                                        <label for="rolelink1">
                                            <img src="{{ URL::asset('/assets/img/stripe.png') }}" alt="Stripe">
                                            <span class="role-check"><i class="fa-solid fa-circle-check"></i></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="bank-selection">
                                        <input type="radio" value="attach_link" id="rolelink2" name="attachment">
                                        <label for="rolelink2">
                                            <img src="{{ URL::asset('/assets/img/bank.png') }}" alt="image">
                                            <span class="role-check"><i class="fa-solid fa-circle-check"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Wallet -->
@endif
@if (Route::is(['provider-booking']))
    <!-- Add Review -->
    <div class="modal fade custom-modal" id="add-review">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile p-0">
                <div class="modal-header border-bottom-0 text-strat justify-content-between mb-0 p-4">
                    <h5 class="modal-title">Write A Review</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="provider-booking">
                        <div class="write-review">
                            <div class="review-add">
                                <div class="rev-img">
                                    <img src="{{ URL::asset('assets/img/services/service-19.jpg') }}" alt="image">
                                </div>
                                <div class="rev-info">
                                    <h6>Computer Services</h6>
                                    <p>Newyork, USA</p>
                                </div>
                            </div>
                            <div class="form-group form-info">
                                <label class="col-form-label">Rate The Service</label>
                                <div class="rating rating-select mb-0">
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                </div>
                            </div>
                            <div class="form-group form-info">
                                <label class="col-form-label">Write your Review</label>
                                <textarea class="form-control" rows="4" placeholder="Please write your review"></textarea>
                            </div>
                            <div class="modal-submit text-end">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Review -->
@endif
@if (Route::is(['provider-coupons']))
    <!-- Add Coupon  -->
    <div class="modal modal-lg fade custom-modal" id="add-coupon">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Add Coupon</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="provider-coupons">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Services</label>
                                    <select class="select">
                                        <option>Select Services</option>
                                        <option>Car Repair</option>
                                        <option>House Cleaning</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Coupon Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Coupon Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Code</label>
                                    <input type="text" class="form-control" placeholder="Enter Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Coupon Type</label>
                                    <select class="select">
                                        <option>Fixed</option>
                                        <option>Percentage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Discount</label>
                                    <input type="text" class="form-control" placeholder="10">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Start Date</label>
                                    <div class="form-icon">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="Select Date">
                                        <span class="cus-icon"><i class="feather-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">End Date</label>
                                    <div class="form-icon">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="Select Date">
                                        <span class="cus-icon"><i class="feather-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Company Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Company Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label"></label>
                                    <div class="status-toggle blue-tog d-flex align-items-center text-dark fw-500">
                                        <input type="checkbox" id="status" class="check" checked="">
                                        <label for="status" class="checktoggle me-2">checkbox</label>
                                        Once per customer
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <div class="form-group coupon-radio">
                                        <label class="custom_radio d-inline-block me-3">
                                            <input type="radio" name="status" checked="">
                                            <span class="checkmark"></span> Active
                                        </label>
                                        <label class="custom_radio d-inline-block">
                                            <input type="radio" name="status">
                                            <span class="checkmark"></span> Inactive
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row float-end">
                            <div class="col-md-5 coupon-submit">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Coupon  -->

    <!-- Edit Coupon  -->
    <div class="modal modal-lg fade custom-modal" id="edit-coupon">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Edit Coupon</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="provider-coupons">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Services</label>
                                    <select class="select">
                                        <option>Select Services</option>
                                        <option>Car Repair</option>
                                        <option>House Cleaning</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Coupon Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Coupon Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Code</label>
                                    <input type="text" class="form-control" placeholder="Enter Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Coupon Type</label>
                                    <select class="select">
                                        <option>Fixed</option>
                                        <option>Percentage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Discount</label>
                                    <input type="text" class="form-control" placeholder="10">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Start Date</label>
                                    <div class="form-icon">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="Select Date">
                                        <span class="cus-icon"><i class="feather-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">End Date</label>
                                    <div class="form-icon">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="Select Date">
                                        <span class="cus-icon"><i class="feather-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Company Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Company Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label"></label>
                                    <div class="status-toggle blue-tog d-flex align-items-center text-dark fw-500">
                                        <input type="checkbox" id="status-1" class="check" checked="">
                                        <label for="status-1" class="checktoggle me-2">checkbox</label>
                                        Once per customer
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <div class="form-group coupon-radio">
                                        <label class="custom_radio d-inline-block me-3">
                                            <input type="radio" name="status" checked="">
                                            <span class="checkmark"></span> Active
                                        </label>
                                        <label class="custom_radio d-inline-block">
                                            <input type="radio" name="status">
                                            <span class="checkmark"></span> Inactive
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row float-end">
                            <div class="col-md-5 coupon-submit">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Coupon  -->
@endif
@if (Route::is(['provider-edit-service']))
    <!-- Inactive Service -->
    <div class="modal fade custom-modal" id="in-active">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Inactive Service</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="provider-services">
                            <p>Are you sure want to inactive this service?</p>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Inactive Service -->

    <!-- Active Service -->
    <div class="modal fade custom-modal" id="active">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Active Service</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="provider-services">
                            <p>Are you sure want to active this service?</p>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Inactive Service -->

    <!-- Delete Service -->
    <div class="modal fade custom-modal" id="del-service">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Delete Service</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="provider-services">
                            <p>Are you sure want to delete this service?</p>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Service -->

    <!-- Delete Account -->
    <div class="modal fade custom-modal" id="del-account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="login">
                            <p>Are you sure you want to delete This Account? To delete your account, Type your password.
                            </p>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control pass-input"
                                        placeholder="*************">
                                    <span class="toggle-password feather-eye-off"></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Account -->
@endif
@if (Route::is([
        'customer-profile',
        'security-settings',
        'customer-notifications',
        'connected-apps',
        'provider-dashboard',
        'provider-services',
        'provider-payout',
        'provider-availability',
        'provider-holiday',
        'provider-coupons',
        'provider-subscription',
        'provider-addons',
        'provider-offers',
        'provider-reviews',
        'provider-earnings',
        'provider-chat',
        'provider-appointment-settings',
        'provider-profile-settings',
        'provider-social-profile',
        'provider-security-settings',
        'provider-plan',
        'payment-settings',
        'provider-notifcations',
        'provider-connected-apps',
        'add-subscription',
        'provider-book-details',
        'device-management',
        'login-activity',
        'provider-booking',
        'provider-details',
        'provider-device-management',
        'provider-login-activity',
    ]))
    <!-- Delete Account -->
    <div class="modal fade custom-modal" id="del-account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="login">
                            <p>Are you sure you want to delete this account? To delete your account, Type your password.
                            </p>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control pass-input"
                                        placeholder="*************">
                                    <span class="toggle-password feather-eye-off"></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Account -->
@endif
@if (Route::is(['provider-dashboard']))
    <!-- Add Review -->
    <div class="modal fade custom-modal" id="add-review">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Write A Review</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="provider-dashboard">
                        <div class="write-review">
                            <div class="review-add">
                                <div class="rev-img">
                                    <img src="{{ URL::asset('assets/img/services/service-19.jpg') }}"
                                        alt="image">
                                </div>
                                <div class="rev-info">
                                    <h6>Computer Services</h6>
                                    <p>Newyork, USA</p>
                                </div>
                            </div>
                            <div class="form-group form-info">
                                <label class="col-form-label">Rate The Service</label>
                                <div class="rating rating-select mb-0">
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                    <a href="javascript:void(0);"><i class="fas fa-star"></i></a>
                                </div>
                            </div>
                            <div class="form-group form-info">
                                <label class="col-form-label">Write your Review</label>
                                <textarea class="form-control" rows="4" placeholder="Please write your review"></textarea>
                            </div>
                            <div class="modal-submit text-end">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Review -->
@endif
@if (Route::is(['security-settings', 'provider-security-settings']))
    <!-- Change Email -->
    <div class="modal fade custom-modal" id="change-email">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Change Email</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="provider-security-settings">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label class="col-form-label">Current Email Address</label>
                                <input type="email" class="form-control" placeholder="Enter Email Address">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">New Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Enter Email Address">
                                <p class="brief-bio mb-0 mt-2"><i class="feather-alert-circle"></i> New Email
                                    Address Only Updated Once You Verified</p>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Confirm New Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control pass-input"
                                        placeholder="*************">
                                    <span class="toggle-password feather-eye-off"></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="#" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button class="btn btn-primary">Change Email</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Email -->

    <!-- Change Phone  -->
    <div class="modal fade custom-modal" id="change-phone">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Change Phone Number</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="provider-security-settings">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label class="col-form-label">Current Phone Number</label>
                                <input class="form-control form-control-lg group_formcontrol" id="phone"
                                    name="phone" type="text" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">New Phone Number <span
                                        class="text-danger">*</span></label>
                                <input class="form-control form-control-lg group_formcontrol" id="phone1"
                                    name="phone" type="text" placeholder="Enter Phone Number">
                                <p class="brief-bio mb-0 mt-2"><i class="feather-alert-circle"></i> New Phone Number
                                    Only Updated Once You Verified</p>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Confirm New Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control pass-input"
                                        placeholder="*************">
                                    <span class="toggle-password feather-eye-off"></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button class="btn btn-primary">Change Number</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Phone  -->

    <!-- Change Password  -->
    <div class="modal fade custom-modal" id="change-password">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="success">
                        <div class="form-group">
                            <label class="col-form-label">Current Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-input-current"
                                    placeholder="*************">
                                <span class="toggle-password-current feather-eye-off"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">New Password</label>
                            <div class="pass-group" id="passwordInput">
                                <input type="password" class="form-control pass-input-new"
                                    placeholder="*************">
                                <span class="toggle-password-new feather-eye-off"></span>
                            </div>
                            <div class="password-strength" id="passwordStrength">
                                <span id="poor"></span>
                                <span id="weak"></span>
                                <span id="strong"></span>
                                <span id="heavy"></span>
                            </div>
                            <div id="passwordInfo">Use 8 or more characters with a mix of letters, numbers & symbols.
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Confirm New Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-input"
                                    placeholder="*************">
                                <span class="toggle-password feather-eye-off"></span>
                            </div>
                        </div>
                        <div class="acc-submit">
                            <a href="javascript:;" class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary" type="submit">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Password  -->
@endif

@if (Route::is(['provider-services', 'provider-services-list']))
    <!-- Inactive Service -->
    <div class="modal fade custom-modal" id="in-active">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Inactive Service</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="provider-services">
                            <p>Are you sure want to inactive this service?</p>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Inactive Service -->

    <!-- Active Service -->
    <div class="modal fade custom-modal" id="active">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Active Service</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="provider-services">
                            <p>Are you sure want to active this service?</p>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Inactive Service -->

    <!-- Delete Service -->
    <div class="modal fade custom-modal" id="del-service">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Delete Service</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="provider-services">
                            <p>Are you sure want to delete this service?</p>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Service -->
@endif
@if (Route::is(['provider-payout']))
    <!-- Add Wallet -->
    <div class="modal fade custom-modal" id="add-payout">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between pb-0">
                    <h5 class="modal-title">Set Your Payouts</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body">
                    <form action="provider-payout">
                        <div class="wallet-add">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="bank-selection">
                                        <input type="radio" value="attach_link" id="rolelink"
                                            name="attachment" checked="">
                                        <label for="rolelink">
                                            <img src="{{ URL::asset('/assets/img/paypal.png') }}" alt="Paypal">
                                            <span class="role-check"><i class="fa-solid fa-circle-check"></i></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="bank-selection">
                                        <input type="radio" value="attach_link" id="rolelink1"
                                            name="attachment">
                                        <label for="rolelink1">
                                            <img src="{{ URL::asset('/assets/img/stripe.png') }}" alt="Stripe">
                                            <span class="role-check"><i class="fa-solid fa-circle-check"></i></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="bank-selection">
                                        <input type="radio" value="attach_link" id="rolelink2"
                                            name="attachment">
                                        <label for="rolelink2">
                                            <img src="{{ URL::asset('/assets/img/bank.png') }}" alt="image">
                                            <span class="role-check"><i class="fa-solid fa-circle-check"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Card Number</label>
                                <input type="text" class="form-control" placeholder="Enter Card Number">
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Wallet -->
@endif
@if (Route::is(['provider-holiday']))
    <!-- Add Holiday -->
    <div class="modal fade custom-modal" id="add-holiday">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Add Holiday</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label class="col-form-label">Holiday Name</label>
                                <input type="text" class="form-control" placeholder="Enter Holiday Name">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">From</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker"
                                        placeholder="Select Date">
                                    <span class="cus-icon">
                                        <i class="feather-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">To</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker"
                                        placeholder="Select Date">
                                    <span class="cus-icon">
                                        <i class="feather-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Description</label>
                                <textarea class="form-control" rows="4" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Holiday -->

    <!-- Add Leave -->
    <div class="modal fade custom-modal" id="add-leave">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label class="col-form-label">From</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker"
                                        placeholder="Select Date">
                                    <span class="cus-icon">
                                        <i class="feather-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">To</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker"
                                        placeholder="Select Date">
                                    <span class="cus-icon">
                                        <i class="feather-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Reason</label>
                                <textarea class="form-control" rows="3" placeholder="Enter Reason"></textarea>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave -->

    <!-- Alert Message -->
    <div class="modal fade custom-modal" id="alertmsg">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Alert Message</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="msg-alert">
                            <p>If You Take Your Appointment Automatically Cancelled.</p>
                        </div>
                        <div class="modal-submit text-end">
                            <a href="javascript:;" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary">Ok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Alert Message -->
@endif
@if (Route::is(['provider-offers']))
    <!-- Add Coupon -->
    <div class="modal fade custom-modal" id="add-coupon">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">New Offer</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="wallet-add">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Offer Type</label>
                                        <select class="select">
                                            <option>Select Type</option>
                                            <option>fixed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Start Date</label>
                                        <div class="form-icon">
                                            <input type="text" class="form-control datetimepicker"
                                                placeholder="Select Date">
                                            <span class="cus-icon"><i class="feather-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">End Date</label>
                                        <div class="form-icon">
                                            <input type="text" class="form-control datetimepicker"
                                                placeholder="Select Date">
                                            <span class="cus-icon"><i class="feather-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Coupon -->

    <!-- Edit Coupon -->
    <div class="modal fade custom-modal" id="edit-coupon">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Edit Offer</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="wallet-add">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Offer Type</label>
                                        <select class="select">
                                            <option>Select Type</option>
                                            <option>fixed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Start Date</label>
                                        <div class="form-icon">
                                            <input type="text" class="form-control datetimepicker"
                                                placeholder="Select Date">
                                            <span class="cus-icon"><i class="feather-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">End Date</label>
                                        <div class="form-icon">
                                            <input type="text" class="form-control datetimepicker"
                                                placeholder="Select Date">
                                            <span class="cus-icon"><i class="feather-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Coupon -->

    <!-- Delete Account -->
    <div class="modal fade custom-modal" id="del-account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="login">
                            <p>Are you sure you want to delete this account? To delete your account, Type your password.
                            </p>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control pass-input"
                                        placeholder="*************">
                                    <span class="toggle-password feather-eye-off"></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="#" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Account -->
@endif
@if (Route::is(['provider-book-details']))
    <!-- Add Leave -->
    <div class="modal fade custom-modal" id="add-reschedule">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Reschedule Appointment</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label class="col-form-label">Appointment Date</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker"
                                        placeholder="Select appointment date">
                                    <span class="cus-icon"><i class="feather-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Appointment Time</label>
                                <div class="form-icon">
                                    <input type="text" class="form-control timepicker"
                                        placeholder="Select appointment date">
                                    <span class="cus-icon"><i class="feather-clock"></i></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave -->

    <!-- Alert Message -->
    <div class="modal fade custom-modal" id="alertmsg">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Cancel Appointment</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <form action="#">
                        <div class="msg-alert">
                            <p>Are you sure you want to cnacel <span>John Doe</span> appointment on <span>Oct 28,
                                    2023</span> at time <span>10AM - 12PM</span> </p>
                            <p>You wan't be able to revert this action later?</p>
                        </div>
                        <div class="modal-submit text-end">
                            <a href="javascript:;" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Dismiss</a>
                            <button type="submit" class="btn btn-primary">Yes, cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Alert Message -->

    <!-- Booking Details -->
    <div class="toggle-sidebar">
        <div class="sidebar-layout">
            <div class="sidebar-header">
                <h5>Booking Details</h5>
                <a href="javascript:;" class="sidebar-close"><i class="feather-x"></i></a>
            </div>
            <div class="sidebar-body">
                <div class="book-confirm bk-wrap">
                    <div class="d-flex justify-content-between">
                        <h6>Services<span class="badge-success">Confirmed</span></h6>
                        <a href="javascript:;" class="edit-book"><i class="feather-edit"></i></a>
                    </div>
                    <ul>
                        <li><span class="bk-date"><i class="feather-calendar"></i> Date & Time </span> : Oct 28,
                            2023
                            - 10AM to 12 AM</li>
                        <li><span class="bk-date"><i class="feather-map-pin"></i> Location </span> : New York</li>
                        <li><span class="bk-date"><i class="feather-user"></i> User Name </span> : John Smith</li>
                    </ul>
                    <div class="bk-action">
                        <a href="javascript:;" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#add-reschedule"><i class="feather-user"></i> Reschedule</a>
                        <a href="javascript:;" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#alertmsg"><i class="feather-x-circle"></i> Cancel</a>
                    </div>
                </div>
                <div class="book-customer bk-wrap">
                    <h5>Customer Details</h5>
                    <div class="d-flex flex-wrap">
                        <div class="book-email">
                            <img src="{{ URL::asset('/assets/img/profiles/avatar-02.jpg') }}" alt="">
                            <div>
                                <p>John Doe</p>
                                <p>john@gmail.com</p>
                            </div>
                        </div>
                        <div class="book-email-info">
                            <div>
                                <p>+1 888 888 8888</p>
                                <p>Montana, USA</p>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary btn-mail"><img
                                    src="{{ URL::asset('/assets/img/icons/message.svg') }}" alt="">
                                Chat</a>
                        </div>
                    </div>
                </div>
                <div class="bk-wrap">
                    <h5>Appointment Message</h5>
                    <p>Thanks for your interest in our services</p>
                </div>
                <div class="bk-wrap bk-service">
                    <div>
                        <h5>House Cleaning Services</h5>
                        <p>quick and quality service</p>
                    </div>
                    <p class="bk-price">$100.00</p>
                </div>
                <div class="bk-wrap bk-history">
                    <h4>Booking History</h4>
                    <ul>
                        <li>
                            <span>
                                <i class="feather-calendar"></i>
                            </span>
                            <div class="book-crete">
                                <h6>Booking created</h6>
                                <p>Oct 28 2023 1:28 PM</p>
                            </div>
                        </li>
                        <li>
                            <span>
                                <i class="feather-user"></i>
                            </span>
                            <div class="book-crete">
                                <h6>Assigned to John Smith</h6>
                                <p>Oct 28 2023 1:28 PM</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Booking Details -->
@endif
@if (Route::is(['security-settings']))
    <!-- Delete Service -->
    <div class="modal fade custom-modal" id="del-phone">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Phone Number Verification</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        @if (!Route::is(['provider-security-settings']))
                            <form action="security-settings">
                        @endif
                        @if (Route::is(['provider-security-settings']))
                            <form action="provider-security-settings">
                        @endif
                        <p>Are you sure want to delete?</p>
                        <div class="modal-submit text-end">
                            <button type="submit" class="btn btn-primary">Yes</button>
                            <a href="javascript:;" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="del-email">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Email Verification</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        @if (!Route::is(['provider-security-settings']))
                            <form action="security-settings">
                        @endif
                        @if (Route::is(['provider-security-settings']))
                            <form action="provider-security-settings">
                        @endif
                        <p>Are you sure want to delete?</p>
                        <div class="modal-submit text-end">
                            <button type="submit" class="btn btn-primary">Yes</button>
                            <a href="javascript:;" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Service -->
@endif

@if (Route::is(['create-service']))
    <!-- Modal Succss -->
    <div class="modal fade add-service-modal" id="successmodal" tabindex="-1" aria-labelledby="successmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p>Service has been created succeessfully</p>
                    <div class="popup-btn">
                        <a href="{{ url('provider-services') }}" class="btn btn-primary">Go to Dashboard <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Succss -->
@endif

@if (Route::is(['provider-edit-service']))
    <!-- Modal Succss -->
    <div class="modal fade add-service-modal" id="successmodal" tabindex="-1" aria-labelledby="successmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p>Service has been edited succeessfully</p>
                    <div class="popup-btn">
                        <a href="{{ url('provider-services') }}" class="btn btn-primary">Go to Dashboard <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Succss -->
@endif
@if (Route::is(['service-details2']))
    <!-- Service-select -->
    <div class="modal fade custom-modal reshchedule-modal" id="service-select">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content service-profile doctor-profile">
                <div class="modal-body">
                    <div class="hide-show" id="show-first">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <ul>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Service"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/select-service-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Select Service</h6>
                                        <p>Please select a service you want to schedule appointment for</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender service-wrap-content">
                                        <div class="book-title">
                                            <h5>Select Service</h5>
                                        </div>
                                        <div
                                            class="computer-service d-flex align-items-center justify-content-between">
                                            <div class="comp-service-wrap d-flex align-items-center">
                                                <div class="comp-serv-img">
                                                    <img src="{{ URL::asset('/assets/img/booking-service.png') }}"
                                                        class="img-fluid" alt="Img">
                                                </div>
                                                <div class="comp-serv-header">
                                                    <h5>Computer Services</h5>
                                                    <p>Customers can schedule an appointment by filling out this form.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="comp-service-amount">
                                                <h5>$40.00</h5>
                                            </div>
                                        </div>
                                        <div class="additional-title">
                                            <h5>Add Additional service</h5>
                                        </div>
                                        <div
                                            class="save-later service-add-server d-flex align-items-center justify-content-between">
                                            <label class="custom_check">
                                                <input type="checkbox" name="rememberme" class="rememberme">
                                                <span class="checkmark service-check"></span>Changing Switch Boards
                                            </label>
                                            <div class="save-later-amount">
                                                <h5>$10.00</h5>
                                            </div>
                                        </div>
                                        <div
                                            class="save-later service-add-server d-flex align-items-center justify-content-between">
                                            <label class="custom_check">
                                                <input type="checkbox" name="rememberme" class="rememberme">
                                                <span class="checkmark service-check"></span>Swapping of Lines &
                                                Circuits
                                            </label>
                                            <div class="save-later-amount">
                                                <h5>$10.00</h5>
                                            </div>
                                        </div>
                                        <div
                                            class="save-later service-add-server d-flex align-items-center justify-content-between">
                                            <label class="custom_check">
                                                <input type="checkbox" name="rememberme" class="rememberme">
                                                <span class="checkmark service-check"></span>Changing Switch Boards
                                            </label>
                                            <div class="save-later-amount">
                                                <h5>$10.00</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-end">
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn" type="button">Next <i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li>
                                                    <div class="detail-list">
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-lg-3 d-flex">
                                <div class="modal-active-dots text-center w-100">
                                    <ul>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Service"></li>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Date & Time"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/modal-calender-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Date & time</h6>
                                        <p>Select date & time to schedule appointment</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form w-100">
                                    <div class="rechedule-calender">
                                        <div class="book-title">
                                            <h5>Select Date & Time</h5>
                                        </div>
                                        <div id="datetimepickershow"></div>
                                        <div class="pick-slot">
                                            <h6>Pick a Slot for <span> July 18</span></h6>
                                            <div class="token-slot">
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">08:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">08:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">09:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">09:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">10:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">10:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">11:00 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment" checked>
                                                        <span class="visit-rsn">11:30 am</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">12:00 pm</span>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline visits me-0">
                                                    <label class="visit-btns">
                                                        <input type="radio" class="form-check-input"
                                                            name="appintment">
                                                        <span class="visit-rsn">12:30 pm</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn" type="button">Next <i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <ul>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Service"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Date & Time"></li>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Enter Information"></li>
                                        <li class="active-dot"></li>
                                        <li class="active-dot"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/booking-info-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Enter Information</h6>
                                        <p>Ad your information for the appointment Booking</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Enter Information</h5>
                                        </div>
                                        <div class="card booking-info-tab h-100">
                                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="pills-guest-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-guest"
                                                        type="button" role="tab" aria-controls="pills-guest"
                                                        aria-selected="true">Book as Guest</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pills-user-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-user"
                                                        type="button" role="tab" aria-controls="pills-user"
                                                        aria-selected="false">Already have an account?</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-guest"
                                                    role="tabpanel" aria-labelledby="pills-guest-tab">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="email" class="form-control"
                                                                        placeholder="Email Address">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Phone Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Address">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="guest-address d-flex">
                                                                    <div class="guest-country w-100 me-2">
                                                                        <div class="form-group">
                                                                            <select class="select">
                                                                                <option>Country</option>
                                                                                <option>US</option>
                                                                                <option>Kuwait</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="guest-city w-100">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                placeholder="City">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="guest-state-pin d-flex">
                                                                    <div class="guest-state w-100 me-2">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                placeholder="State">
                                                                        </div>
                                                                    </div>
                                                                    <div class="guest-pin w-100">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                placeholder="Zipcode">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0">
                                                                    <textarea class="form-control" placeholder="Comments"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade guest-user-tab" id="pills-user"
                                                    role="tabpanel" aria-labelledby="pills-user-tab">
                                                    <form>
                                                        <div class="sub-title">
                                                            <h5>Login</h5>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="email" class="form-control"
                                                                        placeholder="Email Address">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Password">
                                                                </div>
                                                            </div>
                                                            <div class="get-new-password">
                                                                <p>Forgot Password ? <a href=""> Click to Get
                                                                        Link</a></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <button class="btn btn-primary w-100">Login</button>
                                                            </div>
                                                        </div>
                                                        <div class="join-user">
                                                            <a href="javascript:;"><i
                                                                    class="fa-solid fa-user me-2"></i>Join as a
                                                                User</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn" type="button">Next <i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <ul>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Service"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Date & Time"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Enter Information"></li>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Payment Gateway"></li>
                                        <li class="active-dot"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/payment-gateway-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Payment Gateway</h6>
                                        <p>Select your payment type to pay for appointment</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Payment Gateway</h5>
                                        </div>
                                        <div class="card booking-info-tab h-100">
                                            <div class="payment-card">
                                                <div class="payment-head">
                                                    <div class="payment-title">
                                                        <label class="custom_radio">
                                                            <input type="radio" name="payment"
                                                                class="card-payment" checked="">

                                                        </label>
                                                        <h6>Paypal</h6>
                                                    </div>
                                                    <div class="card-icon">
                                                        <img src="{{ URL::asset('/assets/img/icons/paypal-icon.svg') }}"
                                                            alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment-card payment-bg">
                                                <div class="payment-head">
                                                    <div class="payment-title">
                                                        <label class="custom_radio">
                                                            <input type="radio" name="payment"
                                                                class="card-payment">

                                                        </label>
                                                        <h6>Credit / Debit Card</h6>
                                                    </div>
                                                    <div class="card-icon">
                                                        <img src="{{ URL::asset('/assets/img/card-icon-1.png') }}"
                                                            alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment-card">
                                                <div class="payment-head">
                                                    <div class="payment-title">
                                                        <label class="custom_radio credit-card-option">
                                                            <input type="radio" name="payment"
                                                                class="card-payment">

                                                        </label>
                                                        <h6>Cash on Delivery</h6>
                                                    </div>
                                                    <div class="card-icon">
                                                        <img src="{{ URL::asset('/assets/img/card-icon-2.png') }}"
                                                            alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn submit-btn"
                                                type="button">Submit <i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li class="droped-item">
                                                    <div class="detail-list">
                                                        <h5>Customer Details <i class="fa-solid fa-circle-info"></i>
                                                        </h5>
                                                        <h6 class="date-red">Testuser</h6>
                                                    </div>
                                                    <ul class="customer-detail-list">
                                                        <li>
                                                            <h6>Email Address</h6>
                                                            <p>john@example.com</p>
                                                        </li>
                                                        <li>
                                                            <h6>Phone Number</h6>
                                                            <p>+1 63993 35556</p>
                                                        </li>
                                                        <li>
                                                            <h6>Address</h6>
                                                            <p>578 Fleming StreetMontgomery, AL 36104</p>
                                                        </li>
                                                        <li>
                                                            <h6>Comments</h6>
                                                            <p>Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry.</p>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <ul>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Select Service"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Tooltip on top"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Enter Information"></li>
                                        <li class="active-dot activated" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Payment Gateway"></li>
                                        <li class="active-dot active" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Payment Gateway"></li>
                                    </ul>
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/payment-gateway-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Payment Gateway</h6>
                                        <p>Select your payment type to pay for appointment</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Payment Gateway</h5>
                                        </div>
                                        <div class="card booking-info-tab h-100 justify-content-between">
                                            <div>
                                                <div class="sub-title">
                                                    <h5>Saved Cards</h5>
                                                </div>
                                                <div class="card-pay-save">
                                                    <div class="payment-card save-cards">
                                                        <div class="payment-head">
                                                            <div class="payment-title">
                                                                <label class="custom_radio">
                                                                    <input type="radio" name="payments"
                                                                        class="" checked>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <img src="{{ URL::asset('/assets/img/icons/saved-card-icon.svg') }}"
                                                                    alt="image">
                                                                <h6>Mastercard</h6>
                                                            </div>
                                                            <div class="card-number">
                                                                <span> ********* 1234</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="add-more-card-details">
                                                    <div class="add-more-card">
                                                        <a href="javascript:void(0);"><i
                                                                class="fa-solid fa-circle-plus"></i> Add new card</a>
                                                    </div>
                                                    <div class="hide-cards-group">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Name On Card">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="number" class="form-control"
                                                                placeholder="Card Number">
                                                        </div>
                                                        <div class="card-details d-flex">
                                                            <div class="expiry-date w-100 me-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Expiry Date">
                                                                </div>
                                                            </div>
                                                            <div class="cvv-num w-100">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="CVV Number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="save-later">
                                                            <label class="custom_check">
                                                                <input type="checkbox" name="rememberme"
                                                                    class="rememberme">
                                                                <span class="checkmark"></span>Save for later
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="secure-transaction">
                                                    <span><i class="fa-solid fa-lock"></i></span>
                                                    <p>All transactions are secure and encrypted. Credit card
                                                        information is never stored.</p>
                                                </div>
                                            </div>
                                            <div class="total-price">
                                                <h5>Total Booking Price : <span class="price-value"> $251.36</span>
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="field-bottom-btns select-timing justify-content-between">
                                        <div class="field-btns">
                                            <button class="btn btn-primary prev_btnn" type="button"><i
                                                    class="fa-solid fa-arrow-left"></i>Prev</button>
                                        </div>
                                        <div class="field-btns">
                                            <button class="btn btn-primary next_btnn submit-btn"
                                                type="button">Next<i class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex">
                                <div class="card booking-summary-card">
                                    <div class="card-body">
                                        <div class="sub-title">
                                            <h5>Booking Summary</h5>
                                        </div>
                                        <div class="appointment-details">
                                            <ul>
                                                <li class="droped-item">
                                                    <div class="detail-list">
                                                        <h5>Customer Details <i class="fa-solid fa-circle-info"></i>
                                                        </h5>
                                                        <h6 class="date-red">Testuser</h6>
                                                    </div>
                                                    <ul class="customer-detail-list">
                                                        <li>
                                                            <h6>Email Address</h6>
                                                            <p>john@example.com</p>
                                                        </li>
                                                        <li>
                                                            <h6>Phone Number</h6>
                                                            <p>+1 63993 35556</p>
                                                        </li>
                                                        <li>
                                                            <h6>Address</h6>
                                                            <p>578 Fleming StreetMontgomery, AL 36104</p>
                                                        </li>
                                                        <li>
                                                            <h6>Comments</h6>
                                                            <p>Lorem Ipsum is simply dummy text of the printing and
                                                                typesetting industry.</p>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Appointment date & time</h5>
                                                        <h6 class="date-red">July 18, 11:30 am</h6>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Selected Service</h5>
                                                        <h6>Computer Services</h6>
                                                    </div>
                                                    <span>$40.00</span>
                                                </li>
                                                <li>
                                                    <div class="detail-list">
                                                        <h5>Additional Service</h5>
                                                        <h6>Changing Switch Boards</h6>
                                                    </div>
                                                    <span>$10.00</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <ul>
                                            <li>
                                                <h6>Sub Total</h6>
                                                <span>$257.00</span>
                                            </li>
                                            <li>
                                                <h6>Tax @ 12.5%</h6>
                                                <span>$5.36</span>
                                            </li>
                                            <li class="total-amount">
                                                <h6>Total</h6>
                                                <span>$251.36</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide-show">
                        <div class="row">
                            <div class="col-xl-4 col-lg-3">
                                <div class="modal-active-dots text-center">
                                    <div class="calender-modal">
                                        <img src="{{ URL::asset('/assets/img/icons/appointment-confirm-icon.svg') }}"
                                            alt="calender Icon">
                                        <h6>Confirm Order</h6>
                                        <p>Handles different career a accordingly, after a of the for found customary
                                            feedback by happiness</p>
                                    </div>
                                    <div class="call-help">
                                        <h6>Questions?
                                            <span>Call 321 546 8764 for help</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-9 d-flex">
                                <div class="main-booking-form d-flex w-100">
                                    <div class="rechedule-calender h-100">
                                        <div class="book-title">
                                            <h5>Confirmation</h5>
                                        </div>
                                        <div class="card booking-confirmation-info h-100 mb-0">
                                            <div class="card-body">
                                                <div class="appointment-details">
                                                    <div class="details-head">
                                                        <h6>Appointment Details</h6>
                                                        <span>UBID-52</span>
                                                    </div>
                                                    <div class="add-calender">
                                                        <a href=""><span><i
                                                                    class="fa-solid fa-calendar-days"></i></span>Add
                                                            to Calender</a>
                                                    </div>
                                                </div>
                                                <div class="confirmation-product-card">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <div class="service-item">
                                                                <span>
                                                                    <img src="{{ URL::asset('/assets/img/product-confirm-img.jpg') }}"
                                                                        class="img-fluid" alt="image">
                                                                </span>
                                                                <div class="product-info">
                                                                    <h5>Computer Services</h5>
                                                                    <span class="duration">Duration : 30 Min</span>
                                                                    <span class="date-time">July 18, 11:30 am - 12:30
                                                                        pm </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="product-info service-additional">
                                                                <h6>Additional Service</h6>
                                                                <span>Changing Switch Boards</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="product-info service-cost">
                                                                <h6>Total Paid</h6>
                                                                <span>$400</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="customer-provider">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="name-card">
                                                                <h6>Customer</h6>
                                                                <div class="profile-detail">
                                                                    <span class="profile-pic"><img
                                                                            src="{{ URL::asset('/assets/img/profiles/avatar-21.jpg') }}"
                                                                            class="img-fluid" alt="image"></span>
                                                                    <div class="email-name">
                                                                        <span>Adrian</span>
                                                                        <p>testuser@example.com</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="name-card">
                                                                <h6>Provider</h6>
                                                                <div class="profile-detail">
                                                                    <span class="profile-pic"><img
                                                                            src="{{ URL::asset('/assets/img/profiles/avatar-22.jpg') }}"
                                                                            class="img-fluid" alt="image"></span>
                                                                    <div class="email-name">
                                                                        <span>Harrris</span>
                                                                        <a href="">Learn More</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payed-method">
                                                    <span>Payment Method : Debit card</span>
                                                </div>
                                                <div class="field-bottom-btns select-timing justify-content-end">
                                                    <div class="field-btns">
                                                        <button class="btn btn-primary next_btn submit-btn"
                                                            type="button" data-bs-toggle="modal"
                                                            data-bs-target="#successmodal">Confirm Order <i
                                                                class="fa-solid fa-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service-select -->

    <!-- Modal Succss -->
    <div class="modal fade add-service-modal booking-success-modal" id="successmodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p>Booking has been successfully Confirmed on</p>
                    <div class="booking-date-time">
                        <i class="fa-regular fa-clock"> </i> 25 July 2023, 19:00 pm
                    </div>
                    <div class="popup-btn">
                        <a href="" class="btn btn-primary">Go to Dashboard <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Succss -->
@endif

@if (Route::is(['provider.verification']))
    <!-- Delete Account -->
    <div class="modal fade custom-modal" id="del-account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 justify-content-between">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x"></i></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="write-review">
                        <form action="login">
                            <p>Are you sure you want to delete This Account? To delete your account, Type your password.
                            </p>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control pass-input"
                                        placeholder="*************">
                                    <span class="toggle-password feather-eye-off"></span>
                                </div>
                            </div>
                            <div class="modal-submit text-end">
                                <a href="javascript:;" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Account -->

    <!-- Change Phone  -->
    <div class="modal fade custom-modal verify-modal" id="change-phone">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header verfication-modal-head">
                    <h5 class="modal-title">Verify Your Phone Number</h5>
                    <p>You will receive a 4 digit code to verify next</p>
                </div>
                <div class="modal-body">
                    <form action="provider-security-settings">
                        <div class="wallet-add">
                            <div class="form-group">
                                <input class="form-control" name="phone" type="text"
                                    placeholder="Enter Phone Number">
                            </div>
                            <div class="modal-submit">
                                <a href="" class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#otp">Change Number</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Phone  -->

    <!-- OTP  -->
    <div class="modal fade custom-modal verify-modal" id="otp">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header verfication-modal-head">
                    <h5 class="modal-title">Enter OTP</h5>
                    <p>Code is sent to +1 23456789</p>
                </div>
                <div class="modal-body">
                    <form action="provider-security-settings" class="digit-group">
                        <div class="wallet-add">
                            <div class="otp-box">
                                <div class="forms-block text-center">
                                    <input type="text" id="digit-1" name="digit-1" data-next="digit-2"
                                        maxlength="1" value="1">
                                    <input type="text" id="digit-2" name="digit-2" data-next="digit-3"
                                        data-previous="digit-1" maxlength="1" value="2">
                                    <input type="text" id="digit-3" name="digit-3" data-next="digit-4"
                                        data-previous="digit-2" maxlength="1" value="3">
                                    <input type="text" id="digit-4" name="digit-4" data-next="digit-5"
                                        data-previous="digit-3" maxlength="1" value="4">
                                </div>
                            </div>
                            <div class="otp-timer text-center">
                                <h6>00:29</h6>
                            </div>
                            <div class="resend-code-otp text-center">
                                <p>Don’t <span> receive </span> code? <a href=""> Resend Code </a></p>
                            </div>
                            <div class="modal-submit">
                                <a href="" class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#success">Verify</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- OTP  -->

    <!-- Success phone -->
    <div class="modal fade success-modal verify-modal" id="success">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body success-body text-center">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p class="success-modal-body">Your phone number has been successfully verified</p>
                </div>
                <div class="popup-btn text-center">
                    <a href="" class="btn btn-primary verify-phone" onclick="verifiePhone()">Go to
                        Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Success  -->

    <!-- Change mail  -->
    <div class="modal fade custom-modal verify-modal" id="change-mail">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header verfication-modal-head">
                    <h5 class="modal-title">Verify Your Email Address</h5>
                    <p>Check your inbox for an verification link</p>
                </div>
                <div class="modal-body">
                    <form action="provider-security-settings">
                        <div class="wallet-add">
                            <div class="form-group">
                                <input class="form-control" name="phone" type="text"
                                    placeholder="Enter email address">
                            </div>
                            <div class="mail-check-verify">
                                <p>Didn't Receive verification email? Please check your spam folder or try to send the
                                    email</p>
                            </div>
                            <div class="modal-submit">
                                <a href="" class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#success-mail">Continue</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Phone  -->

    <!-- Success mail -->
    <div class="modal fade success-modal verify-modal" id="success-mail">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body success-body text-center">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p class="success-modal-body">Your Email address has been successfully verified</p>
                </div>
                <div class="popup-btn text-center">
                    <a href="" class="btn btn-primary verify-mail">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Success  -->

    <!-- Change Document -->
    <div class="modal fade custom-modal verify-modal" id="change-document">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header verfication-modal-head">
                    <h5 class="modal-title">Verify Your Identity</h5>
                    <p>Upload document</p>
                </div>
                <div class="modal-body">
                    <form action="provider-security-settings">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label>Document Name</label>
                                <input class="form-control" name="phone" type="text">
                            </div>
                            <div class="file-uploaded-mail">
                                <img src="{{ URL::asset('/assets/img/icons/upload-icon-02.svg') }}"
                                    class="img-fluid" alt="Upload">
                                <h4>Drag & drop files or <span> Browse </span></h4>
                                <p>Supported formats: PDF</p>
                                <input type="file" id="file-input" class="image-upload">
                            </div>
                            <div class="document-upload-file">
                                <p> <img src="{{ URL::asset('/assets/img/icons/file-pdf.svg') }}" class="img-fluid"
                                        alt="Pdf">
                                    licence.pdf </p>
                                <span>
                                    <a href="javascript:;">
                                        <img src="{{ URL::asset('/assets/img/icons/trash-alt.svg') }}"
                                            class="img-fluid" alt="Trash">
                                    </a>
                                </span>
                            </div>
                            <div class="document-update-success">
                                <p><i class="fa-regular fa-circle-check"></i> Document uploaded successfully </p>
                            </div>
                            <div class="modal-submit">
                                <a href="" class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#success-document">Continue</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Phone  -->

    <!-- Success mail -->
    <div class="modal fade success-modal verify-modal" id="success-document">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body success-body text-center">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p class="success-modal-body">Document is sent for approval for the admin once approved you will
                        notified.</p>
                </div>
                <div class="popup-btn text-center">
                    <a href="" class="btn btn-primary verify-document">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Success  -->
@endif
