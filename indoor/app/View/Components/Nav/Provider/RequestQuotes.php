<?php

namespace App\View\Components\Nav\Provider;

use App\Enums\RequestQuote\RequestQuoteStatusEnum;
use App\Models\RequestQuote;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class RequestQuotes extends Component
{
    public string $newQuotes;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->newQuotes = RequestQuote::query()
            ->whereHas('provider', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', RequestQuoteStatusEnum::NEW->value)
            ->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav.provider.request-quotes');
    }
}
