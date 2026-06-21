@php use App\Enums\TaskStatus; @endphp
@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="Laporan Tugas"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Laporan', 'url' => '']
        ]"
    />
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div>
            <p class="input-label mb-3">Laporan Tugas</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach(TaskStatus::cases() as $status)
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                        <p class="text-sm font-medium text-slate-500 truncate" title="{{ $status->label() }}">
                            {{ $status->label() }}
                        </p>
                        <p class="text-2xl font-bold text-slate-800 mt-1">
                            {{ $taskCounts[$status->value] ?? 0 }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
