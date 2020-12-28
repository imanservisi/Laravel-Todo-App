<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        $query = $slug ? User::whereSlug($slug)->firstOrFail()->tasks() : Task::query();
        $users = $query->oldest('email');
        $tasks = Task::all();
        return view('tasks.index', compact('tasks', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:500',
        ]);
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->userid = $request->userid;
        $task->attributedat = $request->attributedat;
        $task->save();
        return redirect('/tasks')->with('message', "La tâche a bien été créée !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:500',
        ]);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->userid = $request->userid;
        $task->attributedat = $request->attributedat;
        $task->done = $request->has('done');
        $task->save();
        return redirect('/tasks')->with('message', "La tâche a bien été modifiée !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }
}
