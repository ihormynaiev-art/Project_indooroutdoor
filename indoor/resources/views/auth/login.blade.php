@extends('layout.mainlayout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 mx-auto">
                    <div class="login-wrap">
                        <div class="login-header">
                            <h3>Login</h3>
                            <p>Please enter your details</p>
                        </div>

                        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="log-form">
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                        class="form-control"
                                        placeholder="johndeo@example.com"
                                    >
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-form-label">Password</label>
                                        </div>
                                        <div class="col-auto">
                                            <a class="forgot-link" href="{{ route('password.request') }}">
                                                Forgot password?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="pass-group">
                                        <input type="password"
                                               class="form-control pass-input"
                                               placeholder="*************"
                                               id="password"
                                               name="password"
                                               required autocomplete="current-password">
                                        <span class="toggle-password feather-eye-off"></span>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="custom_check">
                                            <input id="remember_me" type="checkbox" name="remember" class="rememberme">
                                            <span class="checkmark"></span>Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="site-button site-button-primary w-100 login-btn" type="submit">Login</button>
                            <p class="no-acc">Dont have an account ? <a href="{{ url('signup') }}"> Register</a></p>
                        </form>
                        <!-- /Login Form -->

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
