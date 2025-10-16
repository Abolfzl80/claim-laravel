<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reaction;

class ReactionPolicy
{
    public function self(User $user, Reaction $reaction)
    {
        return $user->id === $reaction->user_id;    
    }
}
