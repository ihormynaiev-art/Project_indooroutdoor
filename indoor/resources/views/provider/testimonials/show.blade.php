@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-lg-6 col-sm-12 m-auto">
                    <div class="mb-3">
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
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
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
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
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
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
                    <div class="mb-3">
                        <label class="form-label"> Review </label>
                        <textarea
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                        >{{ $testimonial->review }}
                        </textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
                    <label class="form-label"> Rating </label>
                    <div class="d-flex">
                        <div class="rating">
                            @for($i = 0 ; $i < $testimonial->rating; $i++)
                                <i class="fas fa-star filled"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
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
                </div>

                @foreach($testimonial->images as $image)
                    <div class="col-md-3 col-sm-12 m-auto">
                        <div class="testimonial-image w-100 p-2 d-flex justify-content-center">
                            <a target="_blank" href="{{ url('storage/' . $image->path) }}">
                                <img src="{{ url('storage/' . $image->path) }}">
                            </a>
                        </div>
                    </div>
                @endforeach
                @foreach($testimonial->videos as $video)
                    <div class="col-md-3 col-sm-12 align-self-center">
                        <div class="testimonial-image p-2 d-flex">
                            <video class="w-100" src="{{ url('storage/' . $video->path) }}" controls></video>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
