@props(['status'])

@php
    $colorClass = $status->color();
    $labelText = $status->label();
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
    {{-- Dot Kecil Indikator Warna --}}
    <span class="h-1.5 w-1.5 rounded-full current-color" style="background-color: currentColor;"></span>
    {{ $labelText }}
</span>
