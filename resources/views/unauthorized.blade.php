@extends('auth.login')

@section('title', 'Akses Ditolak')

@section('styles')
    <style>
        :root {
            --accent-color: #ef4444;
            --accent-hover: #dc2626;
            --accent-text: #ffffff;
        }

        .unauthorized-icon {
            width: 80px;
            height: 80px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px auto;
            color: #ef4444;
        }
    </style>
@endsection

@section('content')
    <div class="auth-card" style="text-align: center;">
        <div class="unauthorized-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
        </div>

        <div class="auth-header" style="margin-bottom: 24px;">
            <div class="auth-logo" style="color: var(--accent-color);">AKSES DITOLAK</div>
            <h1 class="auth-title">403 Unauthorized</h1>
            <p class="auth-subtitle" style="margin-top: 8px; line-height: 1.5;">
                Halaman dashboard hanya dapat diakses setelah Anda berhasil login ke dalam sistem. Silakan login
                kembali.
            </p>
        </div>

        <a href="{{ route('login') }}" class="btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 style="margin-right: 4px;">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                <polyline points="10 17 15 12 10 7"></polyline>
                <line x1="15" y1="12" x2="3" y2="12"></line>
            </svg>
            Login Kembali
        </a>
    </div>
@endsection
