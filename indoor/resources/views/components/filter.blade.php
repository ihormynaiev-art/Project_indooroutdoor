@props(['categories' => [], 'subCategories' => [], 'providersTotal' => 0, 'searchResponse' => false])

<div class="col-lg-3 col-sm-12 theiaStickySidebar">
    <div class="filter-div">
        <form action="{{ route('catalog.index') }}" method="GET" data-autocomplete-url="{{ route('search-autocomplete-service') }}">
            @if(request('sort'))
                <input hidden name="sort" value="{{ request('sort') }}">
            @endif
            <div class="filter-head">
                <!-- <h5>Filter by</h5> -->
                <a href="{{ route('catalog.index') }}" class="reset-link">Reset Filters</a>
                <span class="filter-text">Found {{ $providersTotal }} Providers</span>
            </div>
            <div id="filters"
                 class="filters-transition
                    @if($searchResponse)
                        d-none
                    @else
                        show
                    @endif"
            >
                <div class="filter-content">
                    <h2>Keyword</h2>
                    <input type="text" value="{{ request('search') }}" name="search" id="search-autocomplete-services"
                           class="form-control" placeholder="What are you looking for?">
                    <div id="search-autocomplete-service"></div>
                    <div class="quick-tips mt-3">
                        <div class="quick-tips-inner d-flex gap-2 align-items-center">
                            <img src="{{ asset('/assets/img/tips.png') }}" alt="tips">
                            <div class="quick-tips-title">Tips for Finding the Best Contractor</div>
                        </div>
                        <ul class="quick-tips-content">
                            <li>
                                <img src="{{ asset('/assets/img/icons/star.png') }}" alt="star">
                                Check their ratings and read recent reviews to learn about others' experiences.
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/icons/image-editing.png') }}" alt="image-editing">
                                Browse examples of their work, especially before-and-after photos, to gauge quality.
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/icons/guarantee.png') }}" alt="guarantee">
                                Verify licenses, business details, and background checks in the Credentials section or
                                ask directly.
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/icons/business-card.png') }}" alt="business-card">
                                Explore their introduction, overview, and FAQs for additional insights into their
                                business.
                            </li>
                        </ul>
                    </div>
                </div>
                <h4 class="filter-head-title">Get Started!</h4>
                <div class="filter-content">
                    <h2>1. Select Home Solutions</h2>
                    <div class="filter-checkbox filter-fill-more">
                        <ul>
                            @foreach($categories as $category)
                                <li>
                                    <label class="checkboxs">
                                        <input
                                            name="categories[]"
                                            value="{{ $category->slug }}"
                                            type="checkbox"
                                            class="category-checkbox"
                                            @checked(in_array($category->slug, request('categories', [])))
                                        >
                                        <span><i></i></span>
                                        <b class="check-content"> {{ $category->name }} </b>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="javascript:void(0);" class="filter-more-view">View More <i
                            class="feather-arrow-down-circle ms-1"></i></a>
                </div>
                <div class="filter-content subcategory-filter" id="subcategory-section" style="@if(empty(request('categories', []))) display: none; @endif">
                    <h2>2. Select Specific Solutions</h2>
                    <div class="filter-checkbox filter-fill-more">
                        <ul>
                            @foreach($subCategories as $subCategory)
                                <li style="{{ !empty(request('categories', [])) && !in_array($subCategory->parent->slug, request('categories', [])) ? 'display:none;' : '' }}">
                                    <label class="checkboxs">
                                        <input
                                            name="sub_categories[]"
                                            value="{{ $subCategory->id }}"
                                            type="checkbox"
                                            class="subcategory-checkbox"
                                            data-parent-slug="{{ $subCategory->parent->slug }}"
                                            @checked(in_array($subCategory->id, request('sub_categories', [])))
                                        >
                                        <span><i></i></span>
                                        <b class="check-content"> {{ $subCategory->name }} </b>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="javascript:void(0);" class="filter-more-view">View More <i
                            class="feather-arrow-down-circle ms-1"></i></a>
                </div>
            </div>
            @if($searchResponse)
                <div class="d-lg-none">
                    <button id="showFiltersButton" type="button"
                            class="site-button site-button-primary w-100 dropdown-toggle"
                            onclick="showFilters()">Refine Filters
                    </button>

                    <button id="hideFiltersButton" type="button"
                            class="site-button site-button-primary w-100 d-none dropdown-toggle dropdown-toggle-up"
                            onclick="hideFilters()">Hide Filters
                    </button>
                </div>
            @endif
            <button type="submit" id="show-results-btn" class="site-button site-button-primary my-2 w-100" @if(empty(request('categories', [])) && empty(request('search'))) disabled @endif>Show Results</button>
            <div class="filter-footer">
                <!-- <h5>Filter by</h5> -->
                <a href="{{ route('catalog.index') }}" class="reset-link">Reset Filters</a>
                <span class="filter-text">Found {{ $providersTotal }} Providers</span>
            </div>
        </form>
    </div>
</div>
@push('scripts')
@endpush
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

        categoryCheckboxes.forEach(function(categoryCheckbox) {
            categoryCheckbox.addEventListener('change', function() {
                if (!this.checked) {
                    const categorySlug = this.value;
                    const subcategoryCheckboxes = document.querySelectorAll(`.subcategory-checkbox[data-parent-slug="${categorySlug}"]`);

                    subcategoryCheckboxes.forEach(function(subcategoryCheckbox) {
                        subcategoryCheckbox.checked = false;
                    });
                }
            });
        });
    });

    function showFilters() {
        const filters = document.getElementById('filters');
        const showBtn = document.getElementById('showFiltersButton');
        const hideBtn = document.getElementById('hideFiltersButton');

        filters.classList.remove('d-none');
        filters.classList.remove('hiding');

        requestAnimationFrame(() => {
            filters.classList.add('show');
        });

        showBtn.classList.add('d-none');
        hideBtn.classList.remove('d-none');
    }

    function hideFilters() {
        const filters = document.getElementById('filters');
        const showBtn = document.getElementById('showFiltersButton');
        const hideBtn = document.getElementById('hideFiltersButton');

        filters.classList.remove('show');

        const onEnd = () => {
            filters.classList.add('d-none');
            filters.classList.remove('hiding');

            filters.removeEventListener('transitionend', onEnd);
        };

        filters.addEventListener('transitionend', onEnd, {once: true});

        hideBtn.classList.add('d-none');
        showBtn.classList.remove('d-none');
    }
</script>
