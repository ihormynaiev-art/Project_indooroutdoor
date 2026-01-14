<div class="d-sm-none w-100 h5-service-details-blue my-4 provider-details text-center">
    <h5 class="h5-service-details-blue py-2">Service Categories</h5>
</div>

<div class="tab-pane fade"
     id="service-categories"
     role="tabpanel"
     aria-labelledby="service-categories-tab"
     tabindex="0">
    @if(count($providerDetail->categories) > 0)
        <!-- DESKTOP -->
        <div class="provider-details d-none d-md-block">
            <div class="row mb-4">
                @foreach ($providerDetail->categories as $category)
                    <div class="accordion col-md-6 mb-3">
                        <div class="accordion-item provider-description">
                            <h2 class="accordion-header" id="heading-{{ $category->id }}">
                                <button class="accordion-button collapsed bg-white shadow-none"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#desktop-collapse-{{ $category->id }}"
                                        aria-expanded="false"
                                        aria-controls="desktop-collapse-{{ $category->id }}"
                                        aria-labelledby="heading-{{ $category->id }}">
                                    <b>{{ $category->name }}</b>
                                </button>
                            </h2>
                            <div id="desktop-collapse-{{ $category->id }}"
                                 aria-labelledby="heading-{{ $category->id }}"
                                 class="accordion-collapse collapse">
                                <div class="accordion-body pt-1">
                                    @foreach($category->subCategories as $subcategory)
                                        <div class="my-1">
                                            <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold py-2 subcategory"
                                                    style="text-align: left;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#request-quote"
                                                    data-provider-id="{{ $providerDetail->id }}"
                                                    data-provider-categories="{{ $category->id }}"
                                                    data-provider-subcategories="{{ $subcategory->id }}">
                                                {{ $subcategory->name }}
                                            </button>
                                        </div>
                                    @endforeach
                                    <div class="text-end my-1">
                                        <button class="site-button site-button-secondary m-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#request-quote"
                                                data-provider-id="{{ $providerDetail->id }}"
                                                data-provider-categories="{{ $category->id }}"
                                                data-provider-subcategories-list="{{ $category->subCategories->pluck('id') }}">
                                            Request Quote for {{ $category->name }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- MOBILE -->
        <div class="d-md-none">
            <div class="accordion" id="mobileAccordion">
                @foreach ($providerDetail->categories as $category)
                    <div class="accordion-item provider-description my-2 accordion-borders">
                        <h2 class="accordion-header" id="heading-{{ $category->id }}">
                            <button class="accordion-button collapsed bg-white shadow-none"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#mobile-collapse-{{ $category->id }}"
                                    aria-expanded="false"
                                    aria-labelledby="heading-{{ $category->id }}"
                                    aria-controls="mobile-collapse-{{ $category->id }}">
                                <img class="mx-2" width="28"
                                     style="filter: hue-rotate(120deg) saturate(100%) brightness(100%)"
                                     src="{{ asset('storage/' . $category->icon_path) }}"
                                     alt="{{ $category->name }}">
                                <b>{{ $category->name }}</b>
                            </button>
                        </h2>
                        <div id="mobile-collapse-{{ $category->id }}"
                             aria-labelledby="heading-{{ $category->id }}"
                             class="accordion-collapse collapse"
                             data-bs-parent="#mobileAccordion">
                            <div class="accordion-body pt-1">
                                @foreach($category->subCategories as $subcategory)
                                    <div class="my-1">
                                        <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold py-2 subcategory"
                                                style="text-align: left;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#request-quote"
                                                data-provider-id="{{ $providerDetail->id }}"
                                                data-provider-categories="{{ $category->id }}"
                                                data-provider-subcategories="{{ $subcategory->id }}">
                                            {{ $subcategory->name }}
                                        </button>
                                    </div>
                                @endforeach
                                <div class="text-end my-1">
                                    <button class="btn m-0 p-2 btn-sm btn-small btn-green"
                                            data-bs-toggle="modal"
                                            data-bs-target="#request-quote"
                                            data-provider-id="{{ $providerDetail->id }}"
                                            data-provider-categories="{{ $category->id }}"
                                            data-provider-subcategories-list="{{ $category->subCategories->pluck('id') }}">
                                        Request Quote for {{ $category->name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(count($providerDetail->portfolioImages) > 0)
        <div class="provider-details m-0 row position-relative mt-4">
            <div class="text-sm-start text-center px-0">
                <h5 class="h5-service-details-blue py-2">Portfolio</h5>
            </div>
            <div class="col-md-6 text-md-end aos" data-aos="fade-up">
                <div class="owl-nav mynav1"></div>
            </div>
            <div class="col-md-12">
                <div class="owl-carousel provider-gallery-slider">
                    @php
                        $maxVisiblePhotos = $providerDetail->plan?->getFeature('max_portfolio_photos', 999);
                        $visibleImages = $providerDetail->portfolioImages->take($maxVisiblePhotos);
                    @endphp
                    @foreach($visibleImages as $certificate)
                        <div class="service-widget aos" data-aos="fade-up">
                            <div>
                                <a target="_blank" href="{{ url('storage/' . $certificate->path) }}">
                                    <img class="img-fluid serv-img" alt="Service Image"
                                         src="{{ url('storage/' . $certificate->path) }}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
