<?php

namespace App\Console\Commands;

use App\Models\SystemBackup\BackupSchedule;
use App\Models\SystemBackup\DataBackup;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AutoBackup extends Command
{
    protected $signature   = 'backup:auto';
    protected $description = 'Run automatic backups based on backup_schedule table';

    public function handle(): void
    {
        $now = now();

        // Find all schedules that are due
        $schedules = BackupSchedule::query()
            ->where('backup_type', 'automatic')
            ->where('next_run', '<=', $now)
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('No automatic backups due at this time.');
            return;
        }

        foreach ($schedules as $schedule) {
            $this->info("Backing up: {$schedule->backup_category} ({$schedule->frequency})");

            // Remove old backup record + file for this category
            $existing = DataBackup::query()
                ->where('backup_category', $schedule->backup_category)
                ->where('backup_type', 'automatic')
                ->first();

            if ($existing) {
                $oldPath = storage_path('app/' . $existing->file_path);
                if ($existing->file_path && file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $existing->deleteOrFail();

            }

            try {
                $data    = $this->getBackupData($schedule->backup_category);
                $date    = $now->format('Y-m-d_H-i-s');
                $baseDir = storage_path('app/backups/' . $schedule->backup_category);

                if (! file_exists($baseDir)) {
                    mkdir($baseDir, 0755, true);
                }

                $filename     = $date . '_' . $schedule->backup_category . '_backup.json';
                $filePath     = $baseDir . '/' . $filename;
                $relativePath = 'backups/' . $schedule->backup_category . '/' . $filename;

                file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

                DataBackup::create([
                    'backup_type'     => 'automatic',
                    'backup_category' => $schedule->backup_category,
                    'backup_date'     => $now,
                    'file_path'       => $relativePath,
                    'file_size'       => filesize($filePath),
                    'status'          => 1,
                    'error_message'   => null,
                    'completion_time' => now(),
                ]);

                $schedule->update([
                    'last_run' => $now,
                    'next_run' => $this->calculateNextRun($schedule->frequency, $schedule->schedule_time),
                ]);

                $this->info("  ✓ {$schedule->backup_category} completed.");

            } catch (\Exception $e) {
                DataBackup::create([
                    'backup_type'     => 'automatic',
                    'backup_category' => $schedule->backup_category,
                    'backup_date'     => $now,
                    'file_path'       => null,
                    'file_size'       => 0,
                    'status'          => 0,
                    'error_message'   => null,
                    'completion_time' => now(),
                ]);

                $schedule->update([
                    'last_run' => $now,
                    'next_run' => $this->calculateNextRun($schedule->frequency, $schedule->schedule_time),
                ]);

                $this->error("  ✗ {$schedule->backup_category}: " . $e->getMessage());
            }
        }
    }

    // ✅ Fix P1132: added string type hint for $scheduleTime
    private function calculateNextRun(string $frequency, string $scheduleTime): Carbon
    {
        $time = Carbon::parse($scheduleTime);

        $next = now()->setHour($time->hour)->setMinute($time->minute)->setSecond(0);

        if ($next->isPast()) {
            $next->addDay();
        }

        return match ($frequency) {
            'weekly'  => $next->addWeek(),
            'monthly' => $next->addMonth(),
            default   => $next,
        };
    }

    private function getBackupData(string $category): array
    {
        return match ($category) {
            'user_data'          => DB::table('user')->get()->toArray(),
            'project_data'       => DB::table('project')->get()->toArray(),
            'attendance_records' => DB::table('attendance')->get()->toArray(),
            'payment_summaries'  => DB::table('work_completion')->get()->toArray(),
            'uploaded_photos'    => DB::table('proof_image')->get()->toArray(),
            default              => [],
        };
    }
}