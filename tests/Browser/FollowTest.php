<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class FollowTest extends DuskTestCase
{
    public function test_login_and_follows()
    {
        $this->browse(function (Browser $browser) {

            $auth = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);
            $userToFollow = factory(User::class)->create();

            $browser->visit('/login')
                ->type('pseudo', $auth->pseudo)
                ->type('password', 'secret')
                ->press('Login')
                ->visit('/users/' . $userToFollow->id)
                ->press('Suivre')
                ->visit('/users/' . $auth->id . '/followings')
                ->assertSee($userToFollow->pseudo)
                ->visit('/logout');

            $userToFollow->delete();
            $auth->delete();
        });
    }

    public function test_login_and_unfollows()
    {
        $this->browse(function (Browser $browser) {

            $auth = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);
            $userToFollow = factory(User::class)->create();

            $browser->visit('/login')
                ->type('pseudo', $auth->pseudo)
                ->type('password', 'secret')
                ->press('Login')
                ->visit('/users/' . $userToFollow->id)
                ->press('Suivre')
                ->press('Ne plus suivre')
                ->visit('/users/' . $auth->id . '/followings')
                ->assertDontSee($userToFollow->pseudo)
                ->visit('/logout');

            $userToFollow->delete();
            $auth->delete();
        });
    }
}
