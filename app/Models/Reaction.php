<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Claim;

class Reaction extends Model
{
    use HasFactory;

    protected $table = 'reactions';
    protected $fillable = [
        'claim_id',
        'user_id',
        'emoji',
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
