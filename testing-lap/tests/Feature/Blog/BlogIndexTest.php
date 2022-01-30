<?php

namespace Tests\Feature\Blog;

use App\Models\BlogPost;
use App\Models\BlogPostLike;
use App\Models\BlogPostStatus;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_shows_a_list_of_blog_posts()
    {
        $this->withoutExceptionHandling();

        BlogPost::factory()->count(3)->published()->sequence(

            [
                'title' => 'Parallel php',
            ],
            [
                'title' => 'Fibers',
            ],
            [
                'title' => 'Drafts',
            ],
        )
            ->create();

        BlogPost::factory()->draft()->create(['title' => 'Draft',]);

        $this
            ->get('/')
            ->assertSuccessful()
            ->assertSee('Parallel php')
            ->assertDontSee('Drafts');
    }

    public function test_with_factories()
    {
        // $post = BlogPost::factory()
        //     ->has(BlogPostLike::factory()->count(5))
        //     ->create();


        $postLike = BlogPostLike::factory()
            ->for(BlogPost::factory()->published())
            ->create();

      $this->assertTrue($postLike->blogPost->isPublished());
    }
}
