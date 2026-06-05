@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')
    <div class="flex flex-col gap-4 min-w-xl">
        @if($errors->any())
            <div class="alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form class="flex flex-col gap-4" action="{{ url('/login/admin') }}" method="POST">
            @csrf

            <div>
                <label class="input-label" for="username-field">Username</label>
                <input id="username-field" name="username" type="text" required id="login-username"
                    class="input-field"
                    placeholder="nama pengguna">
            </div>

            <div>
                <label class="input-label" for="password-field">Password</label>
                <input id="password-field" name="password" type="password" required
                    class="input-field"
                    placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary w-full">
                Masuk sebagai Admin
            </button>
        </form>

        <p class="text-center">Bukan Admin ? <a href="{{ route('login.staff') }}"
                class="text-blue-500 hover:text-blue-700">Login sebagai Staff</a></p>
    </div>
@endsection