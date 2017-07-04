<?php

namespace Tests\Unit;

use App\User;
use App\UserHelper;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    public function test_get_user_by_pseudo_has_good_fields()
    {
        $userCreated = factory(User::class)->create();

        $user = UserHelper::getUserByPseudo($userCreated->pseudo);
        $this->assertTrue($user->id == $userCreated->id);
        $this->assertTrue($user->pseudo == $userCreated->pseudo);
        $this->assertTrue($user->email == $userCreated->email);

        $userCreated->delete();
    }

    public function test_get_user_by_pseudo_is_null()
    {
        $userCreated = factory(User::class)->create();
        $pseudo = $userCreated->name;
        $userCreated->delete();

        $user = UserHelper::getUserByPseudo($pseudo);
        $this->assertTrue($user == null);
    }


    public function test_get_user_by_id_has_good_fields()
    {
        $userCreated = factory(User::class)->create();

        $user = UserHelper::getUserById($userCreated->id);
        $this->assertTrue($user->id == $userCreated->id);
        $this->assertTrue($user->pseudo == $userCreated->pseudo);
        $this->assertTrue($user->email == $userCreated->email);

        $userCreated->delete();
    }

    public function test_get_user_by_id_is_null()
    {
        $userCreated = factory(User::class)->create();
        $id = $userCreated->id;
        $userCreated->delete();

        $user = UserHelper::getUserById($id);
        $this->assertTrue($user == null);
    }

    public function test_get_auth_user_has_good_fields()
    {
        $userCreated = factory(User::class)->create();

        session(['user_id' => $userCreated->id]);
        $user = UserHelper::GetAuthUser();
        $this->assertTrue($user->id == $userCreated->id);
        session()->forget('user_id');

        $userCreated->delete();
    }

    public function test_get_auth_user_is_null()
    {
        $userCreated = factory(User::class)->create();
        session(['user_id' => $userCreated->id]);
        session()->forget('user_id');
        $userCreated->delete();

        $user = UserHelper::GetAuthUser();
        $this->assertTrue($user == null);
    }
}
