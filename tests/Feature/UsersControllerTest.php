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

        session()->flush();
        $user->delete();
    }

    public function test_register_redirects_to_home()
    {
        $response = $this->call('POST', 'register',[
            'pseudo' => 'user',
            'email' => 'user@mail.com',
            'password' => 'abc']);
        $response->assertRedirect('/');

        $user = User::where('pseudo', 'user')->first();

        session()->flush();
        $user->delete();

    }

    public function test_authenticate_stores_data_in_session()
    {
        $this->call('POST', 'register',[
            'pseudo' => 'user',
            'email' => 'user@mail.com',
            'password' => 'abc']);
        $this->call('GET', 'logout');
        $user = User::where('pseudo', 'user')->first();

        $response = $this->call('POST', 'login',[
            'pseudo' => 'user',
            'password' => 'abc']);
        $response->assertRedirect('/');
        $response->assertSessionHas('user_id');
        $response->assertSessionHas('token');

        session()->flush();
        $user->delete();
    }

    public function test_authenticate_redirects_to_home()
    {
        $this->call('POST', 'register',[
            'pseudo' => 'user',
            'email' => 'user@mail.com',
            'password' => 'abc']);
        $this->call('GET', 'logout');
        $user = User::where('pseudo', 'user')->first();

        $response = $this->call('POST', 'login',[
            'pseudo' => 'user',
            'password' => 'abc']);

        $response->assertRedirect('/');

        session()->flush();
        $user->delete();
    }

    public function test_logout_redirects_home_and_flush_session()
    {
        $this->call('POST', 'register',[
            'pseudo' => 'user',
            'email' => 'user@mail.com',
            'password' => 'abc']);
        $this->call('GET', 'logout');
        $user = User::where('pseudo', 'user')->first();

        $this->call('POST', 'login',[
            'pseudo' => 'user',
            'password' => 'abc']);

        $logout = $this->call('GET', 'logout');

        $logout->assertSessionMissing('user_id');
        $logout->assertSessionMissing('token');
        $logout->assertRedirect('/');

        session()->flush();
        $user->delete();
    }
}
