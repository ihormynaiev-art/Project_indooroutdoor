<div class="bg-img">
    <img src="{{ URL::asset('/assets/img/bg/work-bg-03.png') }}" alt="img" class="bgimg1">
    <img src="{{ URL::asset('/assets/img/bg/work-bg-03.png') }}" alt="img" class="bgimg2">
    @if (!Route::is(['categories', 'pricing', 'maintenance', 'coming-soon', 'privacy-policy', 'terms-condition']))
        <img src="{{ URL::asset('/assets/img/bg/feature-bg-03.png') }}" alt="img" class="bgimg3">
    @endif
    @if (Route::is(['faq']))
        <img src="{{ URL::asset('/assets/img/bg/about-bg-01.png') }}" alt="img" class="bgimg4 img-fluid">
    @endif
</div>
