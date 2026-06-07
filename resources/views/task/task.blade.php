@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="List Tugas"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Tugas', 'url' => '']
        ]"
    />
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-end">
            <p class="input-label mb-0">List Tugas</p>
            <a href={{ route('task.create') }}>
                <button class="btn-primary">
                    Tambah Task
                </button>
            </a>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                    <tr
                        class="bg-slate-50/75 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6">Judul</th>
                        <th class="py-4 px-6">Deskripsi</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Petugas</th>
                        <th class="py-4 px-6">Pelapor</th>
                        <th class="py-4 px-6">Tanggal Mulai</th>
                        <th class="py-4 px-6">Tanggal Selesai</th>
                        <th class="py-4 px-6">Tanggal Dibuat</th>
                        <th class="py-4 px-6">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td class="py-4 px-6">{{ $task->title }}</td>
                            <td class="py-4 px-6">{{ $task->description }}</td>
                            <td class="py-4 px-6">
                                <x-task-status-chip :status="$task->status" />
                            </td>
                            <td class="py-4 px-6">{{ $task->assignedTo->name }}</td>
                            <td class="py-4 px-6">{{ $task->assignedBy->name }}</td>
                            <td class="py-4 px-6">{{ $task->start_at }}</td>
                            <td class="py-4 px-6">{{ $task->end_at }}</td>
                            <td class="py-4 px-6">{{ $task->created_at }}</td>
                            <td class="py-4 px-6 flex gap-2">
                                <a href="{{route('task.detail', $task->task_id)}}" title="Lihat Detail Task">
                                    <button class="border rounded-sm border-slate-300 hover:bg-slate-100 py-1 pl-2 pr-2.5 cursor-pointer">
                                        <i class="fa-regular fa-eye text-slate-400 w-4"></i>
                                    </button>
                                </a>
                            </td>
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
@endsection
