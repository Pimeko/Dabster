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

    public function usersFollowings()
    {
        return $this->belongsToMany(User::class, 'user_user', 'follower_id', 'followed_id');
    }
/*
    public function usersFollowingsCount()
    {
        return $this->usersFollowings->count;
    }*/

    public function usersFollowers()
    {
        return $this->belongsToMany(User::class, 'user_user', 'followed_id', 'follower_id');
    }
/*
    public function usersFollowersCount()
    {
        return $this->usersFollowers->count;
    }
*/
    public function likes()
    {
        return $this->hasMany(UserLike::class);
    }

    public function likesCount()
    {
        return $this->likes->count;
    }

    protected $hidden = [
        'password'
    ];
}
