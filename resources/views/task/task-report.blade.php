@php use App\Enums\TaskStatus; @endphp
@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="Laporan Tugas"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Laporan', 'url' => '']
        ]"
    />
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div>
            <p class="input-label mb-3">Laporan Tugas</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach(TaskStatus::cases() as $status)
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                        <p class="text-sm font-medium text-slate-500 truncate" title="{{ $status->label() }}">
                            {{ $status->label() }}
                        </p>
                        <p class="text-2xl font-bold text-slate-800 mt-1">
                            {{ $taskCounts[$status->value] ?? 0 }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Section Grafik -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
            <!-- 1. Line Chart (Grafik Harian) -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm lg:col-span-2">
                <p class="text-sm font-semibold text-slate-700 mb-4">Total Tugas Harian</p>
                <div class="relative h-72 w-full">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <!-- 2. Pie Chart (Grafik Status) -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <p class="text-sm font-semibold text-slate-700 mb-4">Distribusi Status Tugas</p>
                <div class="relative h-72 w-full flex justify-center">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <!-- 3. Bar Chart (Grafik Per Petugas) -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm lg:col-span-3">
                <p class="text-sm font-semibold text-slate-700 mb-4">Total Tugas per Petugas</p>
                <div class="relative h-80 w-full">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Setup Line Chart (Tugas Harian)
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: @json($lineChartLabels),
                    datasets: [{
                        label: 'Jumlah Tugas',
                        data: @json($lineChartData),
                        borderColor: '#0284c7', // sky-600
                        backgroundColor: 'rgba(2, 132, 199, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // 2. Setup Pie Chart (Status Tugas)
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($pieChartLabels),
                    datasets: [{
                        data: @json($pieChartData),
                        backgroundColor: @json($pieChartColors['background']),
                        borderColor: @json($pieChartColors['border']),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // 3. Setup Bar Chart (Tugas per Petugas)
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: @json($barChartLabels),
                    datasets: [{
                        label: 'Total Tugas',
                        data: @json($barChartData),
                        backgroundColor: '#38bdf8', // sky-400
                        borderColor: '#0284c7',     // sky-600
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });
        });
    </script>
@endsection
