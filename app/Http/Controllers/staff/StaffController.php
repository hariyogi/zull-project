<?php

namespace App\Http\Controllers\staff;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StaffController extends Controller
{

    public function index(): View|Response
    {
        $staffs = User::where('role', 'STAFF')->paginate(50);

        return view('staff.staff', compact('staffs'));
    }

    public function showCreateStaff(): View|Response
    {
        return view('staff.staff-add');
    }

    public function showEditStaff($staffId): View|Response
    {
        $staff = User::find($staffId);

        return view('staff.staff-edit', compact('staff'));
    }

    public function showDetailStaff($staffId): View|Response
    {
        $staff = User::findOrFail($staffId);

        return view('staff.staff-detail', compact('staff'));
    }

    public function showChangePasswordStaff($staffId): View|Response
    {
        $staff = User::findOrFail($staffId);

        return view('staff.staff-change-pass', compact('staff', 'staffId'));
    }

    public function saveStaff(Request $request): RedirectResponse|Response
    {
        $input = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8|max:50'
        ]);

        $input['role'] = UserRole::STAFF;
        $input['password'] = bcrypt($input['password']);
        $input['email'] = "{$input['username']}@logbook.com";
        User::create($input);
        return response()->redirectToRoute('staff');
    }

    public function changePasswordStaff(Request $request, $staffId): RedirectResponse|Response
    {
        $staff = User::where('role', UserRole::STAFF)
            ->where('id', $staffId)
            ->firstOrFail();

        $input = $request->validate([
            'password' => 'required|string|confirmed|min:8|max:50'
        ]);
        $password = bcrypt($input['password']);
        $staff->password = $password;
        $staff->save();
        return response()->redirectToRoute('staff.detail', ['staffId' => $staffId]);
    }

    public function editStaff(Request $request, $staffId): RedirectResponse|Response
    {
        $staff = User::where('role', 'STAFF')->findOrFail($staffId);

        $validated = $request->validate([
            // Username harus unik di tabel users, kecuali untuk ID milik staff ini sendiri
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($staff->id)],
            'name'     => ['required', 'string', 'max:150'],
        ]);

        $staff->update([
            'username' => $validated['username'],
            'name'     => $validated['name'],
        ]);

        return redirect()->route('staff.detail', $staffId)->with('success', 'Data staff berhasil diperbarui!');
    }
}
