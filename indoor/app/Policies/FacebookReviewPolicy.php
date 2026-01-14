<?php

namespace App\Policies;

use App\Models\FacebookReview;
use App\Models\User;

class FacebookReviewPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FacebookReview $facebookReview): bool
    {
        return $user->hasRole(['admin', 'super admin'])
            || $user->providerDetail?->id == $facebookReview->provider_detail_id;
    }
}
