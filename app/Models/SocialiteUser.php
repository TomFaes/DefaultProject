<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialiteUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider'
    ];

    public function user()
    {
        return $this->belongsTo('user', 'id', 'user_id');
    }
}
