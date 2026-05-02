<?php

namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\AssignTechnician;
use App\Models\Proof\ProofImage;
use App\Models\Proof\ProofOfWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageUploadController extends Controller
{
    public function index()
    {
        // Get projects assigned to this technician
        $assignedProjects = AssignTechnician::with([
            'project.Solar',
            'project.Partner',
        ])
            ->where('user_iduser', Auth::id())
            ->where('status', 1)
            ->get();

        // Get existing proof records for this technician
        $proofRecords = ProofOfWork::with(['project.Solar', 'project.Partner', 'images'])
            ->where('user_iduser', Auth::id())
            ->get()
            ->keyBy('Project_idProject');

        $sections = $this->getSections();

        return view('users.components.proof_of_work', [
            'assignedProjects' => $assignedProjects,
            'proofRecords' => $proofRecords,
            'sections' => $sections,
            'title' => 'Proof of Work',
        ]);

    }

    public function upload(Request $request)
{
    $request->validate([
        'Project_idProject' => 'required|integer',
        'images'            => 'required|array',
    ]);

    $projectId = $request->Project_idProject;
    $userId    = Auth::id();

    // Check at least one file was uploaded
    $hasFiles = false;
    foreach ($request->file('images', []) as $sectionKey => $files) {
        if (!empty($files)) {
            $hasFiles = true;
            break;
        }
    }

    if (!$hasFiles) {
        return back()->with('error', 'Please select at least one image to upload.');
    }

    // Get or create proof record
    $proof = ProofOfWork::query()->where('Project_idProject', $projectId)->first();

    if (!$proof) {
        $proof = ProofOfWork::query()->create([
            'Project_idProject' => $projectId,
            'user_iduser'       => $userId,
            'approval'          => 0,
        ]);
    }

    $uploaded = 0;
    $skipped  = [];

    foreach ($request->file('images', []) as $sectionKey => $files) {
        if (empty($files)) continue;

        // Check if section already uploaded
        $sectionAlreadyUploaded = ProofImage::query()->where('proof_of_work_idproof_of_work', $proof->idproof_of_work)
            ->where('section', $sectionKey)
            ->exists();

        if ($sectionAlreadyUploaded) {
            $skipped[] = $sectionKey;
            continue;
        }

        $filesArray = is_array($files) ? $files : [$files];

        foreach ($filesArray as $image) {
            // Validate each file manually
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!in_array($image->getMimeType(), $allowedMimes)) continue;
            if ($image->getSize() > 5 * 1024 * 1024) continue; // 5MB limit

            $dir = public_path('uploads/proof/' . $projectId . '/' . $sectionKey);
            if (!file_exists($dir)) mkdir($dir, 0755, true);

            $filename  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($dir, $filename);
            $imagePath = 'uploads/proof/' . $projectId . '/' . $sectionKey . '/' . $filename;

            ProofImage::query()->create([
                'proof_of_work_idproof_of_work' => $proof->idproof_of_work,
                'section'                       => $sectionKey,
                'image_path'                    => $imagePath,
            ]);

            $uploaded++;
        }
    }

    $message = "Successfully uploaded {$uploaded} image(s).";
    if (!empty($skipped)) {
        $message .= ' Skipped already uploaded sections: ' . implode(', ', $skipped);
    }

    return back()->with('success', $message);
}

    public function getSections(): array
    {
        return [
            'panel_installation' => 'Panel Installation',
            'water_proofing' => 'Water Proofing on Roof Top',
            'railing_installation' => 'Railing Installation',
            'dc_wiring' => 'DC Wiring',
            'inverter_installation' => 'Inverter Installation',
            'combiner_box' => 'Combiner Box',
            'hybrid_battery' => 'Hybrid Battery (Optional)',
            'casing' => 'Casing',
            'grounding' => 'Grounding',
            'additional_work' => 'Additional Work (Optional)',
        ];
    }
}
