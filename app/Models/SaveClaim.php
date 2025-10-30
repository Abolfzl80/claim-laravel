<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveClaim extends Model
{
    protected $table = 'save_claims';
    protected $fillable = [
        'claim_id',
        'user_id',
    ];
}
