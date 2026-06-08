@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="Menambahkan Staff"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Staff', 'url' => route('staff')],
            ['label' => 'Detail', 'url' => route('staff.detail', $staff->id)],
            ['label' => 'Edit', 'url' => '']
        ]"
    />
@endsection

@section('content')
    <div>
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-5 text-sm">
                <div class="flex items-center mb-2 font-semibold text-red-900">
                    <svg class="w-5 height-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>Terjadi kesalahan pengisian data:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('staff.edit.store', $staff->id) }}" method="post" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="input-label" for="username">Username</label>
                <input
                    name="username"
                    id="username"
                    type="text"
                    required
                    class="input-field"
                    value="{{ old('username', $staff->username) }}"
                />
            </div>
            <div>
                <label class="input-label" for="name">Nama</label>
                <input
                    name="name"
                    id="name"
                    type="text"
                    required
                    class="input-field"
                    value="{{ old('name', $staff->name) }}"
                />
            </div>
            <input type="submit" class="btn-primary" value="Edit Staff" />
        </form>
    </div>

@endsection
