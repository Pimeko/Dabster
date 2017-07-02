<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    public $timestamps = false;

    public function user_posts()
    {
        return $this->belongsTo(UserPost::class, 'user_post_id', 'id');
    }
}
