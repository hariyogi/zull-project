@extends('layouts.dashboard')

@section('breadcrumb')
    <p>Home > Task > Create</p>
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
        @error('any_error')
            <p>{{ $message }}</p>
        @enderror
        <form action="{{ route('task.store') }}" method="post" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="input-label" for="title">Judul Tugas</label>
                <input 
                    name="title"
                    id="title"
                    type="text"
                    required
                    class="input-field"
                    value="{{ old('title') }}"
                />
            </div>
            <div>
                <label class="input-label" for="description">Deskripsi Tugas</label>
                <input 
                    name="description"
                    id="description"
                    type="text"
                    required
                    class="input-field"
                    value="{{ old('description') }}"
                />
            </div>
            <div>
                <label class="input-label" for="assign_to">Di tugaskan ke</label>
                <select
                    name="assign_to"
                    id="assign_to"
                    required
                    class="input-field"
                >
                    <option value="" disabled>--- Pilih Staff ---</option>
                    @foreach ($staffs as  $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary">
                Simpan Task
            </button>
        </form>
    </div>

@endsection