<?php
namespace App;

use App\User;
use Session;

class UserHelper
{
    public static function getUserByPseudo($pseudo)
    {
        return User::where('pseudo', $pseudo)->first();
    }

    public static function GetUserById($userId)
    {
        return User::where('id', $userId)->first();
    }

    public static function GetAuthUser()
    {
        if (!Session::has('user_id'))
            return null;
        return UserHelper::GetUserById(Session::get("user_id"));
    }

    // Does A follow B ?
    public static function doesUserFollows($userA, $userB)
    {
        $res = false;

        $followers = $userB->usersFollowers;
        foreach ($followers as &$follower) {
            if ($follower->id == $userA->id) {
                $res = true;
            }
        }

        return $res;
    }
}