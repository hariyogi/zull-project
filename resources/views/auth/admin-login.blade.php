@extends('layouts.auth')

@section('title', 'Login Admin')

@section('styles')
<style>
    :root {
        --accent-color: #f59e0b;
        --accent-hover: #d97706;
    }
</style>
@endsection

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">ZULL LOGBOOK</div>
        <h1 class="auth-title">Portal Admin</h1>
        <p class="auth-subtitle">Masuk untuk mengelola sistem logbook</p>
    </div>

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

    <form action="{{ url('/login/admin') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <div class="input-wrapper">
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-input" 
                    placeholder="Masukkan username Anda" 
                    value="{{ old('username') }}" 
                    required 
                    autofocus
                    autocomplete="username"
                >
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 28px;">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="••••••••" 
                    required
                    autocomplete="current-password"
                >
            </div>
        </div>

        <button type="submit" class="btn-primary">
            Masuk sebagai Admin
        </button>
    </form>

    <a href="{{ route('login.staff') }}" class="btn-secondary">
        Login sebagai Staff
    </a>
</div>
@endsection
