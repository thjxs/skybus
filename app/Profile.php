<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'from', 'uid', 'username', 'name', 'email', 'location',
        'description', 'avatar', 'access_token', 'access_token_expired_at',
        'access_token_secret',
    ];

    protected $dates = [
        'access_token_expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
