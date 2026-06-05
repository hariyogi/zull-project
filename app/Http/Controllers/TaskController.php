<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View|Response
    {
        if (! Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $tasks = Task::all();

        return view('task.task')->with('tasks', $tasks);
    }

    public function showCreateTask(): View|Response
    {
        if (! Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $staffs = User::where('role', 'STAFF')->get();

        return view('task.task-add')->with('staffs', $staffs);
    }

    public function createTask(Request $request): RedirectResponse|Response 
    {
        dd($request);
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
        $validate['status'] = 'IN_PROGRESS';
        $validate['start_at'] = now();

        Task::create($validate);

        return redirect()->route('task');
    }
}