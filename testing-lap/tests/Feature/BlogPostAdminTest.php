<?php

namespace Tests\Feature;

use App\Http\Controllers\BlogPostAdminController;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogPostAdminTest extends TestCase
{
    /** @test */
    public function only_logged_in_users_can_make_changes_to_a_post()
    {
        $this->withoutExceptionHandling();

        $post = BlogPost::factory()->create();

        $sendRequest = fn () => $this->post(action([BlogPostAdminController::class, 'update'], $post), [
            'title' => 'test',
        ]);

        $sendRequest()->assertRedirect(route('login'));

        $this->assertNotEquals('test', $post->refresh()->title);


        $this->login();

        $sendRequest();


        $this->assertEquals('test', $post->refresh()->title);
    }
}
