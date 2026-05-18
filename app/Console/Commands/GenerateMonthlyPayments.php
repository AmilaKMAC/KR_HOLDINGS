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
        $month     = $this->option('month') ?? Carbon::now()->subMonth()->format('Y-m');
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate   = Carbon::parse($month . '-01')->endOfMonth();

        $this->info("Generating payments for: {$startDate->format('F Y')}");

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

            $exists = DB::table('payment')
                ->where('user_iduser', $technician->iduser)
                ->where('month', $startDate->month)
                ->where('year', $startDate->year)
                ->exists();

            if ($exists) {
                $this->line("  Skipped (already exists): User {$technician->iduser}");
                $skipped++;
                continue;
            }

            // Fixed: wct.user_iduser moved out of closure into where()
            $projects = DB::table('assign_technician as at')
                ->join('project as pr', 'at.Project_idProject', '=', 'pr.idProject')
                ->join('solar as s', 'pr.solar_idsolar', '=', 's.idsolar')
                ->join('work_completion as wc', 'wc.Project_idProject', '=', 'pr.idProject')
                ->join('work_completion_technician as wct', 'wct.work_completion_idwork_completion', '=', 'wc.idwork_completion')
                ->where('at.user_iduser', $technician->iduser)
                ->where('wct.user_iduser', $technician->iduser)
                ->where('at.status', 1)
                ->where('wc.approval', 1)
                ->whereMonth('wc.completion_date', $startDate->month)
                ->whereYear('wc.completion_date', $startDate->year)
                ->select(
                    'pr.idProject',
                    'pr.solar_idsolar',
                    's.rate as solar_rate'
                )
                ->distinct()
                ->get();

            if ($projects->isEmpty()) {
                $this->line("  Skipped (no assigned projects with work): User {$technician->iduser}");
                $skipped++;
                continue;
            }

            DB::transaction(function () use ($technician, $projects, $startDate) {

                $grandProcessTotal = 0;

                $idpayment = DB::table('payment')->insertGetId([
                    'user_iduser'    => $technician->iduser,
                    'month'          => $startDate->month,
                    'year'           => $startDate->year,
                    'basic_salary'   => $technician->basic_salary,
                    'other_payment'  => 0,
                    'date'           => $startDate->copy()->endOfMonth()->toDateString(),
                    'payment_status' => 0,
                    'process_total'  => 0,
                    'total'          => 0,
                ]);

                foreach ($projects as $project) {

                    $additionalWorks = DB::table('proof_additional_work as paw')
                        ->join('additional_work as aw', 'paw.idadditional_work', '=', 'aw.idadditional_work')
                        ->where('paw.Project_idProject', $project->idProject)
                        ->select(
                            'aw.idadditional_work',
                            'aw.rate'
                        )
                        ->get();

                    $additionalWorkTotal = $additionalWorks->sum('rate');
                    $projectTotal        = round($project->solar_rate + $additionalWorkTotal, 2);
                    $grandProcessTotal  += $projectTotal;

                    $idpaymentProcess = DB::table('payment_process')->insertGetId([
                        'user_iduser'                         => $technician->iduser,
                        'idpayment'                           => $idpayment,
                        'project_idProject'                   => $project->idProject,
                        'technician_level_idtechnician_level' => $technician->technician_level_idtechnician_level,
                        'total'                               => $projectTotal,
                    ]);

                    foreach ($additionalWorks as $aw) {
                        DB::table('payment_process_additional_work')->insert([
                            'payment_process_idpayment_process' => $idpaymentProcess,
                            'additional_work_idadditional_work' => $aw->idadditional_work,
                            'rate'                              => $aw->rate,
                            'created_at'                        => now(),
                            'updated_at'                        => now(),
                        ]);
                    }
                }

                $grandTotal = round($technician->basic_salary + $grandProcessTotal, 2);

                DB::table('payment')
                    ->where('idpayment', $idpayment)
                    ->update([
                        'process_total' => $grandProcessTotal,
                        'total'         => $grandTotal,
                    ]);
            });

            $this->info("  Generated payment for User {$technician->iduser}");
            $generated++;
        }

        $this->info("Done. Generated: {$generated} | Skipped: {$skipped}");
    }
}