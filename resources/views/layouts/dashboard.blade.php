@php use App\Enums\UserRole; @endphp
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
</head>

<body class="bg-slate-100 h-screen w-full overflow-hidden flex">

<aside class="w-64 bg-sky-700 flex flex-col gap-4 shrink-0 h-full">
    <div class="px-6 py-4 shadow-md flex items-center justify-center h-14">
        <p class="text-2xl text-white font-bold tracking-wide">LOGBOOK</p>
    </div>

    <nav class="flex-1 overflow-y-auto text-white">
        @if(auth()->user()->role == UserRole::ADMIN)
            <ul class="flex flex-col gap-1">
                <li class="text-sm px-4 py-2.5">
                    <a href="{{route('dashboard')}}">
                        Home
                    </a>
                </li>
                <li class="text-sm px-4 py-2.5">Manajemen Tugas</li>
                <li>
                    <a href="{{route('task.report')}}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium  hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-chart-line text-base"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('task') }}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium  hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-list-check text-base"></i>
                        <span>Tugas</span>
                    </a>
                </li>
                <li class="text-sm px-4 py-2.5 mt-4">Master Data</li>
                <li>
                    <a href="{{route('staff')}}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium  hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-user-group text-base"></i>
                        <span>Manjemen Staff</span>
                    </a>
                </li>
            </ul>
        @else
            <ul class="flex flex-col gap-1">
                <li class="text-sm px-4 py-2.5">
                    <a href="{{route('dashboard')}}">
                        Home
                    </a>
                </li>
                <li class="text-sm px-4 py-2.5">Tugas Anda</li>
                <li>
                    <a href="{{ route('task.staff') }}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium  hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-list-check text-base"></i>
                        <span>Tugas</span>
                    </a>
                </li>
            </ul>
        @endif
    </nav>
</aside>

<div class="flex-1 flex flex-col h-full overflow-hidden">

    <header class="bg-white h-14 shadow-md flex items-center px-6 justify-between shrink-0">
        <div class="flex gap-2 text-sm font-medium items-center">
            <p>Hai, {{auth()->user()->name}}. Anda login sebagai {{auth()->user()->role->label()}}</p>
            <div x-data="{
                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
            }"
                 x-init="setInterval(() => {
                time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
            }, 1000)"
                 class="flex items-center gap-2 text-slate-600 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200"
            >
                <i class="fa-regular fa-clock text-sky-600"></i>
                <span x-text="time"></span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-600 hover:bg-rose-800 text-white text-sm px-3 py-2 rounded-sm">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 p-6 overflow-y-auto">
        <div class="mb-5">
            @yield('breadcrumb')
        </div>

        <section>
            @yield('content')
        </section>
    </main>

</div>

@yield('scripts')
</body>

</html>
