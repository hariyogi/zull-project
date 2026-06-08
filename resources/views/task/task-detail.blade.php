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
            <p class="input-label">Aktivitas Tugas</p>
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                        <tr
                            class="bg-slate-50/75 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">Judul Aktivitas</th>
                            <th class="py-4 px-6">Deskripsi</th>
                            <th class="py-4 px-6">Bukti</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td class="py-4 px-6">{{ $activity->title }}</td>
                                <td class="py-4 px-6">{{ $activity->description }}</td>
                                <td class="py-4 px-6 flex gap-2 items-center">
                                    @if($activity->task_evidences_count > 0)
                                        <p>Ada {{ $activity->task_evidences_count }} bukti gambar</p>
                                        <a href="{{route('task.activity.evidences', $activity->activity_task_id)}}" title="Lihat Bukti">
                                            <button class="border rounded-sm border-slate-300 hover:bg-slate-100 py-1 pl-2 pr-2.5 cursor-pointer">
                                                <i class="fa-regular fa-eye text-slate-400 w-4"></i>
                                            </button>
                                        </a>
                                    @else
                                        <p>Tidak ada</p>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-8">Tidak ada data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
