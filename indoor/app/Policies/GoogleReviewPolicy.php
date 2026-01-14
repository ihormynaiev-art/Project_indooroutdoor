<?php

namespace App\Policies;

use App\Models\GoogleReview;
use App\Models\User;

class GoogleReviewPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GoogleReview $googleReview): bool
    {
        return $user->hasRole(['admin', 'super admin'])
            || $user->providerDetail?->google_place_id == $googleReview->place_id;
    }
}
