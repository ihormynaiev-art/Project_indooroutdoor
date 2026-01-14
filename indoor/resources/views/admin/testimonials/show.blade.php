@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> Testimonial </h5>
            </div>

            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-lg-4 col-sm-12 m-auto">
                    <div class="mb-3">
                        <label class="form-label"> Provider </label>
                        <input
                            required
                            disabled
                            type="text"
                            class="form-control"
                            value="{{ $testimonial->providerDetail->business_name }}"
                        >
                    </div><div class="mb-3">
                        <label class="form-label"> Nickname </label>
                        <input
                            required
                            name="name"
                            disabled
                            type="text"
                            class="form-control"
                            value="{{ $testimonial->nickname }}"
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
                            value="{{ $testimonial->email }}"
                        >
                    </div>
                    <label class="form-label"> Rating </label>
                    <div class="d-flex">
                        <div class="rating">
                            @for($i = 0 ; $i < $testimonial->rating; $i++)
                                <i class="fas fa-star filled"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        @if(!is_null($testimonial->would_recommend))
                            <label class="form-label"> Would recommend </label>
                            <input
                                name="slug"
                                type="text"
                                required
                                disabled
                                class="form-control"
                                value="{{ $testimonial->would_recommend ? 'yes' : 'no' }}"
                            />
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Title </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $testimonial->title }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Review </label>
                        <textarea
                            name="slug"
                            type="text"
                            rows="5"
                            required
                            disabled
                            class="form-control"
                        >{{ $testimonial->review }}
                        </textarea>
                    </div>
                    @foreach($testimonial->images as $image)
                        <div class="testimonial-image w-100 p-2 d-flex justify-content-center">
                            <img src="{{ url('storage/' . $image->path) }}" >
                        </div>
                    @endforeach
                    @foreach($testimonial->videos as $video)
                        <div class="testimonial-image p-2 d-flex justify-content-center">
                            <video class="w-100" src="{{ url('storage/' . $video->path) }}" controls></video>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="acc-submit pt-3">
                <a href="{{ route('admin.testimonials.index') }}"
                   class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
@endsection
