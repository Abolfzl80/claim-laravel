<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Challenge;

class ChallengePolicy
{
    /**
     * Create a new policy instance.
     */
    public function theyare(User $user, Challenge $c)
    {
        return $user->id === $c->user_two_id;
    }
}
