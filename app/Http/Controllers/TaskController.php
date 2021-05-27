<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

use App\Http\Controllers\TaskController;

use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return Response::json($tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $task = Task::create($request->all());

        if(!$task) {
            return Response::json([
                'message' => 'Task not created'
            ], 401);
        }

        return Response::json([
            'message' => 'Task has been created',
            'task' => $task
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if(!$task){
            return Response::json([
                'message' => 'Task not found'
            ], 400);
        }

        return Response::json([
            'message' => 'Task fouond',
            $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        if(!$task){
            return Response::json([
                'message' => 'Task not updated',
            ], 400);
        }
            
        $task->update($request->all());
        return Response::json([
            'message' => 'Task updated',
            'task' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if(!$task){
           return Response::json([
                'message' => 'Task was not deleted'
           ], 400);
        }

        Task::destroy($id);
        return Response::json([
            'message' => 'Task has been deleted'
        ], 200);
    }
}
