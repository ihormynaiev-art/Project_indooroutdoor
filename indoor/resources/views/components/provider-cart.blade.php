@props(['provider'])
<div class="service-img">
    <a href="{{ route('provider.details.show', $provider?->slug) }}">
        <img class="img-fluid serv-img" alt="Service Image"
             src="{{ $provider?->logoPath }}">
    </a>
</div>
<div class="service-content">
    <h3 class="title">
        <a href="{{ route('provider.details.show', $provider?->slug) }}">{{ $provider?->business_name }}</a>
    </h3>
    <p>
        @if($provider->phone)
            <i class="feather-phone"></i>{{ $provider->phone }}
        @endif
        @if($provider->testimonials_avg_rating)
            <span class="rate float-end"><i class="fas fa-star filled"></i>{{ number_format($provider->testimonials_avg_rating, 1) }}</span>
        @endif
    </p>
    <div class="serv-info">
        <a href="{{ route('provider.details.show', $provider?->slug) }}" class="btn btn-book">More info</a>
    </div>
</div>
