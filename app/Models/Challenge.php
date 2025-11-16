<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Claim;
use App\Models\User;

class Challenge extends Model
{
    protected $table = 'challenges';
    protected $fillable = [
        'claim_id',
        'user_one_id',
        'user_two_id',
        'status',
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class, 'claim_id');    
    }

    public function userone()
    {
        return $this->belongsTo(User::class, 'user_one_id');    
    }

    public function usertwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');    
    }
}
