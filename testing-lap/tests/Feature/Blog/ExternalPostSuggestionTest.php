<?php

namespace Tests\Feature\Blog;

use App\Http\Controllers\ExternalPostSuggestionController;
use App\Http\Requests\ExternalnRequest;
use App\Models\ExternalPostSuggestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExternalPostSuggestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function external_post_can_be_submitted()
    {
        $this->withoutExceptionHandling();

        User::factory()->create();

        $this->post(action(ExternalPostSuggestionController::class), [
            'title' => 'test',
            'url' => 'https://test.com'
        ])
            ->assertRedirect(route('index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas(ExternalPostSuggestion::class, [
            'title' => 'test',
            'url' => 'https://test.com'
        ]);
    }
}
