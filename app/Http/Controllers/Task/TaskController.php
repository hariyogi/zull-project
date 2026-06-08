<?php

namespace App\Http\Controllers\Task;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $tasks = Task::with(['assignedTo', 'assignedBy'])->get();

        return view('task.task')->with('tasks', $tasks);
    }


    public function showReport()
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $dbCounts = Task::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $taskCounts = [];

        foreach (TaskStatus::cases() as $status) {
            $taskCounts[$status->value] = $dbCounts->get($status->value, 0);
        }

        return view('task.task-report', compact('taskCounts'));
    }


    public function showCreateTask(): View|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $staffs = User::where('role', 'STAFF')->get();

        return view('task.task-add')->with('staffs', $staffs);
    }

    public function showDetailTask(Request $request, $taskId): View|Response
    {

        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $task = Task::with(['assignedTo', 'assignedBy'])->findOrFail($taskId);

        $activity = ActivityTask::where('task_id', $taskId)
            ->withCount('taskEvidences')
            ->get();

        return view('task.task-detail')
            ->with('task', $task)
            ->with('activities', $activity);

    }

    public function showEvidences($activityTaskId): View
    {
        // Ambil data aktivitas dan kunci data evidences terkait
        $activity = ActivityTask::with(['taskEvidences'])->findOrFail($activityTaskId);

        return view('task.task-evidences', compact('activity'));
    }

    public function createTask(Request $request): RedirectResponse|Response
    {
        if (!Auth::check()) {
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
