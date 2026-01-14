<?php $page = 'error-404'; ?>
@extends('layout.mainlayout')
@section('content')
    <!-- Error 404 -->
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
                                <img class="img-fluid" src="{{ URL::asset('/assets/img/error-404.png') }}" alt="img">
                            </div>
                            <h2>404 Oops! Page Not Found</h2>
                            <p>This page doesn't exist or was removed! We suggest you back to home.</p>
                            <a href="{{ url('/') }}" class="btn btn-primary"><i
                                    class="feather-arrow-left-circle me-2"></i>Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Error 404 -->
@endsection
