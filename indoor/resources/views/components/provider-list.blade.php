@props(['provider'])
<div class="service-list">
    <div class="service-cont">
        <div class="service-cont-img">
            <a href="{{ route('provider.details.show', $provider?->slug) }}">
                <img class="img-fluid serv-img" alt="Service Image"
                     src="{{ $provider?->logoPath }}">
            </a>
        </div>
        <div class="service-cont-info">
            <h3 class="title">
                <a href="{{ route('provider.details.show', $provider?->slug) }}">{{ $provider?->business_name }}</a>
            </h3>
            @if($provider->phone)
                <span>
                    <i class="feather-phone"></i>
                    <a href="tel:{{ $provider->phone }}">{{ $provider->phone }}</a>
                </span>
            @endif
            @if($provider->testimonials_avg_rating)
                <div class="service-pro-img">
                <span><i
                        class="fas fa-star filled"></i>{{ number_format($provider->testimonials_avg_rating, 1) }}</span>
                </div>
            @endif

        </div>
    </div>
    <div class="service-action">
        <a href="{{ route('provider.details.show', $provider?->slug) }}"
           class="site-button site-button-neutral">View Profile</a>
    </div>
</div>
