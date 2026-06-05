<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showAdminLoginForm(): View
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return view('auth.admin-login');
    }

    /**
     * Show the staff login form.
     */
    public function showStaffLoginForm(): View
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return view('auth.staff-login');
    }

    /**
     * Handle an admin authentication attempt.
     */
    public function loginAdmin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials['role'] = 'ADMIN';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Kredensial login admin tidak cocok atau Anda bukan Admin.',
        ])->onlyInput('username');
    }

    /**
     * Handle a staff authentication attempt.
     */
    public function loginStaff(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials['role'] = 'STAFF';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Kredensial login staff tidak cocok atau Anda bukan Staff.',
        ])->onlyInput('username');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        $role = Auth::user()?->role;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect back to the corresponding login page based on role
        if ($role === 'ADMIN') {
            return redirect('/login/admin');
        }

        return redirect('/login/staff');
    }
}
