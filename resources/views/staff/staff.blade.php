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
                        <th class="py-4 px-6">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($staffs as $staff)
                        <tr>
                            <td class="py-4 px-6">{{ $staff->name }}</td>
                            <td class="py-4 px-6">{{ $staff->username }}</td>
                            <td class="py-4 px-6">
                                <a href="{{route('staff.detail', $staff->id)}}" title="Lihat Detail Staff">
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
                {{ $staffs->links() }}
            </div>
        </div>
    </div>
@endsection
