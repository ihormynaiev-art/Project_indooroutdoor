@extends('layout.mainlayout')
@section('title', 'Service Catalog | IndoorOutdoor Home Improvement Services')
@section('description', "Browse our comprehensive catalog of home improvement services, including additions, appliances, basements, bathrooms, and more. Find the perfect solution for your home needs.")
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            From to-do to done! <sup>&reg;</sup>
        @endslot
        @slot('subtitle')
            From routine maintenance and repairs to dream home renovations, we can help with any project — big or small.
        @endslot
        @slot('li_1')
            Home
        @endslot
        @slot('li_2')
            Services
        @endslot
    @endcomponent

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="catalog-filter-title mb-3">Home Solution Finder</h4>
                </div>
            </div>
            <div class="row">
                <x-filter :$categories
                          :$subCategories
                          :providersTotal="$providers?->total()"
                          :$searchResponse
                />
                <!-- Service -->
                <div class="col-lg-9 col-sm-12">
                    <div class="row sorting-div">
                        <div class="col-lg-12 d-flex justify-content-end ">
                            <div class="sortbyset">
                                <div class="sorting-select">
                                    <div>
                                        <select class="form-control select" onchange="location = this.value;">
                                          @foreach($sortArr as $key => $sort)
                                                <option
                                                    @selected($key == request('sort', 'asc'))
                                                    value="{{ $sort['href'] }}"
                                                >
                                                    {{ $sort['name'] }}
                                                </option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @if($providers && count($providers) > 0)
                            @foreach ($providers as $provider)
                                <div class="col-md-12">
                                    <!-- Provider List -->
                                    <x-provider-list :provider="$provider" />
                                    <!-- /Provider List -->
                                </div>
                            @endforeach
                        @elseif($emptySearch)
                            <div class="mt-5 col-md-9 text-center text-black">
                                <h4>
                                    Find the Right Contractor in Just a Few Clicks!
                                </h4>
                                <h5>
                                   Let's Get Started!
                                </h5>
                                <ol class="w-75  mx-auto text-start">
                                    <li>Select a <span class="fw-bold">Home Solution</span></li>
                                    <li>Choose a <span class="fw-bold">Specific Service</span></li>
                                    <li>Click <span class="fw-bold">Show Results</span> to explore providers</li>
                                </ol>

                                Need help? Use our Concierge Service to get personally matched.
                                <div class="pt-4">
                                    <a data-bs-toggle="modal" data-bs-title="Concierge Help" data-bs-target="#request-quote"
                                       href="javascript:void(0);" class="site-button site-button-primary px-5">
                                        Get Concierge Help
                                    </a>
                                </div>
                            </div>

                        @elseif($providers && count($providers) === 0)
                            <div class="mt-5 col-md-9 text-center">
                                <h4>
                                    We’re sorry, no contractors match your selection right now.
                                </h4>
                                <h5>
                                    It looks like there are no contractors currently available for the services you selected.
                                    But don’t worry, our Concierge Service is here to help you! Let us do the work of connecting you with the right professionals.
                                </h5>
                                <div class="pt-4">
                                    <a data-bs-toggle="modal" data-bs-title="Concierge Help"
                                       data-bs-target="#request-quote"
                                       href="javascript:void(0);"
                                       class="site-button site-button-primary px-5">
                                        Get Concierge Help
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 pt-2 text-center">
                                <h5>
                                    Submit your details, and our team will personally match you with a qualified contractor.
                                </h5>
                                <div class="pt-4">
                                    <a href="{{route('catalog.index')}}" class="site-button site-button-primary px-5">
                                        Start a New Search
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="d-flex justify-content-center">
                                {{ $providers?->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- /Pagination -->
                </div>
                <!-- /Service -->
            </div>
        </div>
    </div>
@endsection
