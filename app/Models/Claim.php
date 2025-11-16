<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reaction;
use App\Models\User;
use App\Models\Challenge;

class Claim extends Model
{
    use HasFactory;

    protected $table = 'claims';
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'user_id',
    ];
    
    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'claim_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);    
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class, 'claim_id');    
    }
    
}