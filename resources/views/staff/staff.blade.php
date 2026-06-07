@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="List Staff"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Staff', 'url' => '']
        ]"
    />
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-end">
            <p class="input-label mb-0">List Staff</p>
            <a href={{ route('staff.create') }}>
                <button class="btn-primary">
                    Tambah Staff
                </button>
            </a>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                    <tr
                        class="bg-slate-50/75 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6">Nama</th>
                        <th class="py-4 px-6">Username</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($staffs as $staff)
                        <tr>
                            <td class="py-4 px-6">{{ $staff->name }}</td>
                            <td class="py-4 px-6">{{ $staff->username }}</td>
                            <td class="py-4 px-6">{{ $staff->email }}</td>
                            <td class="py-4 px-6">
                                <div x-data="{open:false}" @click.outside="open = false">
                                    <button @click="open = !open"
                                            class="text-slate-400 hover:text-slate-700 p-2 rounded-lg hover:bg-slate-100 transition-all focus:outline-none">
                                        <i class="fa-solid fa-ellipsis-vertical text-base"></i>
                                    </button>

                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-2 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl z-50 p-2 text-left"
                                         style="display: none;">

{{--                                        <a href="{{route('task.detail', $task->task_id)}}">--}}
{{--                                            <button>--}}
{{--                                                <i class="fa-regular fa-eye text-slate-400 w-4"></i> Lihat Detail--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
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
