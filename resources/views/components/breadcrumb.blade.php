@props([
    'page_title',
    'items' => [] // Menerima array data breadcrumb
])

<nav class="flex text-slate-500 text-sm font-medium gap-4" aria-label="Breadcrumb">
    <p>{{$page_title}}</p>
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        @foreach($items as $item)
            <li class="inline-flex items-center">
                {{-- Tampilkan separator ">" untuk semua item kecuali yang pertama --}}
                @if(!$loop->first)
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400 mx-2"></i>
                @endif

                {{-- Cek apakah item memiliki URL --}}
                @if(!empty($item['url']))
                    <a href="{{ $item['url'] }}" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-slate-400 cursor-default">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
