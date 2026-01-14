@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> Logo </h5>
            </div>
            <div class="testimonial-image w-100 p-2 d-flex justify-content-center">
                <img src="{{ url('storage/' . $logo->file->path) }}" >
            </div>
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-lg-4 col-sm-12 m-auto">
                    <div class="mb-3">
                        <label class="form-label"> Slug </label>
                        <input
                            required
                            disabled
                            type="text"
                            class="form-control"
                            value="{{ $logo->slug }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Prio </label>
                        <input
                            required
                            name="name"
                            disabled
                            type="text"
                            class="form-control"
                            value="{{ $logo->prio }}"
                        >
                    </div>
                    <div class="form-groupheads d-flex mb-4">
                        <h2>Active</h2>
                        <div class="mx-2 active-switch">
                            <label class="switch">
                                <input disabled name="is_active" @checked($logo->is_active) value="1" type="checkbox">
                                <span class="sliders round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="btn-path">
                        <a href="{{ url()->previous() }}" class="btn btn-primary me-3">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
