<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;
use App\UserPost;

class UploadTest extends DuskTestCase
{
    public function test_login_and_upload_ok_route()
    {
        $this->browse(function (Browser $browser) {

            $userCreated = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);

            $browser->visit('/login')
                ->type('pseudo', $userCreated->pseudo)
                ->type('password', 'secret')
                ->press('Login')
                ->clickLink('Poster un dab')
                ->assertPathIs('/upload')
                ->visit('/logout');

            $userCreated->delete();
        });
    }

    public function test_login_and_upload_success()
    {
        $this->browse(function (Browser $browser) {

            $userCreated = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);

            $browser->visit('/login')
                ->type('pseudo', $userCreated->pseudo)
                ->type('password', 'secret')
                ->press('Login')
                ->clickLink('Poster un dab')
                ->assertPathIs('/upload')
                ->attach('image', public_path() . '/img/dab.png')
                ->type('description', 'success dab')
                ->press('Uploader')
                ->visit('/users/' . $userCreated->id)
                ->assertSee('success dab')
                ->visit('/logout');

            UserPost::where('user_id', $userCreated->id)->delete();
            $userCreated->delete();
        });
    }

    public function test_login_and_upload_without_image_fail()
    {
        $this->browse(function (Browser $browser) {
            $userCreated = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);

            $browser->visit('/login')
                ->type('pseudo', $userCreated->pseudo)
                ->type('password', 'secret')
                ->press('Login')
                ->clickLink('Poster un dab')
                ->assertPathIs('/upload')
                ->type('description', 'no upload')
                ->press('Uploader')
                ->assertPathIs('/upload')
                ->visit('/logout');

            $userCreated->delete();
        });
    }

    public function test_login_and_upload_wrong_format_fail()
    {
        $this->browse(function (Browser $browser) {
            $userCreated = factory(User::class)->create([
                'password' => bcrypt('secret')
            ]);

            $browser->visit('/login')
                ->type('pseudo', $userCreated->pseudo)
                ->type('password', 'secret')
                ->press('Login')
                ->clickLink('Poster un dab')
                ->assertPathIs('/upload')
                ->attach('image', public_path() . '/testing/file.txt')
                ->type('description', 'wrong file type')
                ->press('Uploader')
                ->assertPathIs('/upload')
                ->visit('/logout');

            $userCreated->delete();
        });
    }
}
