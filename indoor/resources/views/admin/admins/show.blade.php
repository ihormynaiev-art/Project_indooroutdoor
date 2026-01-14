@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> {{ $user->name }} </h5>
            </div>

            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-lg-4 col-sm-12 m-auto">
                    <div class="mb-3">
                        <label class="form-label"> Name </label>
                        <input
                            required
                            name="name"
                            disabled
                            type="text"
                            class="form-control"
                            value="{{ $user->name }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Email </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $user->email }}"
                        >
                    </div>
                </div>
            </div>
            <div>
                <a class="btn btn-secondary" href="{{ route('admin.admins.index') }}">
                    Back
                </a>
            </div>
        </div>
    </div>
@endsection
