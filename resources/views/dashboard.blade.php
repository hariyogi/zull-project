@extends('layouts.auth')

@section('title', 'Dashboard')

@php
    $user = Auth::user();
    $isAdmin = $user->role === 'ADMIN';
@endphp

@section('styles')
<style>
    :root {
        @if($isAdmin)
            --accent-color: #f59e0b;
            --accent-hover: #d97706;
            --accent-text: #0f172a;
        @else
            --accent-color: #3b82f6;
            --accent-hover: #2563eb;
            --accent-text: #ffffff;
        @endif
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-top: 24px;
        margin-bottom: 32px;
    }

    .info-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 14px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .role-badge {
        background-color: var(--accent-color);
        color: var(--accent-text);
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endsection

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">ZULL LOGBOOK</div>
        <h1 class="auth-title">Dashboard</h1>
        <p class="auth-subtitle">Selamat datang kembali di sistem logbook</p>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Nama</span>
            <span class="info-value">{{ $user->name }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Username</span>
            <span class="info-value">{{ $user->username }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $user->email }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Peran</span>
            <span class="role-badge">{{ $user->role }}</span>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-primary" style="--accent-color: #ef4444; --accent-hover: #dc2626; --accent-text: #ffffff;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Keluar dari Akun
        </button>
    </form>
</div>
@endsection
