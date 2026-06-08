<?php

namespace App\Http\Controllers\Task;

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\ActivityTask;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskStaffController extends Controller
{

    public function indexStaff(): View|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $tasks = Task::where('assign_to', Auth::id())
            ->with(['assignedTo', 'assignedBy'])
            ->paginate(50);

        return view('task.task-staff')->with('tasks', $tasks);
    }

    public function showReportStaff($taskId): View|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        if (Auth::user()->role == UserRole::STAFF) {
            $task = $this->getAssignedTask($taskId, Auth::id());

            if ($task == null) {
                return response()->view('unauthorized', [], 403);
            }
            $taskStatus = [TaskStatus::COMPLETED, TaskStatus::CANCELLED, TaskStatus::PENDING];
        }else {
            $task = Task::find($taskId);
            $taskStatus = TaskStatus::cases();
        }


        return view('task.task-staff-report', compact('taskStatus', 'taskId', 'task'));
    }

    public function storeReportStaff(Request $request, $taskId): RedirectResponse|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        if (Auth::user()->role == UserRole::STAFF) {
            $task = $this->getAssignedTask($taskId, Auth::id());

            if ($task == null) {
                return response()->view('unauthorized', [], 403);
            }
        }

        $validate = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048']
        ]);

        DB::transaction(function () use ($validate, $taskId, $request) {
            $task = Task::findOrFail($taskId);
            $task->status = $validate['status'];
            if ($validate['status'] == TaskStatus::COMPLETED->value || $validate['status'] == TaskStatus::CANCELLED->value) {
                $task->end_at = now();
            }
            $task->save();

            $activity = ActivityTask::create([
                'task_id' => $task->task_id,
                'title' => $validate['title'],
                'report_form' => Auth::id(),
                'description' => $validate['description'],
            ]);

            if ($request->hasFile('photos')) {
                $targetFolder = env('REPORT_PHOTO_FOLDER', 'reports');
                $evidences = [];
                foreach ($request->file('photos') as $photo) {
                    $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs($targetFolder, $filename, 'public');
                    $evidences[] = [
                        'task_activity_id' => $taskId,
                        'file_name' => $filename,
                        'file_path' => $targetFolder . '/' . $filename,
                    ];
                }
                $activity->taskEvidences()->createMany($evidences);
            }
        });

        if (Auth::user()->role == UserRole::STAFF) {
            return redirect()->route('task.staff');
        }else {
            return redirect()->route('task');
        }
    }

    private function getAssignedTask($taskId, $staffId): Task|null
    {
        return Task::where('assign_to', $staffId)
            ->where('task_id', $taskId)
            ->with(['assignedTo', 'assignedBy'])
            ->first();
    }

}
