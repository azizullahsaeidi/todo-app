<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\TodoType;
use RealRashid\SweetAlert\Facades\Alert;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all todos with their associated todo type, 
        // ordered by the latest todo first, and paginate by default 15 todos per page
        $todos = Todo::with('todoType')->orderByDesc('id')->paginate();

        // Return the view for listing todos with the retrieved todos
        return view('todo.index', compact(['todos']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retrieve all todo types and pass them to the view for creating a new todo
        $todoTypes = TodoType::all(['id', 'name']);

        return view('todo.create', compact('todoTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        // Create a new todo with the provided data
        $todo = Todo::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'todo_type_id' => $request->todo_type_id,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        // Show a success message if the todo is successfully created, or an error message if not
        $todo
        ? Alert::success('Congratulation', 'Your todo has been successfully added')
        : Alert::error('Failed', "Sorry! your todo hasn't been successfully added");

        // Redirect to the listing page for todos
        return redirect('todos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        // Show the details of the specified todo
        return view('todo.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        // Retrieve all todo types and pass them, along with the specified todo, to the view for editing the todo        
        $todoTypes = TodoType::all(['id', 'name']);

        return view('todo.edit', compact('todoTypes', 'todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        // Update the specified todo with the provided data
        $todo = $todo->update([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'todo_type_id' => $request->todo_type_id,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        // Show a success message if the todo is successfully updated, or an error message if not
        $todo
        ? Alert::success('Congratulation', 'Your todo has been successfully updated')
        : Alert::error('Failed', "Sorry! your todo hasn't been successfully updated");

        // Redirect to the listing page for todos
        return redirect('todos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\HttpResponse
     */
    public function destroy(Todo $todo)
    {
        // Delete the specified todo from the database
        $todo->delete()
        ? Alert::success('Congratulation', 'Your todo has been successfully deleted')
        : Alert::error('Failed', "Sorry! your todo hasn't been successfully deleted");

        // Redirect to the listing page for todos
        return redirect('todos');
    }
}