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
    

    public function usersFollowers()
    {
        return $this->belongsToMany(User::class, 'user_user', 'followed_id', 'follower_id');
    }

    public function likes()
    {
        return $this->hasMany(UserLike::class);
    }

    public function feed()
    {
        return $this->belongsToMany(User::class, 'user_user', 'follower_id', 'followed_id')
            ->with('posts');
    }

    protected $hidden = [
        'password'
    ];
}
