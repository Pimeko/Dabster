<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    public function test_register_stores_data_in_session()
    {
        $response = $this->call('POST', 'register',[
            'pseudo' => 'user',
            'email' => 'user@mail.com',
            'password' => 'abc']);
        $user = User::where('pseudo', 'user')->first();

        $this->assertTrue($user->pseudo == 'user');
        $response->assertSessionHas('user_id', $user->id);
        $response->assertSessionHas('token');

        $user->delete();
    }

    public function test_register_redirects_to_home()
    {
        $response = $this->call('POST', 'register',[
            'pseudo' => 'user',
            'email' => 'user@mail.com',
            'password' => 'abc']);
        $user = User::where('pseudo', 'user')->first();
        $user->delete();

        $response->assertRedirect('/');
    }

    public function test_register_redirects_fails()
    {
        $userCreated = factory(User::class)->create([
            'pseudo' => 'user'
        ]);

        $response = $this->call('POST', 'register',[
            'pseudo' => 'user',
            'email' => 'user@mail.com',
            'password' => 'abc']);
        $response->assertRedirect('register');

        $userCreated->delete();

        $userCreated = factory(User::class)->create([
            'pseudo' => 'user'
        ]);
    }
}
