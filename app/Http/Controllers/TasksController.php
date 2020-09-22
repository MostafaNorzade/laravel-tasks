<?php

namespace App\Http\Controllers;

use Auth;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TasksController extends Controller
{
    protected $rules = [
        'name' 		  => 'required|max:60',
        'description' => 'max:155',
        'completed'   => 'numeric',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('tasks.index', [
            'tasks' => $this->tasksOfUser($user)->get(),
            'tasksComplete' => $this->tasksOfUser($user)->hasActiveTempTags('complete')->get(),
            'tasksInComplete' => $this->tasksOfUser($user)->hasNotActiveTempTags('complete')->get(),
        ]);
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $task = $request->all();
        $task['user_id'] = Auth::id();
        Task::query()->create($task);

        return redirect('/tasks')->with('success', 'Task created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::query()->findOrFail($id);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $task = $this->saveTask($id, $request);

        $this->tagTaskCompletion(request('completed'), $task);

        return redirect('tasks')->with('success', 'Task Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::query()->findOrFail($id)->delete();

        return redirect('/tasks')->with('success', 'Task Deleted');
    }

    private function tasksOfUser($user)
    {
        return Task::query()->orderBy('created_at', 'asc')->where('user_id', $user->id);
    }

    private function saveTask(int $id, Request $request)
    {
        $task = Task::query()->findOrFail($id);
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->save();

        return $task;
    }

    private function tagTaskCompletion($completion, $task): void
    {
        if ($completion == '1') {
            tempTags($task)->tagIt('complete', Carbon::tomorrow()->startOfDay());
        } else {
            tempTags($task)->unTag('complete');
        }
    }
}
