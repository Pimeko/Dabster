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

    public function test_authenticate_stores_data_in_session()
    {
        $userCreated = factory(User::class)->create([
            'pseudo' => 'user',
            'password' => 'abc'
        ]);

        $response = $this->call('POST', 'login',[
            'pseudo' => 'user',
            'password' => 'abc']);

        $response->assertSessionHas('user_id', $userCreated->id);
        $response->assertSessionHas('token');

        $userCreated->delete();
    }

    public function test_authenticate_redirects_to_home()
    {
        $userCreated = factory(User::class)->create([
            'pseudo' => 'user',
            'password' => 'abc'
        ]);

        $response = $this->call('POST', 'login',[
            'pseudo' => 'user',
            'password' => 'abc']);

        $response->assertRedirect('/');

        $userCreated->delete();
    }
}
