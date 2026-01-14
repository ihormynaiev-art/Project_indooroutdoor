@extends('layout.mainlayout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 mx-auto">
                    <div class="login-wrap">
                        <div class="login-header">
                            @if(!empty($is_provider))
                                <h3>Contractor Registration</h3>
                            @else
                                <h3>Homeowner Signup</h3>
                            @endif
                        </div>

                        <!-- Login Form -->
                        <form method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                            @csrf
                            @if(isset($is_provider) && $is_provider)
                                <div class="form-group">
                                    <label class="col-form-label d-block">Business Name</label>
                                    <x-text-input
                                        id="business_name"
                                        class="form-control"
                                        placeholder="Enter your business name"
                                        type="text"
                                        name="business_name"
                                        :value="old('business_name')"
                                        required
                                        autofocus
                                        autocomplete="business_name"
                                        maxlength="200"
                                    />
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-form-label d-block">Full Name</label>
                                <x-text-input id="name"
                                              class="form-control"
                                              placeholder="Enter your name"
                                              type="text" name="name"
                                              :value="old('name')"
                                              required
                                              autocomplete="name"
                                              maxlength="200"
                                />
                            </div>
                            <div class="form-group">
                                <label class="col-form-label d-block">Email</label>
                                <x-text-input id="email" class="form-control" placeholder="example@email.com" type="email" name="email" :value="old('email')" required autocomplete="username" maxlength="200" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            @if(isset($is_provider) && $is_provider)
                                <input type="hidden" name="is_provider" id="is-provider" value="1">
                            @endif
                            <input type="hidden" name="code" id="invite-code" value="{{ request()->query('code') }}">
                            <div class="form-group">
                                <label class="col-form-label d-block">Password<span class="brief-bio float-end">Must be 8
                                        Characters at Least</span></label>
                                <div class="pass-group">
                                    <input type="password"
                                           class="form-control pass-input"
                                           placeholder="*************"
                                           name="password"
                                           id="password"
                                           required
                                    >
                                    <span class="toggle-password feather-eye-off"></span>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label class="col-form-label d-block">Password Confirmation<span class="brief-bio float-end">Must be 8
                                        Characters at Least</span></label>
                                <div class="pass-group">
                                    <input type="password"
                                           class="form-control confirm-pass-input"
                                           placeholder="*************"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           required
                                    >
                                    <span class="toggle-confirm-password feather-eye-off"></span>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <button class="site-button site-button-primary w-100 login-btn" type="submit">Signup</button>
                            <p class="no-acc">Already have an account ? <a href="{{ url('login') }}"> Sign In</a></p>
                        </form>
                        <!-- /Login Form -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
