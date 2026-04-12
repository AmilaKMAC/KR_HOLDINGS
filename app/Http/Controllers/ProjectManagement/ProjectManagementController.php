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
        ])->get();

        $cancellations = Cancellation::with([
            'project',
            'assignTechnician.technician',
        ])->get();

        $solarOptions      = Solar::all();
        $partnerOptions    = PartnerCompany::where('status', 1)->get();
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
            'contact'                           => 'required|string|max:15',
            'solar_idsolar'                     => 'required|integer',
            'partner_company_idpartner_company' => 'required|integer',
            'description'                       => 'required|string|max:255',
        ]);

        $partner = PartnerCompany::find($request->partner_company_idpartner_company);

        Project::create([
            'customer_name'                     => $request->customer_name,
            'location'                          => $request->location,
            'contact'                           => $request->contact,
            'solar_idsolar'                     => $request->solar_idsolar,
            'partner_company_idpartner_company' => $request->partner_company_idpartner_company,
            'description'                       => $request->description,
            'user_iduser'                       => Auth::id(),
        ]);

        return redirect()->route('project_management.index')
            ->with('success', 'Project added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name'                     => 'required|string|max:200',
            'location'                          => 'required|string|max:200',
            'contact'                           => 'required|string|max:15',
            'solar_idsolar'                     => 'required|integer',
            'partner_company_idpartner_company' => 'required|integer',
        ]);

        $partner = PartnerCompany::find($request->partner_company_idpartner_company);

        Project::findOrFail($id)->update([
            'customer_name'                     => $request->customer_name,
            'location'                          => $request->location,
            'contact'                           => $request->contact,
            'solar_idsolar'                     => $request->solar_idsolar,
            'partner_company_idpartner_company' => $request->partner_company_idpartner_company,
            'partner_company'                   => $partner?->company_name,
        ]);

        return redirect()->route('project_management.index')
            ->with('success', 'Project updated successfully!');
    }
}