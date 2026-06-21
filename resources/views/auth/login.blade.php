<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title') - Zull Logbook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col justify-center items-center p-4">

<div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 p-6 sm:p-8 w-full max-w-md">

    <p class="text-xl font-semibold text-slate-800 mb-6 text-center sm:text-left">Sistem LogBook Hotel</p>

    <div class="flex flex-col gap-4 w-full">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-2 text-sm">
                <div class="flex items-center mb-2 font-semibold text-red-900">
                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>Terjadi kesalahan :</span>
                </div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="flex flex-col gap-4" action="{{ route('login') }}" method="POST">
            @csrf

            <div>
                <label class="input-label mb-1.5 block" for="login-username">Username</label>
                <input name="username" type="text" required id="login-username"
                       class="input-field w-full"
                       placeholder="nama pengguna">
            </div>

            <div>
                <label class="input-label mb-1.5 block" for="password-field">Password</label>
                <input id="password-field" name="password" type="password" required
                       class="input-field w-full"
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary w-full mt-2">
                Login
            </button>
        </form>
    </div>
</div>

@yield('scripts')
</body>
</html>
