<?php

namespace App\Http\Controllers\SystemMonitoring;

use App\Http\Controllers\Controller;
use App\Models\SysLog\UserActivityLog;
use App\Models\SystemBackup\BackupSchedule;
use App\Models\SystemBackup\DataBackup;
use App\Models\UserManagement\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SystemMonitoringController extends Controller
{
    public function index()
    {

        $active_users = User::with([
            'UserRole',
            'UserRegistration',
            'TechnicianRegistration',
        ])->get()->map(function ($user) {
            $lastLog = UserActivityLog::query()->where('user_iduser', $user->iduser)->latest('login_time')->first();
            $user->login_time = $lastLog?->login_time;
            $user->logout_time = $lastLog?->logout_time;
            $user->ip_address = $lastLog?->ip_address ?? 'N/A';
            $user->device = $lastLog?->device ?? 'N/A';
            $user->is_online = $lastLog && $lastLog->logout_time == null;

            return $user;
        });

        // Get only the latest backup per category
        $backups = DataBackup::query()->orderBy('backup_date', 'desc')->get();
        $schedules = BackupSchedule::query()->get();

        return view('users.components.system_monitoring', [
            'title' => 'System Monitoring',
            'active_users' => $active_users,
            'backups' => $backups,
            'schedules' => $schedules,
        ]);
    }

    public function forceLogout(int $id)
{
    $log = UserActivityLog::query()
        ->where('user_iduser', $id)
        ->whereNull('logout_time')
        ->latest('login_time')
        ->first();

    if ($log) {

        //  destroy session
        if ($log->session_id) {
            $sessionPath = storage_path('framework/sessions/'.$log->session_id);
            if (file_exists($sessionPath)) {
                unlink($sessionPath);
            }
        }

        $log->update(['logout_time' => now()]);
    }

    return back()->with('success', 'User forcibly logged out!');
}

    public function backup(Request $request)
    {
        $request->validate([
            'backup_category' => 'required|string',
        ]);

        $category = $request->backup_category;
        $date = now()->format('Y-m-d_H-i-s');

        // Check if a backup already exists for this category
        // Delete old file and record before creating new one
        $existing = DataBackup::query()->where('backup_category', $category)->first();

        if ($existing) {
            // Delete old file if exists
            $oldPath = storage_path('app/'.$existing->file_path);
            if ($existing->file_path && file_exists($oldPath)) {
                unlink($oldPath);
            }
            // Delete old DB record
            $existing->deleteOrFail();
        }

        try {
            $data = $this->getBackupData($category);
            $baseDir = storage_path('app/backups/'.$category);

            if (! file_exists($baseDir)) {
                mkdir($baseDir, 0755, true);
            }

            $filename = $date.'_'.$category.'_backup.json';
            $filePath = $baseDir.'/'.$filename;
            $relativePath = 'backups/'.$category.'/'.$filename;

            file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

            DataBackup::create([
                'backup_type' => 'manual',
                'backup_category' => $category,
                'backup_date' => now(),
                'file_path' => $relativePath,
                'file_size' => filesize($filePath),
                'status' => 1, // 1 = completed
                'error_message' => null,
                'completion_time' => now(),
            ]);

            return redirect()->back()->with('success', "Backup for '{$category}' completed!");

        } catch (\Exception $e) {
            DataBackup::create([
                'backup_type' => 'manual',
                'backup_category' => $category,
                'backup_date' => now(),
                'file_path' => null,
                'file_size' => 0,
                'status' => 0, // 0 = failed
                'error_message' => $e->getMessage(),
                'completion_time' => now(),
            ]);

            return redirect()->back()->with('error', 'Backup failed: '.$e->getMessage());
        }
    }

    public function backupAll()
    {
        $categories = [
            'user_data',
            'project_data',
            'attendance_records',
            'payment_summaries',
            'uploaded_photos',
        ];

        $failed = [];

        foreach ($categories as $category) {
            // Delete old backup for this category
            $existing = DataBackup::query()->where('backup_category', $category)->first();
            if ($existing) {
                $oldPath = storage_path('app/'.$existing->file_path);
                if ($existing->file_path && file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $existing->deleteOrFail();
            }

            try {
                $data = $this->getBackupData($category);
                $date = now()->format('Y-m-d_H-i-s');
                $baseDir = storage_path('app/backups/'.$category);

                if (! file_exists($baseDir)) {
                    mkdir($baseDir, 0755, true);
                }

                $filename = $date.'_'.$category.'_backup.json';
                $filePath = $baseDir.'/'.$filename;
                $relativePath = 'backups/'.$category.'/'.$filename;

                file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

                DataBackup::create([
                    'backup_type' => 'manual',
                    'backup_category' => $category,
                    'backup_date' => now(),
                    'file_path' => $relativePath,
                    'file_size' => filesize($filePath),
                    'status' => 1,
                    'error_message' => null,
                    'completion_time' => now(),
                ]);

            } catch (\Exception $e) {
                $failed[] = $category;
                DataBackup::create([
                    'backup_type' => 'manual',
                    'backup_category' => $category,
                    'backup_date' => now(),
                    'file_path' => null,
                    'file_size' => 0,
                    'status' => 0,
                    'error_message' => $e->getMessage(),
                    'completion_time' => now(),
                ]);
            }
        }

        if (count($failed) > 0) {
            return redirect()->back()->with('error', 'Some backups failed: '.implode(', ', $failed));
        }

        return redirect()->back()->with('success', 'All backups completed successfully!');
    }

    public function downloadBackup(Request $id)
    {
        $backup = DataBackup::findOrFail($id);
        $path = storage_path('app/'.$backup->file_path);

        if (! $backup->file_path || ! file_exists($path)) {
            return redirect()->back()->with('error', 'Backup file not found.');
        }

        return response()->download($path);
    }

    private function getBackupData(string $category): array
    {
        return match ($category) {
            'user_data' => DB::table('user')->get()->toArray(),
            'project_data' => DB::table('project')->get()->toArray(),
            'attendance_records' => DB::table('attendance')->get()->toArray(),
            'payment_summaries' => DB::table('work_completion')->get()->toArray(),
            'uploaded_photos' => DB::table('proof_image')->get()->toArray(),
            default => [],
        };
    }

    // Add to top imports

    public function saveSchedule(Request $request)
    {
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.frequency' => 'required|in:daily,weekly,monthly',
            'schedules.*.schedule_time' => 'required|date_format:H:i',
            'schedules.*.retention_days' => 'nullable|integer|min:1',
        ]);

        foreach ($request->schedules as $category => $data) {
            $time = Carbon::createFromFormat('H:i', $data['schedule_time']);
            $nextRun = $this->calculateNextRun($data['frequency'], $time);
            $retention = ! empty($data['retention_days'])
                ? now()->addDays($data['retention_days'])
                : null;

            BackupSchedule::query()->updateOrCreate(
                ['backup_category' => $category],
                [
                    'backup_type' => 'automatic',
                    'frequency' => $data['frequency'],
                    'schedule_time' => $time,
                    'next_run' => $nextRun,
                    'retention_date' => $retention,
                ]
            );
        }

        return redirect()->back()->with('success', 'All backup schedules saved successfully!');
    }

    private function calculateNextRun(string $frequency, Carbon $time): Carbon
    {
        $base = now()->setTimeFrom($time);
        // If that time already passed today, start from tomorrow
        if ($base->isPast()) {
            $base->addDay();
        }

        return match ($frequency) {
            'weekly' => $base->addWeek(),
            'monthly' => $base->addMonth(),
            default => $base,  // daily — already the next occurrence
        };
    }
}
