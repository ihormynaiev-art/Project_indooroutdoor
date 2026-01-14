@extends('layout.mainlayout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 mx-auto">
                    <div class="login-wrap">
                        <div class="login-header">
                            <h3>Reset Password</h3>
                            <p>Your new password must be different from previous used passwords.</p>
                        </div>

                        <!-- Reset Password Form -->
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="log-form">
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input id="email"
                                           type="email"
                                           name="email"
                                           value="{{ old('email', $request->email) }}"
                                           required
                                           autofocus
                                           class="form-control"
                                           placeholder="johndeo@example.com"
                                    >
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            <div class="log-form">
                                <div class="form-group">
                                    <label class="col-form-label">New Password</label>
                                    <div class="pass-group" id="passwordInput">
                                        <input
                                            type="password"
                                            class="form-control pass-input-new"
                                            placeholder="*************"
                                            id="password"
                                            name="password"
                                            required
                                            autocomplete="new-password"
                                        >
                                        <span class="toggle-password-new feather-eye-off"></span>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password</label>
                                    <div class="pass-group">
                                        <input
                                            type="password"
                                            class="form-control pass-input"
                                            placeholder="*************"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            required
                                            autocomplete="new-password"
                                        >
                                        <span class="toggle-password feather-eye-off"></span>
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                            <button class="site-button site-button-primary w-100 login-btn" type="submit">Save Change</button>
                        </form>
                        <!-- /Reset Password Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
