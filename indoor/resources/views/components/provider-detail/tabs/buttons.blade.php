<div class="d-none d-sm-block mb-1 d-flex justify-content-between py-1"
     id="pills-tab"
     role="tablist">
    <div class="d-none d-sm-flex w-100 justify-content-between">
        <div class="nav-item" role="presentation">
            <button class="site-button site-button-primary nav-link active" id="provider-details-tab"
                    data-bs-toggle="pill" data-bs-target="#provider-details"
                    type="button" role="tab" aria-controls="provider-details"
                    aria-selected="true">
                Provider Details
            </button>
        </div>
        <div class="nav-item" role="presentation">
            <button class="site-button site-button-primary nav-link" id="service-categories-tab"
                    data-bs-toggle="pill" data-bs-target="#service-categories"
                    type="button" role="tab" aria-controls="service-categories"
                    aria-selected="false">
                Service Categories
            </button>
        </div>
        @if($providerDetail->plan->canShowReviews() && $reviews->count())
            <div class="nav-item" role="presentation">
                <button class="site-button site-button-primary nav-link" id="pills-contact-tab"
                        data-bs-toggle="pill" data-bs-target="#pills-contact"
                        type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false">
                    Reviews
                </button>
            </div>
        @endif
    </div>
</div>
