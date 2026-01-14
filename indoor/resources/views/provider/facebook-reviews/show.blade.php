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
                            value="{{ $facebookReview->reviewer_name }}"
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
                        >{{ $facebookReview->review_text }}
                        </textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
                    <label class="form-label"> Rating </label>
                    <div class="d-flex">
                        <div class="rating">
                            @for($i = 0 ; $i < round($facebookReview->rating); $i++)
                                <i class="fas fa-star filled"></i>
                            @endfor
                            {{ $facebookReview->rating }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 m-auto">
                    <div class="mb-3">
                        @if(!is_null($facebookReview->recommendation_type))
                            <label class="form-label"> Would recommend </label>
                            <input
                                name="slug"
                                type="text"
                                required
                                disabled
                                class="form-control"
                                value="{{ $facebookReview->recommendation_type === 'positive' ? 'yes' : 'no' }}"
                            />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
