<?php

namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use App\Models\Proof\ProofOfWork;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkReviewController extends Controller
{
    public function index()
    {
        $proofs = ProofOfWork::with([
            'project.Solar',
            'project.Partner',
            'project.assignedTechnicians.technician',
            'project.workCompletion',
            'images',
            'additionalWorks',
        ])
        ->where('approval', 1)
        ->get();

        return view('users.components.review_photos', [
            'title'  => 'Review Photos',
            'proofs' => $proofs,
        ]);
    }

    public function download(int $id)
    {
        $proof = ProofOfWork::with('images', 'project.workCompletion')->findOrFail($id);

        // Build zip filename
        $projectId    = 'P' . str_pad($proof->project?->idProject, 3, '0', STR_PAD_LEFT);
        $customerName = str_replace(' ', '_', strtoupper($proof->project?->customer_name ?? 'UNKNOWN'));
        $completionDate = $proof->project?->workCompletion?->completion_date
            ? Carbon::parse($proof->project->workCompletion->completion_date)->format('Y-m-d')
            : now()->format('Y-m-d');

        $zipName = "{$projectId}_{$customerName}_{$completionDate}.zip";

        // Collect valid image paths
        $files = [];
        foreach ($proof->images as $img) {
            $filePath = public_path($img->image_path);
            if (file_exists($filePath)) {
                $files[] = $filePath;
            }
        }

        if (empty($files)) {
            return back()->with('error', 'No images found to download.');
        }

        // Create zip in memory
        $tmpFile = tempnam(sys_get_temp_dir(), 'zip_');

        $zip = new \ZipArchive();
        if ($zip->open($tmpFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Could not create zip file. Please check ZipArchive is enabled in php.ini.');
        }

        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        return response()->download($tmpFile, $zipName, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }
}