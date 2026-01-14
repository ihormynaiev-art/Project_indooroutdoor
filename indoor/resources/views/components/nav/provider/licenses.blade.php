<li class="{{ Route::is('provider.verification') ? 'active' : '' }}">
    <a href="{{ route('provider.verification') }}">
        <i class="feather-check-circle"></i>
        <span style="white-space: pre-wrap">Upload License & Insurance</span>
        @if($unverifiedLicenses !== 0)<span class="red-number">{{ $unverifiedLicenses }}</span>@endif
    </a>
</li>
