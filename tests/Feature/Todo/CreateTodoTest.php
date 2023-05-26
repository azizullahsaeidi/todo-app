<?php
namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\TodoType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTodoTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    // Test that a new Todo item can be created with valid data.
    public function test_todo_data_can_be_inserted(): void
    {
        // Create a new user and todoType.
        $user = User::factory()->create();
        $todoType = TodoType::factory()->create();

        // Make a POST request to create a new Todo item with the given data.
        $response = $this
            ->actingAs($user)
            ->post('todos', [
                'todo_type_id' => $todoType->id,
                'title' => 'Code Refactoring',
                'date' => '2023-05-26',
                'description' => 'I need to refactor all these code'
            ]);

        // Assert that the response redirects to the todos page.
        $response->assertRedirect('todos');

        // Assert that the created Todo item has the expected values.
        $todo = Todo::first();

        $this->assertSame('2023-05-26', $todo->date);
        $this->assertSame('Code Refactoring', $todo->title);
        $this->assertSame($todoType->id, $todo->todo_type_id);
        $this->assertSame('I need to refactor all these code', $todo->description);
    }

    // Test various validation rules for creating a Todo item.

    // Test that the todo_type_id field is required.
    public function test_todo_type_id_is_required()
    {
        // Create a new user.
        $user = User::factory()->create();

        // Make a POST request with an empty todo_type_id field.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'todo_type_id' => '',
        ]));

        // Assert that the response has a session error for the todo_type_id field.
        $response->assertSessionHasErrors('todo_type_id');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the todo_type_id field must be a number.
    public function test_todo_type_id_must_be_number()
    {
        // Create a new user.
        $user = User::factory()->create();

        // Make a POST request with a non-numeric todo_type_id field        
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'todo_type_id' => "string",
        ]));

        // Assert that the response has a session error for the todo_type_id field.
        $response->assertSessionHasErrors('todo_type_id');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the todo_type_id field should exist.
    public function test_todo_type_id_should_be_exist()
    {
        // Create a new user.
        $user = User::factory()->create();

        // Make a POST request with a non-existent todo_type_id field.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'todo_type_id' => 91291929,
        ]));

        // Assert that the response has a session error for the todo_type_id field.
        $response->assertSessionHasErrors('todo_type_id');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }


        // Test that the title field is required.
    public function test_title_is_required()
    {
        // Create a new user.
        $user = User::factory()->create();

        // Make a POST request with an empty title field.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'title' => '',
        ]));

        // Assert that the response has a session error for the title field.
        $response->assertSessionHasErrors('title');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the title field cannot be less than 1 word.
    public function test_title_cannot_be_less_than_1_word()
    {
        $user = User::factory()->create();

        // Make a POST request with a title that is less than 1 word.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'title' => '#434',
        ]));

        // Assert that the response has a session error for the title field.
        $response->assertSessionHasErrors('title');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the title field cannot be longer than 20 words.
    public function test_title_cannot_be_longer_than_20_words()
    {
        $user = User::factory()->create();

        // Make a POST request with a title that is longer than 20 words.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'title' => \Faker\Factory::create()->words(25, true), // more than 20 words
        ]));

        // Assert that the response has a session error for the title field.
        $response->assertSessionHasErrors('title');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the date field is required.
    public function test_date_is_required()
    {
        $user = User::factory()->create();

        // Make a POST request with an empty date field.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'date' => '',
        ]));

        // Assert that the response has a session error for the date field.
        $response->assertSessionHasErrors('date');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the date field must be a valid date.
    public function test_date_must_be_a_valid_date()
    {
        $user = User::factory()->create();

        // Make a POST request with an invalidate field.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'date' => 'incorrect date',
        ]));

        // Assert that the response has a session error for the date field.
        $response->assertSessionHasErrors('date');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the description field is required.
    public function test_description_is_required()
    {
        $user = User::factory()->create();

        // Make a POST request with an empty description field.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'description' => '',
        ]));

        // Assert that the response has a session error for the description field.
        $response->assertSessionHasErrors('description');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the description field cannot be less than 5 words.
    public function test_description_cannot_be_less_then_5_words()
    {
        $user = User::factory()->create();

        // Make a POST request with a description that is less than 5 words.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'description' => 'one two three four',
        ]));

        // Assert that the response has a session error for the description field.
        $response->assertSessionHasErrors('description');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Test that the description field cannot be longer than 1000 words.
    public function test_description_cannot_be_longer_than_1000_words()
    {
        $user = User::factory()->create();

        // Make a POST request with a description that is longer than 1000 words.
        $response = $this->actingAs($user)->post('/todos', $this->validData([
            'description' => \Faker\Factory::create()->words(1010, true), // more than 1000 words
        ]));

        // Assert that the response has a session error for the description field.
        $response->assertSessionHasErrors('description');

        // Assert that no Todo item has been created.
        $this->assertNull(Todo::first());
    }

    // Todo valid data.
    protected function validData($merge = [])
    {
        // Create a new TodoType.
        $todoType = TodoType::factory()->create();

        // Return an array with default valid data for a Todo item, and any merged data.
        return array_merge([
            'title' => 'New Todo',
            'todo_type_id' => $todoType->id,
            'date' => date("Y-m-d"),
            'description'=> 'Some words about todo description',
        ], $merge);
    }
}
