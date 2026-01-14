@extends('layout.mainlayout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <!-- Choose Signup -->
                <div class="col-md-6 col-lg-6 mx-auto">
                    <div class="login-wrap">
                        <div class="login-header">
                            <h3>Sign Up</h3>
                        </div>
                        <div class="row">
                            <!-- Provider Signup -->
                            <div class="col-md-6 d-flex">
                                <a href="{{ route('register.provider') }}">
                                    <div class="choose-signup flex-fill">
                                        <h6>Contractor</h6>
                                        <div class="choose-img">
                                            <img src="{{ URL::asset('/assets/img/contractor.png') }}" alt="">
                                        </div>
                                        <a href="{{ route('register.provider') }}"
                                           class="site-button site-button-neutral w-100">Sign Up<i
                                                class="feather-arrow-right-circle ms-1"></i></a>
                                    </div>
                                </a>
                            </div>
                            <!-- /Provider Signup -->

                            <!-- User Signup -->
                            <div class="col-md-6 d-flex">
                                <a href="{{ route('register.customer') }}">
                                    <div class="choose-signup flex-fill mb-0">
                                        <h6>Homeowner</h6>
                                        <div class="choose-img">
                                            <img src="{{ URL::asset('/assets/img/homeowner.png') }}" alt="">
                                        </div>
                                        <a href="{{ route('register.customer') }}"
                                           class="site-button site-button-neutral w-100">Sign Up<i
                                                class="feather-arrow-right-circle ms-1"></i></a>
                                    </div>
                                </a>
                            </div>
                            <!-- /User Signup -->
                        </div>
                    </div>
                </div>
                <!-- /Choose Signup -->
            </div>
        </div>
    </div>
@endsection
