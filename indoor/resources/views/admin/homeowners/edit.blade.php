@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <form action="{{ route('admin.homeowners.update', $user) }}" class="content" method="post">
            @method('PUT')
            <div class="content-page-header content-page-headersplit">
                <h5>Edit Homeowner</h5>
            </div>
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-lg-4 col-sm-12 m-auto">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="mb-3">
                        <label class="form-label">Name<sup>*</sup></label>
                        <input
                            required
                            name="name"
                            type="text"
                            class="form-control"
                            value="{{ $user->name }}"
                            maxlength="200"
                        >
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email<sup>*</sup></label>
                        <input
                            name="email"
                            type="email"
                            required
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            maxlength="200"
                        >
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <a class="btn btn-secondary" href="{{ route('admin.homeowners.index') }}">
                    Back
                </a>
                <button id="submit" type="submit" class="btn btn-primary">
                    Update Homeowner
                </button>
            </div>
        </form>
    </div>
@endsection
