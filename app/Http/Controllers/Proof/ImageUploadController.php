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
    $assignedProjects = AssignTechnician::with([
        'project.Solar',
        'project.Partner',
    ])
        ->where('user_iduser', Auth::id())
        ->where('status', 1)
        ->get();

    $proofRecords = ProofOfWork::with('images')
        ->whereIn(
            'Project_idProject',
            $assignedProjects->pluck('Project_idProject')->toArray()
        )
        ->get()
        ->keyBy('Project_idProject');

    return view('users.components.proof_of_work', [
        'title'            => 'Proof of Work',
        'assignedProjects' => $assignedProjects,
        'proofRecords'     => $proofRecords,
        'sections'         => $this->getSections(),
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
        foreach ($request->file('images', []) as $files) {
            if (!empty($files)) { $hasFiles = true; break; }
        }

        if (!$hasFiles) {
            return back()->with('error', 'Please select at least one image to upload.');
        }

        // Get or create proof record
        $proof = ProofOfWork::firstOrCreate(
            ['Project_idProject' => $projectId],
            ['user_iduser' => $userId, 'approval' => 0]
        );

        $uploaded = 0;
        $skipped  = [];

        foreach ($request->file('images', []) as $sectionKey => $files) {
    if (empty($files)) continue;

    $filesArray = is_array($files) ? $files : [$files];

    // Mark old images for this section as reuploaded
    ProofImage::query()
        ->where('proof_of_work_idproof_of_work', $proof->idproof_of_work)
        ->where('section', $sectionKey)
        ->update(['is_reuploaded' => 1]);

    foreach ($filesArray as $image) {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!in_array($image->getMimeType(), $allowedMimes)) continue;
        if ($image->getSize() > 5 * 1024 * 1024) continue;

        $path = $image->store('proof/' . $projectId . '/' . $sectionKey, 'public');

        ProofImage::create([
            'proof_of_work_idproof_of_work' => $proof->idproof_of_work,
            'section'                       => $sectionKey,
            'image_path'                    => 'storage/' . $path,
            'is_reuploaded'                 => 0,
        ]);

        $uploaded++;
    }
    // After the foreach loop saving images, add this:
if ($uploaded > 0) {
    $proof->update(['unapprove_reason' => null]);
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
            'panel_installation'   => 'Panel Installation',
            'water_proofing'       => 'Water Proofing on Roof Top',
            'railing_installation' => 'Railing Installation',
            'dc_wiring'            => 'DC Wiring',
            'inverter_installation'=> 'Inverter Installation',
            'combiner_box'         => 'Combiner Box',
            'hybrid_battery'       => 'Hybrid Battery (Optional)',
            'casing'               => 'Casing',
            'grounding'            => 'Grounding',
            'additional_work'      => 'Additional Work (Optional)',
        ];
    }
}