<?php

namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchTodosTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * Test that the page for displaying todos is displayed.
     *
     * @return void
     */
    public function test_to_page_is_displayed(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create 100 todos associated with the user
        Todo::factory(100)->create(['user_id' => $user->id]);

        // Send an HTTP GET request to the "/todos" URL while authenticated as the user
        $response = $this->actingAs($user)->get('todos');

        // Assert that the response status code is 200 (OK)
        $response->assertOk();

        // Assert that there are 100 todos in the database
        $this->assertEquals(100, Todo::count());
    }
}