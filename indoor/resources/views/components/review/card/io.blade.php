<li class="review-box">
    <div class="review-profile row align-items-center">
        <div class="review-img col-12 col-md-4 d-flex align-items-center justify-content-between">
            <div class="d-flex">
                <div class="review-logo me-2">
                    <img height="28px"
                         src="{{ asset('assets/img/reviews/io-logo-blue.png') }}"
                         alt="Indoor Outdoor">
                </div>
                <div class="review-name">
                    <h6>{{ $review->nickname }}</h6>

                    {{-- Звёзды на маленьких экранах --}}
                    <div class="d-md-none mt-1">
                        <div class="rating d-flex justify-content-start">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fas fa-star filled"></i>
                            @endfor
                            @for($i = 0; $i < 5 - $review->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            <div class="mx-1">{{ $review->rating }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 d-md-none d-flex justify-content-end mt-1 mt-md-0">
                <p>{{ $review->created_at->format('m/d/Y') }}</p>
            </div>
        </div>

        {{-- Звёзды и рейтинг на больших экранах --}}
        <div class="col-md-4 d-none d-md-flex justify-content-center align-items-center">
            <div class="rating d-flex">
                @for($i = 0; $i < $review->rating; $i++)
                    <i class="fas fa-star filled"></i>
                @endfor
                @for($i = 0; $i < 5 - $review->rating; $i++)
                    <i class="fas fa-star"></i>
                @endfor
                <div class="mx-2">{{ $review->rating }}</div>
            </div>
        </div>

        <div class="col-md-4 d-md-flex d-none justify-content-end mt-1 mt-md-0">
            <p>{{ $review->created_at->format('m/d/Y') }}</p>
        </div>
    </div>
    <h6>{{ $review->title }}</h6>
    <p>{{ $review->review }}</p>
    @if(!is_null($review->would_recommend))
        <div class="recommend-info">
            <p>Recommend: </p>
            @if($review->would_recommend)
                <span><i class="feather-thumbs-up"></i> Yes</span>
            @else
                <span><i class="feather-thumbs-down"></i> No</span>
            @endif
        </div>
    @endif
    @if($review->images->count() || $review->videos->count())
        <div class="row">
            <h6 class="mt-2">Files</h6>
            @foreach($review->images as $image)
                <div class="col-md-3 col-sm-12">
                    <div
                        class="testimonial-image w-100 p-2 d-flex justify-content-center">
                        <a target="_blank"
                           href="{{ url('storage/' . $image->path) }}">
                            <img src="{{ url('storage/' . $image->path) }}">
                        </a>
                    </div>
                </div>
            @endforeach
            @foreach($review->videos as $video)
                <div class="col-md-3 col-sm-12 align-self-center">
                    <div class="testimonial-image p-2 d-flex">
                        <video class="w-100"
                               src="{{ url('storage/' . $video->path) }}"
                               controls></video>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</li>
