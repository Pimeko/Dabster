<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class LoginTest extends DuskTestCase
{
    public function test_login_redirects_to_feed()
    {
        $this->browse(function (Browser $browser) {

            $userCreated = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);

            $browser->visit('/login')
                ->type('pseudo', $userCreated->pseudo)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/users/' . $userCreated->id . '/feed')
                ->visit('/logout');

            $userCreated->delete();
        });
    }

    public function test_login_fails_on_password()
    {
        $this->browse(function (Browser $browser) {

            $userCreated = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);

            $browser->visit('/login')
                ->type('pseudo', $userCreated->pseudo)
                ->type('password', 'wrongsecret')
                ->press('Login')
                ->assertPathIs('/login')
                ->visit('/logout');

            $userCreated->delete();
        });
    }

    public function test_login_fails_on_pseudo()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/login')
                ->type('pseudo', 'wronguser')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/login')
                ->visit('/logout');
        });
    }
}
