<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StaffController extends Controller
{

    public function index(): View|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $staffs = User::where('role', 'STAFF')->get();

        return view('staff.staff', compact('staffs'));
    }

    public function showCreateStaff(): View|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        return view('staff.staff-add');
    }

    public function saveStaff(Request $request): RedirectResponse|Response
    {
        if (!Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        $input = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8|max:50'
        ]);

        $input['role'] = 'STAFF';
        $input['password'] = bcrypt($input['password']);
        $input['email'] = "{$input['username']}@logbook.com";
        User::create($input);
        return response()->redirectToRoute('staff');
    }
}
