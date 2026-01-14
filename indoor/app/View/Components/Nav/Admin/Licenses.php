<?php

namespace App\View\Components\Nav\Admin;

use App\Models\File;
use App\Models\ProviderDetail;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Licenses extends Component
{
    public string $licensesInReview;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $lastStatusSub = File::query()
            ->select('files.status')
            ->whereColumn('fileable_id', 'provider_details.id')
            ->where('fileable_type', ProviderDetail::class)
            ->whereIn('type', ['certificate', 'insurance'])
            ->orderByDesc('created_at')
            ->limit(1);

        $this->licensesInReview = User::query()
            ->role('provider')
            ->leftJoin('provider_details', 'provider_details.user_id', '=', 'users.id')
            ->selectSub($lastStatusSub, 'last_cert_status')
            ->having('last_cert_status', '=', 'in_review')
            ->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav.admin.licenses');
    }
}
