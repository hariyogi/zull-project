@php use App\Enums\UserRole; @endphp
@extends('layouts.dashboard')

@section('breadcrumb')
    @if(auth()->user()->role == UserRole::STAFF)
        <x-breadcrumb
            page_title="Laporan Tugas"
            :items="[
                ['label' => 'Home', 'url' => route('dashboard')],
                ['label' => 'Tugas', 'url' => route('task.staff')],
                ['label' => 'Laporan', 'url' => '']
            ]"
        />
    @else
        <x-breadcrumb
            page_title="Laporan Tugas"
            :items="[
                ['label' => 'Home', 'url' => route('dashboard')],
                ['label' => 'Tugas', 'url' => route('task')],
                ['label' => 'Detail', 'url' => route('task.detail', $task->task_id)],
                ['label' => 'Laporan', 'url' => '']
            ]"
        />
    @endif
@endsection

@section('content')
    <div>
        <div class="mb-6 border-b border-slate-100">
            <h1 class="text-xl font-bold text-slate-800">{{ $task->title }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $task->description }}</p>
            <span class="text-xs text-slate-400 block mt-2">
            Pelapor: {{ $task->assignedBy->name }}
        </span>
        </div>
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-5 text-sm">
                <div class="flex items-center mb-2 font-semibold text-red-900">
                    <svg class="w-5 height-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
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
        <form action="{{ route('task.staff.report.store', $taskId) }}" method="post"
              class="flex flex-col gap-4 bg-white rounded-xl shadow-sm border border-slate-200 p-6"
              enctype="multipart/form-data">
            @csrf
            <div>
                <label class="input-label" for="title">Judul Laporan</label>
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
                <label class="input-label" for="description">Deskripsi Laporan</label>
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
                <label class="input-label" for="status">Status</label>
                <select
                    name="status"
                    id="status"
                    required
                    class="input-field"
                >
                    <option value="" disabled>--- Pilih Status ---</option>
                    @foreach ($taskStatus as  $item)
                        <option value="{{$item->name}}">{{$item->label()}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="input-label" for="photos">Foto Bukti (Bisa pilih lebih dari 1)</label>
                <input
                    name="photos[]"
                    id="photos"
                    type="file"
                    multiple
                    accept="image/*"
                    class="input-field py-1.5"
                />
                <p class="text-xs text-slate-400 mt-1">Format: JPG, JPEG, PNG.</p>
            </div>
            <input type="submit" class="btn-primary" value="Laporkan"/>
        </form>
    </div>
@endsection
