<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenerateMonthlyPayments extends Command
{
    protected $signature   = 'payments:generate-monthly {--month= : Month in Y-m format, defaults to last month}';
    protected $description = 'Generate monthly payment records for all active technicians';

    public function handle(): void
    {
        // Default to last month so it runs at the end/start of month boundary
        $month     = $this->option('month') ?? Carbon::now()->subMonth()->format('Y-m');
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate   = Carbon::parse($month . '-01')->endOfMonth();

        $this->info("Generating payments for: {$startDate->format('F Y')}");

        // Get all technicians (role 4) who have at least one approved proof this month
        $technicians = DB::table('user as u')
            ->join('technician_registration as tr',
                'u.technician_registration_idtechnician_registration', '=', 'tr.idtechnician_registration')
            ->join('technician_level as tl',
                'tr.technician_level_idtechnician_level', '=', 'tl.idtechnician_level')
            ->where('u.user_role_iduser_role', 4)
            ->where('u.status', 1)
            ->select(
                'u.iduser',
                'tr.technician_level_idtechnician_level',
                'tl.basic_salary'
            )
            ->get();

        $generated = 0;
        $skipped   = 0;

        foreach ($technicians as $technician) {

            // Skip if payment already generated for this technician this month
            $exists = DB::table('payment')
                ->where('user_iduser', $technician->iduser)
                ->whereYear('date', $startDate->year)
                ->whereMonth('date', $startDate->month)
                ->exists();

            if ($exists) {
                $this->line("  Skipped (already exists): User {$technician->iduser}");
                $skipped++;
                continue;
            }

            // Get all approved proofs for this technician this month
            $approvedProofs = DB::table('proof_of_work as pw')
                ->join('project as pr', 'pw.Project_idProject', '=', 'pr.idProject')
                ->join('solar as s', 'pr.solar_idsolar', '=', 's.idsolar')
                ->join('additional_work as aw', 'pw.additional_work_idadditional_work', '=', 'aw.idadditional_work')
                ->where('pw.user_iduser', $technician->iduser)
                ->where('pw.approval', 1)
                ->whereBetween('pw.uploaded_at', [$startDate, $endDate])
                ->select(
                    'pr.solar_idsolar',
                    's.rate as solar_rate',
                    'pw.additional_work_idadditional_work',
                    'aw.rate as additional_work_rate'
                )
                ->get();

            if ($approvedProofs->isEmpty()) {
                $this->line("  Skipped (no approved work): User {$technician->iduser}");
                $skipped++;
                continue;
            }

            // Sum solar rates from distinct projects worked on this month
            $totalSolarRate = $approvedProofs->unique('solar_idsolar')->sum('solar_rate');

            // Sum all additional work rates for this month
            $totalAdditionalWork = $approvedProofs->sum('additional_work_rate');

            // others = 0 by default, executive fills it later
            $others   = 0;
            $total    = $technician->basic_salary + $totalSolarRate + $totalAdditionalWork + $others;

            // Use the first additional_work_id as the FK reference (pivot for the dominant one)
            $firstAdditionalWorkId = $approvedProofs->first()->additional_work_idadditional_work;
            $firstSolarId          = $approvedProofs->first()->solar_idsolar;

            DB::transaction(function () use (
                $technician,
                $firstSolarId,
                $firstAdditionalWorkId,
                $total,
                $others,
                $startDate
            ) {
                // Insert payment row (date = last day of the month)
                $idpayment = DB::table('payment')->insertGetId([
                    'user_iduser'    => $technician->iduser,
                    'date'           => $startDate->copy()->endOfMonth()->toDateString(),
                    'payment_status' => 0, // Pending
                ]);

                // Insert payment_process row linked to payment
                DB::table('payment_process')->insert([
                    'user_iduser'                         => $technician->iduser,
                    'idpayment'                           => $idpayment,
                    'technician_level_idtechnician_level' => $technician->technician_level_idtechnician_level,
                    'solar_idsolar'                       => $firstSolarId,
                    'additional_work_idadditional_work'   => $firstAdditionalWorkId,
                    'others'                              => $others,
                    'total'                               => $total,
                ]);
            });

            $this->info("  Generated payment for User {$technician->iduser} | Total: {$total}");
            $generated++;
        }

        $this->info("Done. Generated: {$generated} | Skipped: {$skipped}");
    }
}