<li class="{{ Route::is(['provider.requestQuotes.index', 'provider.requestQuotes.show']) ? 'active' : '' }}">
    <a href="{{ route('provider.request-quotes.index') }}">
        <i class="feather-message-square"></i>
        <span>Request Quotes</span>
        @if($newQuotes !== '0')
            <span class="green-number">{{ $newQuotes }}</span>
        @endif
    </a>
</li>
