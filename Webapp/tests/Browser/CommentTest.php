<?php

namespace Tests\Browser;

use App\UserPost;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class CommentTest extends DuskTestCase
{
    public function test_comment_success()
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
                ->press('Uploader');
            $post = UserPost::where('user_id', $userCreated->id)->first();

            $browser->visit('/posts/' . $post->id)
                ->assertSee('success dab')
                ->type('data', 'commentaire qui va marcher')
                ->press('Poster')
                ->assertSee('commentaire qui va marcher')
                ->visit('/logout');

            UserPost::where('user_id', $userCreated->id)->delete();
            $userCreated->delete();
        });
    }

    public function test_comment_fail()
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
                ->press('Uploader');
            $post = UserPost::where('user_id', $userCreated->id)->first();

            $browser->visit('/posts/' . $post->id)
                ->assertSee('success dab')
                ->type('data', '/')
                ->press('Poster')
                ->assertDontSee('/')
                ->visit('/logout');

            UserPost::where('user_id', $userCreated->id)->delete();
            $userCreated->delete();
        });
    }
}
