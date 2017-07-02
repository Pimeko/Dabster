<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentsOnly()
    {
        return $this->hasMany(UserComment::class);
    }

    public function comments()
    {
        return $this->hasMany(UserComment::class)->with('user')->orderByDesc('comment_date');
    }

    public function likes()
    {
        return $this->hasMany(UserLike::class);
    }
}
