<?php

namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\TodoType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTodoTest extends TestCase
{
    // This trait refreshes the database after each test.
    use DatabaseMigrations, RefreshDatabase;

    public function test_todo_data_can_be_updated(): void
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Create two TodoType instances using the TodoType factory
        $todoType1 = TodoType::factory()->create();
        $todoType2 = TodoType::factory()->create();

        // Create a new Todo instance using the Todo factory and assign it to the user
        $todo = Todo::factory()->create([
            'user_id' => $user->id,
            'todo_type_id' => $todoType1->id,
            'title' => 'New Title',
        ]);

        // Send a PATCH request to update the Todo item with new data, and assert that the Todo item has been updated
        $response = $this
            ->actingAs($user)
            ->patch("todos/$todo->id", [
                'todo_type_id' => $todoType2->id,
                'title' => 'Title updated',
                'date' => '2023-05-26',
                'description' => 'I want to update this description',
            ]);

        // Assert that the response redirects to the todos index page
        $response->assertRedirect('todos');

        // Refresh the Todo instance to update it with the new data
        $todo->refresh();

        // Assert that the Todo item has been updated with the new data
        $this->assertSame('2023-05-26', $todo->date);
        $this->assertSame('Title updated', $todo->title);
        $this->assertSame($todoType2->id, $todo->todo_type_id);
        $this->assertSame('I want to update this description', $todo->description);
    }

    // These tests validate TodoType ID input

    public function test_todo_type_id_is_required()
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Find an existing Todo instance using the validData method
        $todo = Todo::find($this->validData()['id']);

        // Send a PATCH request with an empty todo_type_id and assert that the response returns a validation error
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'todo_type_id' => '',
        ]));
        $response->assertSessionHasErrors('todo_type_id');

        // Refresh the Todo instance to ensure that it has not been updated
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    public function test_todo_type_id_must_be_number()
    {
        // Create a new user using the User factory
    $user = User::factory()->create();

        // Find an existing Todo instance using the validData method
        $todo = Todo::find($this->validData()['id']);

        // Send a PATCH request with a non-numeric todo_type_id and assert that the response returns a validation error
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'todo_type_id' => 'string',
        ]));
        $response->assertSessionHasErrors('todo_type_id');

        // Refresh the Todo instance to ensure that it has not been updated
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    public function test_todo_type_id_should_be_exist()
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Find an existing Todo instance using the validData method
        $todo = Todo::find($this->validData()['id']);

        // Send a PATCH request with a non-existent todo_type_id and assert that the response returns a validation error
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'todo_type_id' => 91291929,
        ]));
        $response->assertSessionHasErrors('todo_type_id');

        // Refresh the Todo instance to ensure that it has not been updated
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    // These tests validate the Todo title input

    public function test_title_is_required()
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Find an existing Todo instance using the validData method
        $todo = Todo::find($this->validData()['id']);

        // Send a PATCH request with an empty title and assert that the response returns a validation error
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'title' => '',
        ]));
        $response->assertSessionHasErrors('title');

        // Refresh the Todo instance to ensure that it has not been updated
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    public function test_title_cannot_be_less_than_1_word()
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Find an existing Todo instance using the validData method
        $todo = Todo::find($this->validData()['id']);

        // Send a PATCH request with a one-word title and assert that the response returns a validation error
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'title' => '#434',
        ]));
        $response->assertSessionHasErrors('title');

        // Refresh the Todo instance to ensure that it has not been updated
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    public function test_title_cannot_be_longer_than_20_words()
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Find an existing Todo instance using the validData method
        $todo = Todo::find($this->validData()['id']);

        // Send a PATCH request with a title that is more than 20 words and assert that the response returns a validation error
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'title' => \Faker\Factory::create()->words(25, true), // more than 20 words
        ]));
        $response->assertSessionHasErrors('title');

        // Refresh the Todo instance to ensure that it has not been updated
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    // Tests whether the `date` field is required when updating a `Todo` model.
    public function test_date_is_required()
    {
        // Create a new user and retrieve an existing `Todo` model.
        $user = User::factory()->create();
        $todo = Todo::find($this->validData()['id']);

        // Attempt to update the `Todo` model with an empty string for the `date` field.
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'date' => '',
        ]));

        // Assert that the response contains an error for the `date` field.
        $response->assertSessionHasErrors('date');

        // Refresh the `Todo` model from the database and assert that its `title` field has not been updated.
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    // Tests whether the `date` field must be a valid date when updating a `Todo` model.
    public function test_date_must_be_a_valid_date()
    {
        // Create a new user and retrieve an existing `Todo` model.
        $user = User::factory()->create();
        $todo = Todo::find($this->validData()['id']);

        // Attempt to update the `Todo` model with an invalid string for the `date` field.
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'date' => 'incorrect date',
        ]));

        // Assert that the response contains an error for the `date` field.
        $response->assertSessionHasErrors('date');

        // Refresh the `Todo` model from the database and assert that its `title` field has not been updated.
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    // Tests whether the `description` field is required when updating a `Todo` model.
    public function test_description_is_required()
    {
        // Create a new user and retrieve an existing `Todo` model.
        $user = User::factory()->create();
        $todo = Todo::find($this->validData()['id']);

        // Attempt to update the `Todo` model with an empty string for the `description` field.
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'description' => '',
        ]));

        // Assert that the response contains an error for the `description` field.
        $response->assertSessionHasErrors('description');

        // Refresh the `Todo` model from the database and assert that its `title` field has not been updated.
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    public function test_description_cannot_be_less_then_5_words()
    {
        // Create a new user and retrieve an existing `Todo` model.
        $user = User::factory()->create();
        $todo = Todo::find($this->validData()['id']);

        // Attempt to update the `Todo` model with a short string for the `description` field.
        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'description' => 'one two three four',
        ]));

        // Assert that the response contains an error for the `description` field.
        $response->assertSessionHasErrors('description');

        // Refresh the `Todo` model from the database and assert that its `title` field has not been updated.
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    public function test_description_cannot_be_longer_than_1000_words()
    {
        // Create a new user and retrieve an existing `Todo` model.
        $user = User::factory()->create();
        $todo = Todo::find($this->validData()['id']);

        $response = $this->actingAs($user)->patch("todos/$todo->id", $this->validData([
            'description' => \Faker\Factory::create()->words(1010, true), // more than 1000 words
        ]));
        
        // Assert that the response contains an error for the `description` field.
        $response->assertSessionHasErrors('description');
        
        // Refresh the `Todo` model from the database and assert that its `title` field has not been updated.
        $todo->refresh();
        $this->assertNotEquals('Updated title', $todo->title);
        $this->assertEquals('CW4WAfghan', $todo->title);
    }

    // Returns an array of valid data for a `Todo` model.
    protected function validData($merge = [])
    {
        // Create a new `Todo` model with a specific title.
        $todo = Todo::factory()->create(['title' => 'CW4WAfghan']);

        // Define the default data for the `Todo` model and merge it with any additional data.
        return array_merge([
            'id' => $todo->id,
            'title' => 'Updated title',
            'todo_type_id' => $todo->todo_type_id,
            'date' => date('Y-m-d'),
            'description' => 'Some words about todo description',
        ], $merge);
    }
}
