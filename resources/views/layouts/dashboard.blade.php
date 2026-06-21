@php use App\Enums\UserRole; @endphp
    <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard - Zull Logbook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
</head>

<body class="bg-slate-100 h-screen w-full overflow-hidden flex" x-data="{ sidebarOpen: false }">

<div class="fixed inset-0 bg-slate-900/40 z-40 lg:hidden"
     x-show="sidebarOpen"
     @click="sidebarOpen = false"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-cloak>
</div>

<aside class="fixed inset-y-0 left-0 w-64 bg-sky-700 flex flex-col gap-4 shrink-0 h-full z-50 transform lg:translate-x-0 lg:relative transition-transform duration-300 ease-in-out"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="px-6 py-4 shadow-md flex items-center justify-between lg:justify-center h-14 bg-sky-800">
        <p class="text-2xl text-white font-bold tracking-wide">LOGBOOK</p>
        <button @click="sidebarOpen = false" class="text-white lg:hidden focus:outline-none">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <div class="px-6 py-3 border-b border-sky-600/50 lg:hidden bg-sky-800/40">
        <p class="text-xs text-sky-200">Selamat datang,</p>
        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
        <span class="inline-block mt-1 text-[10px] font-medium bg-sky-500 text-white px-2 py-0.5 rounded-full border border-sky-400">
                {{ auth()->user()->role->label() }}
            </span>
    </div>

    <nav class="flex-1 overflow-y-auto text-white">
        @if(auth()->user()->role == UserRole::ADMIN)
            <ul class="flex flex-col gap-1">
                <li>
                    <a href="{{route('dashboard')}}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-house text-base"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="text-sm px-4 py-2.5 mt-4 text-sky-200 font-semibold uppercase tracking-wider text-xs">Manajemen Tugas</li>
                <li>
                    <a href="{{route('task.report')}}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-chart-line text-base"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('task') }}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-list-check text-base"></i>
                        <span>Tugas</span>
                    </a>
                </li>
                <li class="text-sm px-4 py-2.5 mt-4 text-sky-200 font-semibold uppercase tracking-wider text-xs">Master Data</li>
                <li>
                    <a href="{{route('staff')}}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-user-group text-base"></i>
                        <span>Manajemen Staff</span>
                    </a>
                </li>
            </ul>
        @else
            <ul class="flex flex-col gap-1">
                <li>
                    <a href="{{route('dashboard')}}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-house text-base"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="text-sm px-4 py-2.5 mt-4 text-sky-200 font-semibold uppercase tracking-wider text-xs">Tugas Anda</li>
                <li>
                    <a href="{{ route('task.staff') }}"
                       class="flex items-center gap-3 pl-8 pr-4 py-2.5 text-sm font-medium hover:bg-slate-50 hover:text-blue-600 transition-all">
                        <i class="fa-solid fa-list-check text-base"></i>
                        <span>Tugas</span>
                    </a>
                </li>
            </ul>
        @endif
    </nav>
</aside>

<div class="flex-1 flex flex-col h-full overflow-hidden w-full">

    <header class="bg-white h-14 shadow-md flex items-center px-4 sm:px-6 justify-between shrink-0 gap-4">

        <div class="flex items-center gap-3 overflow-hidden">
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-600 lg:hidden p-1 focus:outline-none shrink-0">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <div class="text-sm font-medium text-slate-700 truncate hidden lg:block">
                Hai, <span class="font-semibold">{{auth()->user()->name}}</span>. (<span class="text-sky-600 text-xs bg-sky-50 px-2 py-0.5 rounded-full border border-sky-100">{{auth()->user()->role->label()}}</span>)
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-4 shrink-0">
            <div x-data="{
                        time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
                     }"
                 x-init="setInterval(() => {
                        time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
                     }, 1000)"
                 class="flex items-center gap-1.5 text-slate-600 bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs sm:text-sm"
            >
                <i class="fa-regular fa-clock text-sky-600"></i>
                <span x-text="time"></span>
            </div>

            <form action="{{route('logout')}}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-rose-600 hover:bg-rose-800 text-white text-xs sm:text-sm px-3 py-2 rounded transition-colors duration-200">
                    <i class="fa-solid fa-right-from-bracket sm:hidden"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 p-4 sm:p-6 overflow-y-auto">
        <div class="mb-5 overflow-x-auto">
            @yield('breadcrumb')
        </div>

        <section class="w-full">
            @yield('content')
        </section>
    </main>

</div>

@yield('scripts')
</body>
</html>
