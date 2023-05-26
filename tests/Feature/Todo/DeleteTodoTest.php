<?php
namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTodoTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function test_to_page_is_displayed(): void
    {
        // Create a user.
        $user = User::factory()->create();

        // Create a todo.
        $todo = Todo::factory()->create();

        // Make a DELETE request to the route for deleting a specific Todo item.
        $response = $this->actingAs($user)->delete(route('todos.destroy', $todo));

        // Assert that the response status is 302 (redirect).
        $response->assertStatus(302);

        // Assert that the Todo item has been successfully deleted.
        $this->assertEquals(Todo::where('id', $todo->id)->first(),null);
    }
}