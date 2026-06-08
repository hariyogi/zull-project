<?php

namespace App\Http\Controllers\Task;

use App\Enums\TaskStatus;
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
            ->get();

        return view('task.task-staff')->with('tasks', $tasks);
    }

    public function showReportStaff($taskId): View|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $is_assigned = $this->isTaskAssignedTo($taskId, Auth::id());

        if (!$is_assigned) {
            return response()->view('unauthorized', [], 403);
        }

        $taskStatus = TaskStatus::cases();

        return view('task.task-staff-report', compact('taskStatus', 'taskId'));
    }

    public function storeReportStaff(Request $request, $taskId): RedirectResponse|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $is_assigned = $this->isTaskAssignedTo($taskId, Auth::id());

        if (!$is_assigned) {
            return response()->view('unauthorized', [], 403);
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

        return redirect()->route('task.staff');
    }

    private function isTaskAssignedTo($taskId, $staffId): bool
    {
        return Task::where('assign_to', $staffId)
            ->where('task_id', $taskId)
            ->exists();
    }

}
