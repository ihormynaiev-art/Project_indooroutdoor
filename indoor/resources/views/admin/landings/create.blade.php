@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> Create Landing </h5>
            </div>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <x-admin.landing-form
                    :providerDetail="$providerDetail"
                    :action="route('admin.landings.store')"
                />
            </div>
        </div>
    </div>
@endsection
