@extends('layout.mainlayout')
@section('content')
    <div class="content">
        <div class="container">
            <div class="row justify-content-end flex">
                <div class="deliver-img text-center">
                    <img src="{{ URL::asset('/assets/img/deliver.svg') }}">
                </div>
                <!-- Password Recovery -->
                <div class="mb-4 text-sm text-gray-600">
                    {{ __("Hi $user->name, Thanks for joining the IndoorOutdoor Resource! To get started, please verify your email address by clicking the link
                        we just sent to $user->email. Didn’t receive the email? If you don’t see the email, check your spam folder or click below to resend it.") }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="col-md-6">
                    <form class="d-flex float-end" method="POST" style="margin-left: 10px" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-primary-button>
                                {{ __('Resend Verification Email') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form class="d-flex float-end" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-primary-button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Log Out') }}
                        </x-primary-button>
                    </form>
                </div>
                <!-- /Password Recovery -->
            </div>
        </div>
    </div>
@endsection
