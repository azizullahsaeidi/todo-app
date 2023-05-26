<?php
namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisplayTodoTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function test_to_page_is_displayed(): void
    {
        // Create a user.
        $user = User::factory()->create();

        // Create a Todo item.
        $todo = Todo::factory()->create();

        // Make a GET request to the route for displaying a specific Todo item.
        $response = $this->actingAs($user)->get("todos/$todo->id");

        // Assert that the response status is 200 (OK).
        $response->assertStatus(200);

        // Assert that the response is OK.
        $response->assertOk();
    }
}