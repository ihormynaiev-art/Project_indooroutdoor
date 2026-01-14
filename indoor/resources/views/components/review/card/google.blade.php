<li class="review-box">
    <div class="review-profile row align-items-center">
        <div class="review-img col-12 col-md-4 d-flex align-items-center justify-content-between">
            <div class="d-flex">
                <div class="review-logo me-2">
                    <img height="28px"
                         src="{{ asset('assets/img/reviews/google-logo-blue.png') }}"
                         alt="Google">
                </div>
                <div class="review-name">
                    <h6>{{ $review->author_name }}</h6>

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
                <p>{{ $review->date->format('m/d/Y') }}</p>
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
            <p>{{ $review->date->format('m/d/Y') }}</p>
        </div>
    </div>
    <p>{{ $review->text }}</p>
</li>
