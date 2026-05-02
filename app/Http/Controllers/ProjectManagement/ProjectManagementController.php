<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\Project;
use App\Models\ProjectManagement\Cancellation;
use App\Models\SystemSettings\Solar;
use App\Models\SystemSettings\PartnerCompany;
use App\Models\UserManagement\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectManagementController extends Controller
{
    public function index()
    {
        $projects = Project::with([
            'Solar',
            'Partner',
            'assignedTechnicians.technician',
            'workCompletion',
        ])->orderBy('status', 'asc') // ongoing (0) first, completed (1) last
          ->get();

        $cancellations = Cancellation::with([
            'project',
            'assignTechnician.technician',
        ])->get();

        $solarOptions      = Solar::all();
        $partnerOptions    = PartnerCompany::query()->where('status', 1)->get();
        $technicianOptions = User::with('TechnicianRegistration')
            ->whereIn('user_role_iduser_role', [4])
            ->get();

        return view('users.components.project_management',
            compact('projects', 'cancellations', 'solarOptions', 'partnerOptions', 'technicianOptions'),
            ['title' => 'Project Management']
        );
    }

public function store(Request $request)
{
    $request->validate([
        'customer_name'                     => 'required|string|max:200',
        'location'                          => 'required|string|max:200',
        'site_url'                          => 'nullable|url|max:500',
        'contact'                           => 'required|string|max:15',
        'solar_idsolar'                     => 'required|integer',
        'partner_company_idpartner_company' => 'required|integer',
    ]);

    Project::create([
        'customer_name'                     => $request->customer_name,
        'location'                          => $request->location,
        'site_url'                          => $request->site_url,
        'contact'                           => $request->contact,
        'solar_idsolar'                     => $request->solar_idsolar,
        'partner_company_idpartner_company' => $request->partner_company_idpartner_company,
        'description'                       => $request->description,
        'user_iduser'                       => Auth::id(),
    ]);

    return redirect()->route('project_management.index')
        ->with('success', 'Project added successfully!');
}

public function update(Request $request, int $id)
{
    $request->validate([
        'customer_name'                     => 'required|string|max:200',
        'location'                          => 'required|string|max:200',
        'site_url'                          => 'nullable|url|max:500',
        'contact'                           => 'required|string|max:15',
        'solar_idsolar'                     => 'required|integer',
        'partner_company_idpartner_company' => 'required|integer',
    ]);

    Project::findOrFail($id)->update([
        'customer_name'                     => $request->customer_name,
        'location'                          => $request->location,
        'site_url'                          => $request->site_url,
        'contact'                           => $request->contact,
        'solar_idsolar'                     => $request->solar_idsolar,
        'partner_company_idpartner_company' => $request->partner_company_idpartner_company,
        'description'                       => $request->description,
    ]);

    return redirect()->route('project_management.index')
        ->with('success', 'Project updated successfully!');
}
}