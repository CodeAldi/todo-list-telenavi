<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'assignee' => 'string',
            'due_date' => ['required','date',Rule::date()->afterOrEqual('now')],
            'time_tracked' => 'numeric',
            'status' => [Rule::enum(\App\Enums\StatusTodo::class)],
            'priority' => [Rule::enum(\App\Enums\PriorityTodo::class)],
        ]);
        $todo = new Todo();
        $todo->title = $validatedData['title'];
        $todo->assignee = $validatedData['assignee'] ?? null;
        $todo->due_date = $validatedData['due_date'];
        $todo->time_tracked = $validatedData['time_tracked'] ?? 0;
        $todo->status = $validatedData['status'] ?? \App\Enums\StatusTodo::Pending;
        $todo->priority = $validatedData['priority'] ?? \App\Enums\PriorityTodo::Medium;
        
        $todo->save();
        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todo::findOrFail($id);
        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string',
            'assignee' => 'sometimes|string',
            'due_date' => 'sometimes|required|date|after_or_equel:now',
            'time_tracked' => 'sometimes|numeric',
            'status' => [Rule::enum(\App\Enums\StatusTodo::class)],
            'priority' => [Rule::enum(\App\Enums\PriorityTodo::class)],
        ]);

        $todo->fill($validatedData);
        $todo->save();

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response()->json(null, 204);
    }
}
