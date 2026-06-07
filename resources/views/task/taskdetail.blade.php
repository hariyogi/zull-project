@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="Detail Tugas"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Tugas', 'url' => route('task')],
            ['label' => 'Detail', 'url' => ''] {{-- Kosongkan URL agar warnanya abu-abu/tidak aktif --}}
        ]"
    />
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div>
            <p class="input-label">Judul Tugas</p>
            <input
                type="text"
                disabled
                value="{{$task->title}}"
                class="input-field"
            >
        </div>
        <div>
            <p class="input-label">Deskripsi Aktivitas</p>
            <input
                type="text"
                disabled
                value="{{$task->description}}"
                class="input-field"
            >
        </div>
        <div>
            <p class="input-label">Dibuat oleh</p>
            <input
                type="text"
                disabled
                value="{{$task->assignedBy->name}}"
                class="input-field"
            >
        </div>
        <div>
            <p class="input-label">Ditugaskan kepada</p>
            <input
                type="text"
                disabled
                value="{{$task->assignedTo->name}}"
                class="input-field"
            >
        </div>
        <div>
            <p class="input-label">Aktivitas Task</p>
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                        <tr
                            class="bg-slate-50/75 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">Judul Aktivitas</th>
                            <th class="py-4 px-6">Deskripsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($activites as $activity)
                            <tr>
                                <td class="py-4 px-6">{{ $activity->title }}</td>
                                <td class="py-4 px-6">{{ $activity->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td>Tidak ada data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
