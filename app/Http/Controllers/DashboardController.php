<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View|Response
    {
        if (! Auth::check()) {
            return response()->view('unauthorized', [], 403);
        }

        return view('dashboard');
    }
}
