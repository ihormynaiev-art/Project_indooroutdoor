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
                                <a href="{{ route('index') }}">
                                    <img class="img-fluid"
                                        src="{{ URL::asset('/assets/img/logo.png') }}" alt="img"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="error-wrap">
                            <h2>404 Oops! Page Not Found</h2>
                            <p>This page doesn't exist or was removed! We suggest you back to home.</p>
                            <a href="{{ route('index') }}" class="site-button site-button-primary"><i
                                    class="feather-arrow-left-circle me-2"></i>Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Error 404 -->
@endsection
