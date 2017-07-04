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

    public function test_get_user_by_id_has_good_fields()
    {
        $userCreated = factory(User::class)->create();

        $user = UserHelper::getUserById($userCreated->id);
        $this->assertTrue($user->id == $userCreated->id);
        $this->assertTrue($user->pseudo == $userCreated->pseudo);
        $this->assertTrue($user->email == $userCreated->email);

        $userCreated->delete();
    }
}
