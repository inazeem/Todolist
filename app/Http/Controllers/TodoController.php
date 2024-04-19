<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $todos = Todo::all();
        $permissions = auth()->user()->jsPermissions();
        $roles = auth()->user()->roles;

        $todos = Todo::where('user_id', auth()->user()->id)->get();
        return inertia::render('Todos/Index',
            [
                'todos' => $todos,
                'can' => [

                    'view' => Auth::user()->can('view articles'),
                    'edit' => Auth::user()->can('edit articles'),
                    'delete' => Auth::user()->can('delete articles'),
                ]
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * Valiudate the task.
         * Store the todo
         * Redirect to the todos page
         */

        $todo = $request->validate([
            'task' =>'required|max:255',
        ]);
        $todo['user_id'] = $request->user()->id;
        $todo['is_done'] =  false;

        Todo::create($todo);

        return redirect('todos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        /**
         * Toggle the task status.
         * Update the task if it is done.
         * redirect to the todos page.
         */

        $todo->is_done = ($todo->is_done)? false : true;
        $todo->save();
        return redirect('todos');
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateTask(Request $request, Todo $todo)
    {
        /**
         * Toggle the task status.
         * Update the task if it is done.
         * redirect to the todos page.
         */

        $todo->task = $request->task;
        $todo->save();
        return redirect('todos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        /**
         * Delete the task from the database.
         * redirect to the todos page.
         */

        $todo->delete();
        return redirect('todos');
    }
}
