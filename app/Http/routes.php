<?php

use App\Task;
use Illuminate\Http\Request;

/* Three routes used to point to the URL */

// Display All Tasks
Route::get('/', function () {

    $tasks = Task::orderBy('created_at', 'asc')->get();

    return view('tasks', [
        'task' => $tasks
    ]);
});

// Add A New Task
Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',               //  Allow upto 255 characters and is required
    ]);

    //  If validation fails the user is redirected to the / URL
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    //  Create the task
    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');

});


// Delete An Existing Task
Route::delete('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();

    return redirect('/');
});