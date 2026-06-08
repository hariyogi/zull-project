<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Butuh jasa implentasi ide ke sistem software ?. Bisa hubungi hariyogi.vercel.app -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title') - Zull Logbook</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<div class="bg-slate-100 flex flex-col gap-4 justify-center items-center w-full h-screen">
    <div
        class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 p-6 sm:p-8">
        <p class="mb-8">Sistem LogBook Hotel</p>
        <div class="flex flex-col gap-4 min-w-xl">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-5 text-sm">
                    <div class="flex items-center mb-2 font-semibold text-red-900">
                        <svg class="w-5 height-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                    <label class="input-label" for="login-username">Username</label>
                    <input name="username" type="text" required id="login-username"
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
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

@yield('scripts')
</body>
</html>
