@extends('layouts.dashboard')

@section('breadcrumb')
    <p>Home > Task</p>
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <a href={{ route('task.create') }}>
            <button class="btn-primary">
                Tambah Task
            </button>
        </a>
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/75 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">Staff</th>
                            <th class="py-4 px-6">Judul</th>
                            <th class="py-4 px-6">Deskripsi</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Admin</th>
                            <th class="py-4 px-6">Tanggal Mulai</th>
                            <th class="py-4 px-6">Tanggal Selesai</th>
                            <th class="py-4 px-6">Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td class="py-4 px-6">{{ $task->user_id }}</td>
                                <td class="py-4 px-6">{{ $task->title }}</td>
                                <td class="py-4 px-6">{{ $task->description }}</td>
                                <td class="py-4 px-6">{{ $task->status }}</td>
                                <td class="py-4 px-6">{{ $task->assign_by }}</td>
                                <td class="py-4 px-6">{{ $task->start_at }}</td>
                                <td class="py-4 px-6">{{ $task->end_at }}</td>
                                <td class="py-4 px-6">{{ $task->created_at }}</td>
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