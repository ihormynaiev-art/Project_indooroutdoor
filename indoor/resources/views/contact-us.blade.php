@extends('layout.mainlayout')
@section('title', 'Contact Us | IndoorOutdoor Home Improvement Services')
@section('description', "Get in touch with IndoorOutdoor for inquiries about our services, project consultations, or to request a quote. We're here to assist you with all your home improvement needs.")
@section('content')
    @if(session('status'))
        <div class="toast top-25 end-0 position-fixed align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('status') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @component('components.backgroundimage')
    @endcomponent
    @component('components.breadcrumb')
        @slot('title')
            Contact Us
        @endslot
        @slot('li_1')
            Home
        @endslot
        @slot('li_2')
            Contact Us
        @endslot
    @endcomponent


    <div class="content">
        <div class="container">
            <div class="contact-details">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="contact-info flex-fill">
                            <span><i class="feather-phone"></i></span>
                            <div class="contact-data">
                                <h4>Phone Number</h4>
                                <p><a href="tel:7344536900"> 734.453.6900</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="contact-info flex-fill">
                            <span><i class="feather-mail"></i></span>
                            <div class="contact-data">
                                <h4>Email Address</h4>
                                <p><a id="copyEmailButton" href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a></p>
                                <div class="copy-notification" id="copyNotification">Copied!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-queries">
                        <h2>Get In Touch</h2>
                        <form action="{{ route('contactMessages.store') }}" method="post">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Name</label>
                                        <input class="form-control" required name="name" type="text" placeholder="Enter Name*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email</label>
                                        <input required class="form-control" name="email" type="email" placeholder="Enter Email Address*">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Phone Number</label>
                                        <input class="form-control" name="phone" type="text" placeholder="Enter Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Message</label>
                                        <textarea required name="message" class="form-control" rows="4" placeholder="Type Message"></textarea>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-start">
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('g-recaptcha-response')" />
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">Send Message<i
                                            class="feather-arrow-right-circle ms-2"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
