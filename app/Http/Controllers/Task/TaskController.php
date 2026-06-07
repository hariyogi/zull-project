<?php

namespace App\Http\Controllers\Task;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View|Response
    {
        if (! Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $tasks = Task::with(['assignedTo', 'assignedBy'])->get();

        return view('task.task')->with('tasks', $tasks);
    }

    public function showCreateTask(): View|Response
    {
        if (! Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $staffs = User::where('role', 'STAFF')->get();

        return view('task.taskadd')->with('staffs', $staffs);
    }

    public function showDetailTask(Request $request, $taskId): View|Response
    {

        if (! Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $task = Task::with(['assignedTo', 'assignedBy'])->findOrFail($taskId);

        $activity = ActivityTask::where('task_id', $taskId)
            ->get();

        return view('task.taskdetail')
            ->with('task', $task)
            ->with('activites', $activity);

    }

    public function createTask(Request $request): RedirectResponse|Response
    {
        if (! Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $validate = $request->validate([
            'assign_to' => ['required', 'exists:users,id'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);


        $is_staff = User::where('id', $validate['assign_to'])
        ->where('role', 'STAFF')
        ->exists();

        if (!$is_staff) {
            return back()->withErrors([
                'any_error' => 'Hanya staff yang bisa ditugaskan'
            ])->withInput();
        }


        $validate['assign_by'] = Auth::id();
        $validate['status'] = TaskStatus::IN_PROGRESS;
        $validate['start_at'] = now();

       DB::transaction(function () use ($validate) {
           $task = Task::create($validate);

           // Simpan Activity
           ActivityTask::create([
                'task_id' => $task->task_id,
                'title' => 'Pembuatan Task',
                'description' => 'Task berhasil dibuat'
           ]);
       });

        return redirect()->route('task');
    }
}
