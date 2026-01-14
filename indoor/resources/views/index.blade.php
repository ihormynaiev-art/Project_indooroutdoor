@extends('layout.mainlayout')
@section('title', 'IndoorOutdoor')
@section('description', "Discover a wide range of home improvement services at IndoorOutdoor, including additions, remodels, landscaping, and more. Your one-stop solution for all indoor and outdoor projects.")
@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="home-banner">
            <div class="banner-overlay"></div>
            <div class="hero-content">
                <div class="mx-auto d-flex justify-content-center">
                    <div class="section-search my-4 text-center">
                        <div class="d-flex justify-content-center">
                            <h1>Helping make a House</h1>
                        </div>
                        <div class="d-flex justify-content-center">
                            <h1 class="text-green h1-bigger">Your Home<sup>®</sup></h1>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="subheading">
                                <div class="search-box">
                                    <form action="{{ route('catalog.index') }}" method="GET" data-autocomplete-url="{{ route('search-autocomplete') }}">
                                        @csrf
                                        <input type="hidden" name="search-autocomplete-url"
                                               value="{{ route('search-autocomplete') }}">
                                        <div id="search-autocomplete-list">
                                        </div>
                                        <div class="search-input">
                                            <div class="form-group mb-0">
                                                <input type="text" name="search" class="form-control"
                                                       id="search-autocomplete-input"
                                                       placeholder="Search by contractor, service, keyword, location, or ZIP…">
                                            </div>
                                        </div>
                                        <div class="search-btn">
                                            <button class="btn" type="submit">
                                                <div class="search-group-icon search-icon"><i
                                                        class="feather-search"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="subheading">
                                <div class="text-center">
                                    <h3 class="text-green">FROM TO-DO TO DONE <sup>®</sup></h3>
                                    <div class="d-flex justify-content-center">
                                    <p class="under-search-text text-center">Whether it’s routine maintenance or a dream renovation, we help you find trusted
                                        professionals for projects of any size.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->
    <div class="arc-top">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-4">
                <div class="work-box aos" data-aos="fade-up">
                    <div class="work-icon">
                        <div class="img-container">
                            <img style="padding-top: unset; max-width: 100%; width: 100%; position: relative; top: -18%;"
                                 src="{{ URL::asset('/assets/img/step1.png') }}" alt="img">
                        </div>
                    </div>
                    <h1>step 1</h1>
                    <h5>Select Your Project</h5>
                    <p>Choose the type of work you need, and we'll connect you with contractors who specialize in that
                        service.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="work-box on-top aos" data-aos="fade-up">
                    <div class="work-icon">
                        <div class="img-container">
                            <img style="max-width: 100%; width: 100%; padding-top: 15%; position: relative;"
                                 src="{{ URL::asset('/assets/img/step2.png') }}" alt="img">
                        </div>
                    </div>
                    <h1>step 2</h1>
                    <h5>Compare Contractors</h5>
                    <p>Browse detailed profiles, portfolios, reviews, and credentials to find contractors that meet your
                        needs.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="work-box aos" data-aos="fade-up">
                    <div class="work-icon w-4">
                        <div class="img-container">
                            <img style="max-width: 100%; width: 100%; padding-top: 2%" src="{{ URL::asset('/assets/img/step3.png') }}"
                                 alt="img">
                        </div>
                    </div>
                    <h1>step 3</h1>
                    <h5>Make It Happen</h5>
                    <p>Choose the right contractor for your needs and budget. After the job is complete, share your
                        feedback to support your community.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center button-container">
            <div class="col-md-6">
                <div class="text-center">
                    <button data-bs-toggle="modal" data-bs-title="QUOTATION FORM"
                            data-bs-target="#request-quote"
                            class="site-button site-button-secondary site-button-mw m-2"
                    >Request Quote
                    </button>
                </div>
                <div class="d-flex justify-content-center m-2">
                    <!-- <button class="btn btn-darkblue">Search by Contractor</button>-->
                    <a href="{{ route('catalog.index') }}"
                       class="site-button site-button-primary site-button-mw m-2 mb-4"
                    >Search by Service</a>
                </div>
            </div>
        </div>
    </div>
    <section class="service-section">
        <div class="container">
            <div class="section-heading">
                <div class="row justify-content-center">
                    <div class="col-md-6 aos" data-aos="fade-up">
                        <h2 class="pt-2 text-center">Browse Edition</h2>
                        <p class="text-center">For over two decades, Michigan homeowners have trusted IndoorOutdoor
                            as their go-to home improvement resource.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="owl-carousel edition-slider aos " data-aos="fade-up">
                        @foreach($settings->image_paths as $image_path)
                            <a href="{{ route('edition.show') }}">
                                <img src="{{ url('storage/' . $image_path) }}" alt="img">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center aos" data-aos="fade-up">
                    <a href="{{ route('edition.show') }}"
                       class="site-button site-button-secondary site-button-mw m-4">Browse E-dition</a>
                </div>
            </div>
        </div>
    </section>
    <section class="feature-section">
        <div class="container">
            <div class="section-heading">
                <div class="row align-items-center">
                    <div class="col-md-12 aos" data-aos="fade-up">
                        <h2>
                            Explore
                            <div id="text-swapper">
                                <ul>
                                    <li>painting</li>
                                    <li>basement</li>
                                    <li>kitchen</li>
                                    <li>bathroom</li>
                                    <li>flooring</li>
                                    <li>landscaping</li>
                                    <li>lighting</li>
                                    <li>window</li>
                                    <li>roofing</li>
                                    <li>gutter</li>
                                    <li>flooring</li>
                                    <li>paver</li>
                                    <li>masonry</li>
                                </ul>
                            </div>
                            <br>Projects
                        </h2>
                    </div>
                </div>
            </div>
            <div class="owl-carousel top-categories-slider">
                @foreach ($topCategories as $category)
                    @if(empty($category->parent_id))
                        <a href="{{ route('catalog.index', ['categories' => [$category->slug ]]) }}"
                           class="feature-box">
                            <img src="{{ url('storage/' . $category->image_path) }}" alt="img">
                            <h5>{{ $category->name }}</h5>
                        </a>
                    @else
                        <a href="{{ route('catalog.index', ['sub_categories' => [ $category->id ]]) }}"
                           class="feature-box">
                            <img src="{{ url('storage/' . $category->image_path) }}" alt="img">
                            <h5>{{ $category->name }}</h5>
                        </a>
                    @endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center aos" data-aos="fade-up">
                    <a href="{{ route('catalog.index') }}"
                       class="site-button site-button-primary site-button-mw m-4"
                    >View All Services</a>
                </div>
                <span id="edition-anchor"></span>
            </div>
        </div>
    </section>
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center aos " data-aos="fade-up">
                    <div class="section-heading">
                        <h2>Michigan’s Premier Home Goods & Service Providers</h2>
                    </div>
                </div>
                <div class="owl-carousel partners-slider aos " data-aos="fade-up">
                    @foreach($logos as $logo)
                        <div class="partner-img">
                            <img src="{{ url('storage/' . $logo->file->path) }}" alt="img">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div class="pride">
        <div>
            <span>IN</span>print & <span>ON</span>line
        </div>
        <div class="pride-separator"> |</div>
        <div>
            Your Local Home Resource Guide<sup>&reg;</sup>
        </div>
    </div>

    @component('components.scrollToTop')
    @endcomponent
@endsection
