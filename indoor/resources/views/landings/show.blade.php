@extends('layout.mainlayout')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" style="
        background-image: url('{{ $landing->heroImage ? asset('storage/' . $landing->heroImage->path) : asset('assets/img/fish-2.jpg') }}');
        background-size: cover;
        background-position: center;
        min-height: 500px;
        position: relative;
        display: flex;
        align-items: flex-end;
    ">
        <div class="container">
            <div class="row align-items-end py-4">
                <div class="col-md-6">
                    <div class="hero-title" style="background: rgba(0,0,0,0.6); padding: 1rem; border-radius: 8px; display: inline-block;">
                        <h2 class="text-white mb-0">
                            <a href="{{ route('provider.details.show', $providerDetail->slug) }}" class="text-white text-decoration-none">
                                {{ $providerDetail->business_name }}
                            </a>
                        </h2>
                    </div>
                </div>
                <div class="col-md-6 text-end mt-3 mt-md-0">
                    @if($providerDetail->plan?->hasContactButton('message_provider'))
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#message-to-provider"
                            class="site-button site-button-secondary site-button-mw-big"
                        >
                            <img class="mx-2" style="margin-bottom: 3px;"
                                 src="{{ asset('assets/img/icons/message.png') }}"
                                 height="15" alt="Message Provider">Message Provider
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Offer Section -->
    <section class="offer-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h1 class="display-4 fw-bold">{{ $landing->title }}</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 text-center">
                    <img src="{{ $landing->offerImage ? asset('storage/' . $landing->offerImage->path) : asset('assets/img/fish-1.png') }}"
                         alt="{{ $landing->title }}"
                         class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    @if($portfolioImages && count($portfolioImages) > 0)
        <section class="portfolio-section py-5">
            <div class="container">
                <div class="provider-details m-0 row position-relative">
                    <div class="text-sm-start text-center px-0">
                        <h5 class="h5-service-details-blue py-2 px-3">Portfolio</h5>
                    </div>
                    <div class="col-md-6 text-md-end aos" data-aos="fade-up">
                        <div class="owl-nav mynav1"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="owl-carousel provider-gallery-slider">
                            @foreach($portfolioImages as $image)
                                <div class="service-widget aos" data-aos="fade-up">
                                    <div>
                                        <a target="_blank" href="{{ url('storage/' . $image->path) }}">
                                            <img class="img-fluid serv-img" alt="Portfolio Image"
                                                 src="{{ url('storage/' . $image->path) }}">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Reviews Section -->
    @if($reviews->isNotEmpty())
        <section class="reviews-section py-5">
            <div class="container">
                <x-provider-detail.tabs.reviews
                    :providerDetail="$providerDetail"
                    :reviews="$reviews"
                    :averageRating="$averageRating"
                    :standalone="true"
                    :alignLeft="true"
                    :paginated="true"
                    :perPage="3"
                />
            </div>
        </section>
    @endif

    @if($description)
        <section class="why-choose-us-section py-5">
            <div class="container">
                <div class="text-sm-start text-center px-0">
                    <h5 class="h5-service-details-blue py-2 px-3">Why choose us?</h5>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="description-text p-2 text-site-blue">
                            {!! nl2br(e($description)) !!}
                        </div>
                    </div>
                </div>
                @if($providerDetail->plan?->hasContactButton('message_provider'))
                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <button
                                data-bs-toggle="modal"
                                data-bs-target="#message-to-provider"
                                class="site-button site-button-secondary site-button-mw-big"
                            >
                                <img class="mx-2" style="margin-bottom: 3px;"
                                     src="{{ asset('assets/img/icons/message.png') }}"
                                     height="15" alt="Message Provider">Message Provider
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Include Message Provider Modal -->
    @include('partials.message-provider', ['providerDetail' => $providerDetail])
@endsection
