<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title') - Zull Logbook</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="bg-slate-100 flex flex-col gap-4 justify-center items-center w-full h-screen">
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 p-6 sm:p-8">
            <p class="mb-8">Sistem LogBook Hotel</p>
            @yield('content')
        </div>
        <div class="auth-footer">
            &copy; {{ date('Y') }} Zull Logbook. All rights reserved.
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
