<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard - Zull Logbook</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="bg-slate-100 min-h-screen w-full overflow-hidden">
    <div class="flex border-collapse">
        <div class="bg-white px-6 py-3 w-64 border border-slate-200">
            <p class="text-2xl text-blue-900 font-bold text-center">LogBook</p>
        </div>
        <div class="grow bg-white border border-slate-200">

        </div>
    </div>
    <div class="flex gap-2 h-screen">
        <nav class="bg-white w-64 p-6">
            <ul class="flex flex-col gap-4">
                <li><a href={{ route('task') }} class="text-gray-700 hover:text-gray-900">Task</a></li>
            </ul>
        </nav>
        <div class="p-4 w-full">
            <div class="mb-4">
                @yield('breadcrumb')
            </div>
            @yield('content')
        </div>
    </div>
    @yield('scripts')
</body>

</html>