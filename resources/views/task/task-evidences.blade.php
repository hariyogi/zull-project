@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="Bukti Aktivitas"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Tugas', 'url' => route('task')],
            ['label' => 'Detail', 'url' => route('task.detail', $activity->task_id)],
            ['label' => 'Bukti Gambar', 'url' => '']
        ]"
    />
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        {{-- Header Informasi Aktivitas --}}
        <div class="mb-6 border-b border-slate-100 pb-4">
            <h1 class="text-xl font-bold text-slate-800">{{ $activity->title }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $activity->description }}</p>
            <span class="text-xs text-slate-400 block mt-2">
            Diunggah pada: {{ $activity->created_at->format('d M Y, H:i') }}
        </span>
        </div>

        {{-- Grid Menampilkan Gambar --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @forelse($activity->taskEvidences as $evidence)
                <div class="group relative border border-slate-200 rounded-lg overflow-hidden bg-slate-50 shadow-xs hover:shadow-md transition-shadow">
                    {{-- Komponen Gambar --}}
                    <img
                        src="{{ asset('storage/' . $evidence->file_path) }}"
                        alt="{{ $evidence->file_name }}"
                        class="w-full h-48 object-cover cursor-zoom-in group-hover:scale-105 transition-transform duration-200"
                        onclick="openModal(this.src)"
                    >
                    <div class="p-2 bg-white text-xs border-t border-slate-100 truncate text-slate-600" title="{{ $evidence->file_name }}">
                        {{ $evidence->file_name }}
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                    <i class="fa-regular fa-image text-slate-300 text-4xl mb-2 block"></i>
                    <p class="text-sm text-slate-500">Tidak ada bukti gambar yang dilampirkan pada aktivitas ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Lightbox / Modal Pop-up (Tersembunyi secara default) --}}
    <div id="imageModal" class="fixed inset-0 bg-slate-900/80 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-3xl hover:text-slate-300 cursor-pointer">&times;</button>
        <div class="max-w-4xl max-h-[85vh]">
            <img id="modalImage" src="" class="rounded-lg max-w-full max-h-[85vh] object-contain shadow-2xl">
        </div>
    </div>

    {{-- Script Sederhana untuk Mengaktifkan Modal --}}
    <script>
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.classList.remove('hidden');
            modalImg.src = src;
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }

        // Menutup modal jika area luar gambar di klik
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if(e.target === this) closeModal();
        });
    </script>
@endsection
