<?php

namespace App\Http\Controllers\SystemMonitoring;

use App\Http\Controllers\Controller;
use App\Models\SysLog\UserActivityLog;
use App\Models\SystemBackup\DataBackup;
use App\Models\UserManagement\User;
use Illuminate\Http\Request;
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
            $lastLog = UserActivityLog::where('user_iduser', $user->iduser)->latest('login_time')->first();
            $user->login_time = $lastLog?->login_time;
            $user->logout_time = $lastLog?->logout_time;
            $user->ip_address = $lastLog?->ip_address ?? 'N/A';
            $user->device = $lastLog?->device ?? 'N/A';
            $user->is_online = $lastLog && $lastLog->logout_time == null;
            return $user;
        });

        // Get only the latest backup per category
        $backups = DataBackup::orderBy('backup_date', 'desc')->get();

        return view('users.components.system_monitoring', [
            'title' => 'System Monitoring',
            'active_users' => $active_users,
            'backups' => $backups,
        ]);
    }

    public function forceLogout($id)
    {
        $log = UserActivityLog::where('user_iduser', $id)
            ->whereNull('logout_time')
            ->latest('login_time')
            ->first();

        if ($log) {
            $log->update(['logout_time' => now()]);
        }

        return redirect()->back()->with('success', 'User logged out successfully!');
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
        $existing = DataBackup::where('backup_category', $category)->first();

        if ($existing) {
            // Delete old file if exists
            $oldPath = storage_path('app/'.$existing->file_path);
            if ($existing->file_path && file_exists($oldPath)) {
                unlink($oldPath);
            }
            // Delete old DB record
            $existing->delete();
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
            $existing = DataBackup::where('backup_category', $category)->first();
            if ($existing) {
                $oldPath = storage_path('app/'.$existing->file_path);
                if ($existing->file_path && file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $existing->delete();
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

    public function downloadBackup($id)
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
}
