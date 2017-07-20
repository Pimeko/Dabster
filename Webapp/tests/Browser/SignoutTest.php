<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class SignoutTest extends DuskTestCase
{
    public function test_signout_route()
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
                ->clickLink('Profil')
                ->assertPathIs('/users/' . $userCreated->id . '/posts')
                ->clickLink('Supprimer profil')
                ->assertPathIs('/signout')
                ->visit('/logout');

            $userCreated->delete();
        });
    }

    public function test_signout_fails_empty()
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
                ->clickLink('Profil')
                ->assertPathIs('/users/' . $userCreated->id . '/posts')
                ->clickLink('Supprimer profil')
                ->assertPathIs('/signout')
                ->press('Supprimer mon compte')
                ->assertSee('Le champ pseudo est obligatoire.')
                ->visit('/logout');

            $userCreated->delete();
        });
    }

    public function test_signout_fails_wrong_pseudo()
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
                ->clickLink('Profil')
                ->assertPathIs('/users/' . $userCreated->id . '/posts')
                ->clickLink('Supprimer profil')
                ->assertPathIs('/signout')
                ->type('pseudo', 'wrong ' . $userCreated->pseudo)
                ->press('Supprimer mon compte')
                ->assertSee('Le pseudo n\'est pas correct.')
                ->visit('/logout');

            $userCreated->delete();
        });
    }

    public function test_signout_success()
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
                ->clickLink('Profil')
                ->assertPathIs('/users/' . $userCreated->id . '/posts')
                ->clickLink('Supprimer profil')
                ->assertPathIs('/signout')
                ->type('pseudo', $userCreated->pseudo)
                ->press('Supprimer mon compte')
                ->assertPathIs('/');

            $userCreated->delete();
        });
    }
}
