<!-- Navigation Breadcrumb -->
<div class="breadcrumb-navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-links">
                    <a href="{{ route('index') }}">← Home</a>

                    @if(isset($businessName))
                        <span class="separator">›</span>
                        <a href="{{ route('catalog.index') }}">Services</a>

                        @if(isset($categorySlug) && isset($categoryName))
                            <span class="separator">›</span>
                            <a href="{{ route('catalog.index', ['categories' => [$categorySlug->toHtml()]]) }}">{{ $categoryName }}</a>
                        @endif

                        <span class="separator">›</span>
                        <span class="current">{{ $businessName }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Navigation Breadcrumb -->
