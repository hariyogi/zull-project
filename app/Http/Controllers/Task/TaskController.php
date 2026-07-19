<?php

namespace App\Http\Controllers\Task;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TaskController extends Controller
{
    public function index(Request $request): View|Response
    {
        $query = Task::with(['assignedTo', 'assignedBy']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tasks = $query->latest()->paginate(10)->appends($request->query());

        return view('task.task')->with('tasks', $tasks);
    }

    public function downloadExcel(Request $request): StreamedResponse
    {
        $query = Task::with(['assignedTo', 'assignedBy']);

        // Terapkan filter rentang waktu
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tasks = $query->latest()->get();

        // Ubah ekstensi menjadi .xlsx
        $fileName = 'Laporan_Tugas_' . now()->format('Ymd_His') . '.xlsx';

        // Inisialisasi file Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Buat Judul Kolom (Baris 1)
        $headers = [
            'A1' => 'Judul Tugas',
            'B1' => 'Deskripsi',
            'C1' => 'Status',
            'D1' => 'Petugas (Assigned To)',
            'E1' => 'Pelapor (Assigned By)',
            'F1' => 'Tanggal Mulai',
            'G1' => 'Tanggal Selesai',
            'H1' => 'Tanggal Dibuat',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            // Cetak tebal (bold) untuk header
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        // 2. Isi Data dari Database (Mulai dari Baris 2)
        $row = 2;
        foreach ($tasks as $task) {
            $sheet->setCellValue('A' . $row, $task->title);
            $sheet->setCellValue('B' . $row, $task->description);
            $sheet->setCellValue('C' . $row, $task->status->value ?? $task->status);
            $sheet->setCellValue('D' . $row, $task->assignedTo->name ?? '-');
            $sheet->setCellValue('E' . $row, $task->assignedBy->name ?? '-');
            $sheet->setCellValue('F' . $row, $task->start_at ? $task->start_at : '-');
            $sheet->setCellValue('G' . $row, $task->end_at ? $task->end_at : '-');
            $sheet->setCellValue('H' . $row, $task->created_at);
            $row++;
        }

        // (Opsional) Sesuaikan lebar kolom otomatis
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 3. Buat response stream untuk download
        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        // Set header khusus untuk format .xlsx
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }


    public function showReport()
    {
        // Asumsi $taskCounts Anda sebelumnya
        $taskCounts = Task::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // 1. Data Line Chart (Task Harian - 30 Hari Terakhir)
        $dailyTasks = Task::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $lineChartLabels = $dailyTasks->pluck('date')->toArray();
        $lineChartData = $dailyTasks->pluck('total')->toArray();

        // 2. Data Pie Chart (Status Task)
        $pieChartLabels = [];
        $pieChartData = [];
        $pieChartColors = [];

        // Mapping warna hex yang senada dengan Tailwind enum Anda
        $colorMap = [
            'READY' => '#f1f5f9',       // slate-100
            'PENDING' => '#fffbeb',     // amber-50
            'IN_PROGRESS' => '#eff6ff', // blue-50
            'COMPLETED' => '#ecfdf5',   // emerald-50
            'CANCELLED' => '#fff1f2',   // rose-50
        ];
        $borderMap = [
            'READY' => '#e2e8f0',       // slate-200
            'PENDING' => '#fde68a',     // amber-200
            'IN_PROGRESS' => '#bfdbfe', // blue-200
            'COMPLETED' => '#a7f3d0',   // emerald-200
            'CANCELLED' => '#fecdd3',   // rose-200
        ];

        foreach(TaskStatus::cases() as $status) {
            $pieChartLabels[] = $status->label();
            $pieChartData[] = $taskCounts[$status->value] ?? 0;
            $pieChartColors['background'][] = $colorMap[$status->value];
            $pieChartColors['border'][] = $borderMap[$status->value];
        }

        // 3. Data Bar Chart (Task per Petugas)
        $staffTasks = Task::select('assign_to', DB::raw('count(*) as total'))
            ->with('assignedTo')
            ->groupBy('assign_to')
            ->get();

        $barChartLabels = $staffTasks->map(fn($task) => $task->assignedTo->name ?? 'Unknown')->toArray();
        $barChartData = $staffTasks->pluck('total')->toArray();

        return view('task.task-report', compact(
            'taskCounts',
            'lineChartLabels', 'lineChartData',
            'pieChartLabels', 'pieChartData', 'pieChartColors',
            'barChartLabels', 'barChartData'
        ));
    }
//    {
//        $dbCounts = Task::select('status', DB::raw('count(*) as total'))
//            ->groupBy('status')
//            ->pluck('total', 'status');
//
//        $taskCounts = [];
//
//        foreach (TaskStatus::cases() as $status) {
//            $taskCounts[$status->value] = $dbCounts->get($status->value, 0);
//        }
//
//        return view('task.task-report', compact('taskCounts'));
//    }


    public function showCreateTask(): View|Response
    {
        $staffs = User::where('role', 'STAFF')->get();

        return view('task.task-add')->with('staffs', $staffs);
    }

    public function showUpdateTask($taskId): View|Response
    {
        $task = Task::findOrFail($taskId);

        $staffs = User::where('role', 'STAFF')->get();
        $taskStatus = TaskStatus::cases();

        return \view('task.task-edit', compact('taskStatus', 'taskId', 'staffs', 'task'));
    }

    public function showDetailTask(Request $request, $taskId): View|Response
    {
        $task = Task::with(['assignedTo', 'assignedBy'])->findOrFail($taskId);

        $activity = ActivityTask::where('task_id', $taskId)
            ->withCount('taskEvidences')
            ->get();

        return view('task.task-detail')
            ->with('task', $task)
            ->with('activities', $activity);

    }

    public function showEvidences($activityTaskId): View
    {
        // Ambil data aktivitas dan kunci data evidences terkait
        $activity = ActivityTask::with(['taskEvidences'])->findOrFail($activityTaskId);

        return view('task.task-evidences', compact('activity'));
    }

    public function createTask(Request $request): RedirectResponse|Response
    {
        $validate = $request->validate([
            'assign_to' => ['required', 'exists:users,id'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);


        $is_staff = User::where('id', $validate['assign_to'])
            ->where('role', 'STAFF')
            ->exists();

        if (!$is_staff) {
            return back()->withErrors([
                'any_error' => 'Hanya staff yang bisa ditugaskan'
            ])->withInput();
        }


        $validate['assign_by'] = Auth::id();
        $validate['status'] = TaskStatus::IN_PROGRESS;
        $validate['start_at'] = now();

        DB::transaction(function () use ($validate) {
            $task = Task::create($validate);

            // Simpan Activity
            ActivityTask::create([
                'task_id' => $task->task_id,
                'title' => 'Pembuatan Task',
                'report_form' => Auth::id(),
                'description' => 'Task berhasil dibuat'
            ]);
        });

        return redirect()->route('task');
    }

    public function updateTask(Request $request, $taskId): RedirectResponse|Response
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'assign_to'   => ['required', 'exists:users,id'],
            'status'      => ['required', Rule::enum(TaskStatus::class)],
        ]);

        // 3. Cari Data Task Berdasarkan ID
        $task = Task::findOrFail($taskId);

        // 4. Update Properti Utama
        $task->title       = $validated['title'];
        $task->description = $validated['description'];
        $task->assign_to   = $validated['assign_to'];
        $task->status      = $validated['status'];

        if ($task->status === TaskStatus::IN_PROGRESS && is_null($task->start_at)) {
            $task->start_at = now();
        }

        if ($task->status === TaskStatus::COMPLETED || $task->status === TaskStatus::CANCELLED) {
            if (is_null($task->start_at)) {
                $task->start_at = now();
            }
            $task->end_at = now();
        } else {
            $task->end_at = null;
        }

        DB::transaction(function () use ($task) {
            $task->save();

            ActivityTask::create([
                'task_id' => $task->task_id,
                'title' => 'Update Task',
                'report_form' => Auth::id(),
                'description' => 'Update task'
            ]);
        });

        return redirect()->route('task.detail', $taskId)->with('success', 'Tugas berhasil diperbarui!');
    }
}
