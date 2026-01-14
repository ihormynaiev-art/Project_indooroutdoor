<?php $page = 'error-500'; ?>
@extends('layout.mainlayout')
@section('content')
    <!-- Error 500 -->
    <div class="main-wrapper error-page">
        @component('components.backgroundimage')
        @endcomponent
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="error-wrap text-center">
                            <div class="error-logo">
                                <a href="{{ url('/') }}"><img class="img-fluid"
                                        src="{{ URL::asset('/assets/img/logo.svg') }}" alt="img"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="error-wrap">
                            <div class="error-img">
                                <img class="img-fluid" src="{{ URL::asset('/assets/img/error-500.png') }}" alt="img">
                            </div>
                            <h2>500 Oops! Page Not Found</h2>
                            <p>Sorry, the page you’re looking for doesn’t exist. If you think something is broken, report a
                                problem.</p>
                            <a href="{{ url('/') }}" class="btn btn-primary"><i
                                    class="feather-arrow-left-circle me-2"></i>Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Error 500 -->
@endsection
