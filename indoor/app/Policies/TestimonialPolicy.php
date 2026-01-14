<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\User;

class TestimonialPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Testimonial $testimonial): bool
    {
        return $user->hasRole(['admin', 'super admin'])
            || $user->providerDetail?->id == $testimonial->provider_detail_id;
    }
}
