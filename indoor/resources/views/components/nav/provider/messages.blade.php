<li class="{{ Route::is(['provider.provider-messages.index', 'provider.provider-messages.show']) ? 'active' : '' }}">
    <a href="{{ route('provider.provider-messages.index') }}">
        <i class="feather-message-square"></i>
        <span>Messages</span>@if($unreadMessages !== '0')<span class="green-number">{{ $unreadMessages }}</span>@endif
    </a>
</li>
