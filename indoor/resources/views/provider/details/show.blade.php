@extends('layout.mainlayout')
@section('content')
    @component('components.navigation-breadcrumb')
        @slot('categorySlug')
            @if($providerDetail->categories->isNotEmpty())
                {{ $providerDetail->categories->first()->slug }}
            @endif
        @endslot
        @slot('categoryName')
            @if($providerDetail->categories->isNotEmpty())
                {{ $providerDetail->categories->first()->name }}
            @endif
        @endslot
        @slot('businessName')
            {{ $providerDetail?->business_name }}
        @endslot
    @endcomponent

    @component('components.breadcrumb')
        @slot('image')
            {{ $providerDetail->background_path }}
        @endslot

        @slot('title')
            {{ $providerDetail->business_name }}
        @endslot
    @endcomponent
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "{{ $providerDetail->business_name ?? ' ' }}",
            "address": "{{ $providerDetail->google_formatted_address ?? ' ' }}",
            "telephone": "{{ $providerDetail->phone ?? ' ' }}",
            "url": "{{ $providerDetail->website_url ?? ' ' }}"
        }
    </script>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <x-provider-detail.top :$providerDetail :$categoriesIds :$subcategoriesIds/>

            <x-provider-detail.tabs.buttons :$providerDetail :$reviews />

            <div class="tab-content" id="pills-tabContent">
                <x-provider-detail.tabs.info :$providerDetail/>

                <x-provider-detail.tabs.service-categories :$providerDetail/>

                @if($providerDetail->plan->canShowReviews() && $reviews->count())
                    <x-provider-detail.tabs.reviews :$providerDetail :$averageRating :$reviews/>
                @endif
            </div>
        </div>
    </div>
    @include('partials.view-ad')
    <!-- /Content -->
@endsection
