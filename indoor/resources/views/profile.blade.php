@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
                <div class="col-lg-9">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <div class="widget-title">
                            <h4>Account Settings</h4>
                        </div>
                        <h6 class="user-title">General Information</h6>
                        <div class="general-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input
                                            id="name"
                                            name="name"
                                            value="{{ old('name', $user->name) }}"
                                            required
                                            autofocus
                                            autocomplete="name"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter Your Name"
                                        >
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input
                                            name="email"
                                            id="email"
                                            type="email"
                                            class="form-control"
                                            required
                                            autocomplete="username"
                                            value="{{ old('email', $user->email) }}"
                                            placeholder="Enter Email Address"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 class="user-title">Password </h6>
                        <div class="log-form">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">New Password</label>
                                    <div class="pass-group" id="passwordInput">
                                        <input
                                            type="password"
                                            class="form-control pass-input-new"
                                            placeholder="*************"
                                            id="password"
                                            name="password"
                                            autocomplete="new-password"
                                        >
                                        <span class="toggle-password-new feather-eye-off"></span>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Confirm Password</label>
                                    <div class="pass-group">
                                        <input
                                            type="password"
                                            class="form-control pass-input"
                                            placeholder="*************"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            autocomplete="new-password"
                                        >
                                        <span class="toggle-password feather-eye-off"></span>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="acc-submit">
                            <x-primary-button>Save Changes</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @component('components.model-popup')
    @endcomponent
@endsection
@section('scripts')
    <script>
        $(function () {
            @if(session('status'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: @json(session('status')),
                animation: false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            @endif
        });
    </script>
@endsection
