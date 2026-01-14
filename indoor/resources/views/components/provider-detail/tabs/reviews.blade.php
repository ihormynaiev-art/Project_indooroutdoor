@props(['providerDetail', 'reviews', 'averageRating', 'standalone' => false, 'alignLeft' => false, 'paginated' => false, 'perPage' => 3])

<div class="{{ $standalone ? 'd-block' : 'd-sm-none' }} w-100 h5-service-details-blue my-4 provider-details {{ $alignLeft ? 'text-sm-start text-center' : 'text-center' }}">
    <h5 class="h5-service-details-blue py-2">Reviews</h5>
</div>


<div class="{{ $standalone ? '' : 'tab-pane fade' }}" id="pills-contact"
     role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
    <div class="px-2 mb-3 d-flex flex-wrap py-1" id="reviews-tabs" role="tablist">
        <!-- Tabs for md+ -->
        <div class="d-none d-sm-flex justify-content-between w-100">
            <div class="nav-item" role="presentation">
                <button class="nav-link review-tab active"
                        id="all-reviews-tab"
                        data-bs-toggle="pill" data-bs-target="#all-reviews"
                        type="button" role="tab" aria-controls="all-reviews"
                        aria-selected="true">
                    <img src="{{ asset('assets/img/reviews/all-logo.png') }}" style="width: 30px"
                         alt="all">
                    <span>All</span>
                </button>
            </div>

            @if($providerDetail->plan?->canShowGoogleReviews())
                @if($providerDetail->googleReviews->isNotEmpty())
                    <div class="nav-item" role="presentation">
                        <button class="nav-link review-tab"
                                id="google-tab"
                                data-bs-toggle="pill" data-bs-target="#google"
                                type="button" role="tab" aria-controls="google"
                                aria-selected="false">
                            <img src="{{ asset('assets/img/reviews/google.png') }}" style="width: 30px"
                                 alt="google">
                            <span>Google</span>
                        </button>
                    </div>
                @endif
            @endif

            @if($providerDetail->plan?->canShowFacebookReviews())
                @if($providerDetail->facebookReviews->isNotEmpty())
                    <div class="nav-item" role="presentation">
                        <button class="nav-link review-tab"
                                id="facebook-tab"
                                data-bs-toggle="pill" data-bs-target="#facebook"
                                type="button" role="tab" aria-controls="facebook"
                                aria-selected="false">
                            <img src="{{ asset('assets/img/reviews/facebook-logo.png') }}"
                                 style="width: 30px" alt="facebook">
                            <span>Facebook</span>
                        </button>
                    </div>
                @endif
            @endif

            @if($providerDetail->plan?->canShowIndoorOutdoorReviews())
                @if($providerDetail->testimonials->isNotEmpty())
                    <div class="nav-item" role="presentation">
                        <button class="nav-link review-tab"
                                id="indoor-outdoor-tab"
                                data-bs-toggle="pill" data-bs-target="#indoor-outdoor"
                                type="button" role="tab" aria-controls="indoor-outdoor"
                                aria-selected="false">
                            <img src="{{ asset('assets/img/reviews/indoor-outdoor.png') }}"
                                 style="width: 30px" alt="indoor-outdoor">
                            <span>Indoor Outdoor</span>
                        </button>
                    </div>
                @endif
            @endif
        </div>

        <!-- Dropdown for sm and below -->
        <div class="dropdown d-sm-none w-100">
            <button class="btn bg-transparent border-0 dropdown-toggle w-100"
                    type="button" id="reviewsDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                All
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="reviewsDropdown">
                <li>
                    <a class="dropdown-item active"
                       data-bs-target="#all-reviews"
                       href="#">
                        <img src="{{ asset('assets/img/reviews/all-logo.png') }}"
                             width="20" alt="all-reviews">
                        <span class="mx-2">All</span>
                    </a>
                </li>
                @if($providerDetail->plan?->canShowGoogleReviews())
                    @if($providerDetail->googleReviews->isNotEmpty())
                        <li><a class="dropdown-item"
                               data-bs-target="#google"
                               href="#">
                                <img src="{{ asset('assets/img/reviews/google.png') }}"
                                     width="20" alt="google">
                                <span class="mx-2">Google</span>
                            </a></li>
                    @endif
                @endif

                @if($providerDetail->plan?->canShowFacebookReviews())
                    @if($providerDetail->facebookReviews->isNotEmpty())
                        <li>
                            <a class="dropdown-item"
                               data-bs-target="#facebook"
                               href="#">
                                <img src="{{ asset('assets/img/reviews/facebook-logo.png') }}"
                                     width="20" alt="facebook">
                                <span class="mx-2">Facebook</span></a>
                        </li>
                    @endif
                @endif

                @if($providerDetail->plan?->canShowIndoorOutdoorReviews())
                    @if($providerDetail->testimonials->isNotEmpty())
                        <li>
                            <a class="dropdown-item"
                               data-bs-target="#indoor-outdoor"
                               href="#">
                                <img src="{{ asset('assets/img/reviews/indoor-outdoor.png') }}"
                                     width="20" alt="indoor-outdoor">
                                <span class="mx-2">Indoor Outdoor</span>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>

    <div class="tab-content" id="google-tabContent">
        <div class="tab-pane show active fade" id="all-reviews"
             role="tabpanel" aria-labelledby="all-reviews" tabindex="0">
            <div class="rating mb-4 mx-2 d-inline-flex flex-column align-items-center">
                <div>
                    @for($i = 0; $i < round($averageRating); $i++)
                        <i class="fas fa-star filled"></i>
                    @endfor
                    @for($i = 0; $i < 5 - round($averageRating); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <div class="text-center mt-1">
                    {{ $averageRating }}/5
                </div>
            </div>
            <ul id="all-reviews-list">
                @foreach($reviews as $review)
                    @if($review instanceof \App\Models\GoogleReview)
                        <x-review.card.google :$review/>
                    @endif
                    @if($review instanceof \App\Models\Testimonial)
                        <x-review.card.io :$review/>
                    @endif
                    @if($review instanceof \App\Models\FacebookReview)
                        <x-review.card.facebook :$review/>
                    @endif
                @endforeach
            </ul>
            @if($paginated && $reviews->count() > $perPage)
                <div class="d-flex justify-content-center mt-4">
                    <button class="show-more-btn site-button site-button-secondary" data-target="all-reviews-list">Show More</button>
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="google"
             role="tabpanel" aria-labelledby="google-tab" tabindex="0">
            <div class="rating mb-4 mx-2 d-inline-flex flex-column align-items-center">
                <div>
                    @for($i = 0; $i < round($providerDetail->google_rating); $i++)
                        <i class="fas fa-star filled"></i>
                    @endfor
                    @for($i = 0; $i < 5 - round($providerDetail->google_rating); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <div class="text-center mt-1">
                    {{ $providerDetail->google_rating }}/5
                </div>
            </div>
            <ul id="google-reviews-list">
                @foreach($providerDetail->googleReviews as $review)
                    <x-review.card.google :$review/>
                @endforeach
            </ul>
            @if($paginated && $providerDetail->googleReviews->count() > $perPage)
                <div class="d-flex justify-content-center mt-4">
                    <button class="show-more-btn site-button site-button-secondary" data-target="google-reviews-list">Show More</button>
                </div>
            @endif
            @if($providerDetail->google_link)
                <div class="d-flex justify-content-center {{ $paginated && $providerDetail->googleReviews->count() > $perPage ? 'mt-2' : '' }}">
                    <a href="{{ $providerDetail->google_link }}"
                       target="_blank"
                       class="site-button site-button-primary">View All</a>
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="facebook"
             role="tabpanel" aria-labelledby="indoor-outdoor-tab" tabindex="0">
            <div class="rating mb-4 mx-2 d-inline-flex flex-column align-items-center">
                <div>
                    @for($i = 0; $i < round($providerDetail->testimonials->avg('rating')); $i++)
                        <i class="fas fa-star filled"></i>
                    @endfor
                    @for($i = 0; $i < 5 - round($providerDetail->testimonials->avg('rating')); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <div class="text-center mt-1">
                    {{ $providerDetail->testimonials->avg('rating', 1) }}/5
                </div>
            </div>
            <ul id="facebook-reviews-list">
                @foreach($providerDetail->facebookReviews as $review)
                    <x-review.card.facebook :$review/>
                @endforeach
            </ul>
            @if($paginated && $providerDetail->facebookReviews->count() > $perPage)
                <div class="d-flex justify-content-center mt-4">
                    <button class="show-more-btn site-button site-button-secondary" data-target="facebook-reviews-list">Show More</button>
                </div>
            @endif
        </div>
        <div class="tab-pane fade"
             id="indoor-outdoor"
             role="tabpanel" aria-labelledby="indoor-outdoor-tab" tabindex="0">
            <div class="rating mb-4 mx-2 d-inline-flex flex-column align-items-center">
                <div>
                    @for($i = 0; $i < round($providerDetail->testimonials->avg('rating')); $i++)
                        <i class="fas fa-star filled"></i>
                    @endfor
                    @for($i = 0; $i < 5 - round($providerDetail->testimonials->avg('rating')); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <div class="text-center mt-1">
                    {{ $providerDetail->testimonials->avg('rating', 1) }}/5
                </div>
            </div>
            <ul id="indoor-outdoor-reviews-list">
                @foreach($providerDetail->testimonials as $review)
                    <x-review.card.io :$review/>
                @endforeach
            </ul>
            @if($paginated && $providerDetail->testimonials->count() > $perPage)
                <div class="d-flex justify-content-center mt-4">
                    <button class="show-more-btn site-button site-button-secondary" data-target="indoor-outdoor-reviews-list">Show More</button>
                </div>
            @endif
        </div>
    </div>
</div>

@if($paginated)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const perPage = {{ $perPage }};
            const showMoreButtons = document.querySelectorAll('.show-more-btn');

            showMoreButtons.forEach(function(showMoreBtn) {
                const targetId = showMoreBtn.getAttribute('data-target');
                const reviewsList = document.getElementById(targetId);

                if (reviewsList) {
                    const reviewItems = reviewsList.querySelectorAll('li.review-box');
                    let currentlyShown = perPage;

                    // Hide reviews after initial perPage
                    reviewItems.forEach((item, index) => {
                        if (index >= perPage) {
                            item.style.display = 'none';
                        }
                    });

                    // Show More button handler
                    showMoreBtn.addEventListener('click', function() {
                        const itemsToShow = currentlyShown + perPage;

                        reviewItems.forEach((item, index) => {
                            if (index < itemsToShow) {
                                item.style.display = 'block';
                            }
                        });

                        currentlyShown = itemsToShow;

                        // Hide button if all reviews are shown
                        if (currentlyShown >= reviewItems.length) {
                            showMoreBtn.style.display = 'none';
                        }
                    });
                }
            });
        });
    </script>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('[role="tablist"]').forEach(tabBlock => {
            const dropdown = tabBlock.querySelector('.dropdown-toggle');
            const dropdownItems = tabBlock.querySelectorAll('.dropdown-item');
            const tabButtons = tabBlock.querySelectorAll('[data-bs-toggle="pill"]');

            if (!dropdown) return;

            function activateTabButton(tabButtonEl) {
                if (!tabButtonEl) return;
                try {
                    if (window.bootstrap && typeof window.bootstrap.Tab === 'function') {
                        new window.bootstrap.Tab(tabButtonEl).show();
                    } else {
                        tabButtonEl.click();
                    }
                } catch {
                    tabButtonEl.click();
                }
            }

            dropdownItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-bs-target');
                    const tabTrigger = tabBlock.querySelector(`[data-bs-toggle="pill"][data-bs-target="${target}"]`);

                    activateTabButton(tabTrigger);

                    dropdown.textContent = this.textContent;
                    dropdownItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            tabButtons.forEach(tabButton => {
                tabButton.addEventListener('shown.bs.tab', function (event) {
                    const block = event.target.closest('[role="tablist"]');
                    const localDropdown = block.querySelector('.dropdown-toggle');
                    const localItems = block.querySelectorAll('.dropdown-item');
                    const activeTarget = event.target.getAttribute('data-bs-target');
                    const activeItem = block.querySelector(`.dropdown-item[data-bs-target="${activeTarget}"]`);

                    if (activeItem && localDropdown) {
                        localDropdown.textContent = activeItem.textContent;
                        localItems.forEach(i => i.classList.remove('active'));
                        activeItem.classList.add('active');
                    }
                });
            });
        });
    });
</script>
