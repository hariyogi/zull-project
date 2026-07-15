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

        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <form action="{{ route('task') }}" method="GET" class="flex flex-wrap items-end gap-3 w-full md:w-auto">
                <div>
                    <label for="start_date" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ request('start_date') }}"
                        class="border border-slate-300 rounded-md px-3 py-1.5 text-sm text-slate-700 focus:outline-sky-600 bg-slate-50"
                    >
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        value="{{ request('end_date') }}"
                        class="border border-slate-300 rounded-md px-3 py-1.5 text-sm text-slate-700 focus:outline-sky-600 bg-slate-50"
                    >
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white text-sm px-4 py-2 rounded-md font-medium cursor-pointer transition-colors">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                    @if(request()->filled('start_date') || request()->filled('end_date'))
                        <a href="{{ route('task') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm px-4 py-2 rounded-md font-medium transition-colors flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- Tombol Unduh / Download Excel --}}
            <div class="shrink-0">
                <a href="{{ route('task.download', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-4 py-2 rounded-md font-medium inline-flex items-center gap-2 transition-colors cursor-pointer shadow-xs">
                    <i class="fa-regular fa-file-excel text-base"></i>
                    <span>Download Excel</span>
                </a>
            </div>
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
                            <td colspan="10" class="text-center py-8">Tidak ada data</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
@endsection
