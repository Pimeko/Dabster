<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;

    public function posts()
    {
        return $this->hasMany(UserPost::class);
    }

    protected $hidden = [
        'password'
    ];
}
