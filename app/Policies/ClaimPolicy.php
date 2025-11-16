<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Claim;

class ClaimPolicy
{

    public function self(User $user, Claim $claim)
    {
        return $user->id === $claim->user_id;    
    }

}
