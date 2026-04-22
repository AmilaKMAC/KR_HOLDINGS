<?php
namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use App\Models\Proof\ProofOfWork;
use App\Models\Proof\ProofImage;
use App\Models\ProjectManagement\AssignTechnician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    'proofRecords'     => $proofRecords,
    'sections'         => $sections,
    'title'            => 'Proof of Work',
]);

    }

    public function upload(Request $request)
    {
        $request->validate([
            'Project_idProject' => 'required|integer',
            'section'           => 'required|string',
            'images.*'          => 'required|image|max:5120',
        ]);

        $projectId = $request->Project_idProject;
        $section   = $request->section;
        $userId    = Auth::id();

        // Check if ANY technician already uploaded images for this section on this project
        $existingProof = ProofOfWork::where('Project_idProject', $projectId)->first();

        if ($existingProof) {
            $sectionAlreadyUploaded = ProofImage::where('proof_of_work_idproof_of_work', $existingProof->idproof_of_work)
                ->where('section', $section)
                ->exists();

            if ($sectionAlreadyUploaded) {
                return back()->with('error', "Section '{$section}' already has uploaded images for this project.");
            }

            // Use existing proof record but update uploader
            $proof = $existingProof;
        } else {
            // Create new proof record
            $proof = ProofOfWork::create([
                'Project_idProject' => $projectId,
                'user_iduser'       => $userId,
                'approval'          => 0,
            ]);
        }

        // Store images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store("proof/{$projectId}/{$section}", 'public');
                ProofImage::create([
                    'proof_of_work_idproof_of_work' => $proof->idproof_of_work,
                    'section'                       => $section,
                    'image_path'                    => $path,
                ]);
            }
        }

        return back()->with('success', 'Images uploaded successfully!');
    }

    public function getSections(): array
    {
        return [
            'panel_installation'    => 'Panel Installation',
            'water_proofing'        => 'Water Proofing on Roof Top',
            'railing_installation'  => 'Railing Installation',
            'dc_wiring'             => 'DC Wiring',
            'inverter_installation' => 'Inverter Installation',
            'combiner_box'          => 'Combiner Box',
            'hybrid_battery'        => 'Hybrid Battery (Optional)',
            'casing'                => 'Casing',
            'grounding'             => 'Grounding',
            'additional_work'       => 'Additional Work (Optional)',
        ];
    }
}