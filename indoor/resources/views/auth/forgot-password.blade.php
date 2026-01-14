@extends('layout.mainlayout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <!-- Password Recovery -->
                <div class="col-md-6 col-lg-6 mx-auto">
                    <div class="login-wrap">
                        <div class="login-header">
                            <h3>Password Recovery</h3>
                            <p>Enter your email and we will send you a link to reset your password.</p>
                        </div>

                        <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="log-form">
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input id="email"
                                           type="email"
                                           name="email"
                                           value="{{old('email')}}"
                                           required
                                           autofocus
                                           class="form-control"
                                           placeholder="johndeo@example.com"
                                    >
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                            <button class="site-button site-button-primary w-100 login-btn" type="submit">Submit</button>
                            <p class="no-acc mt-0">Remember Password ? <a href="{{ url('login') }}">Login</a></p>
                        </form>
                    </div>
                </div>
                <!-- /Password Recovery -->
            </div>
        </div>
    </div>
@endsection
