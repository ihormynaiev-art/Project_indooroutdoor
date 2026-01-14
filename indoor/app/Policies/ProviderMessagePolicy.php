<?php

namespace App\Policies;

use App\Models\ProviderMessage;
use App\Models\User;

class ProviderMessagePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProviderMessage $providerMessage): bool
    {
        return $user->hasRole(['admin', 'super admin'])
            || $user->providerDetail?->id == $providerMessage->provider_detail_id;
    }
}
