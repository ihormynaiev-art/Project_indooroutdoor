<?php

namespace App\View\Components\Nav\Provider;

use App\Models\ProviderMessage;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Messages extends Component
{
    public string $unreadMessages;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->unreadMessages = ProviderMessage::query()
            ->whereHas('providerDetail', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav.provider.messages');
    }
}
