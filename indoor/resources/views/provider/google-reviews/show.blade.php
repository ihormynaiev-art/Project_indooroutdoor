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
                            value="{{ $googleReview->author_name }}"
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
                        >{{ $googleReview->text }}
                        </textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
                    <label class="form-label"> Rating </label>
                    <div class="d-flex">
                        <div class="rating">
                            @for($i = 0 ; $i < round($googleReview->rating); $i++)
                                <i class="fas fa-star filled"></i>
                            @endfor
                            {{ $googleReview->rating }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
