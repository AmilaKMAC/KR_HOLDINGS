<?php

namespace App\Http\Controllers\SystemSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemSettings\TechnicianLevel;
use App\Models\SystemSettings\Solar;
use App\Models\SystemSettings\PartnerCompany;
use App\Models\SystemSettings\AdditionalWork;

class SystemSettingsController extends Controller
{
    public function index(){
        $technician_level = TechnicianLevel::all();

        $additional_work = AdditionalWork::all();

        $solar_capacity = Solar::all();

        $partner_company = PartnerCompany::all();

        return view('users.components.system_settings', compact('technician_level', 'additional_work', 'solar_capacity', 'partner_company'), ['title' => 'System Settings']);
    }


// Store the Technician Level
public function storeTechnicianLevel(Request $request)
{
    $request->validate([
        'basic_salary' => 'required|numeric|min:0'
    ]);

    TechnicianLevel::create($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Technician level added successfully.');
}

// Update Technician Level
public function updateTechnicianLevel(Request $request, $id)
{
    $request->validate([
        'basic_salary' => 'required|numeric|min:0'
    ]);

    $technicianLevel = TechnicianLevel::findOrFail($id);
    $technicianLevel->update($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Technician level updated successfully.');

}



// Store Solar Capacity
public function storeSolarCapacity(Request $request){
    $request->validate([
        'capacity' => 'required|string'
    ]);

    Solar::create($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Solar capacity added successfully.');
}

// Update Solar Capacity
public  function updateSolarCapacity(Request $request, $id){
    $request->validate([
        'capacity' => 'required|numeric|min:0'
    ]);

    $solarCapacity = Solar::findOrFail($id);
    $solarCapacity->update($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Solar capacity updated successfully.');
}


// Store Aditional Work
public function storeAdditionalWork(Request $request){
    $request->validate([
        'work_description' => 'required|string|max:255',
        'rate' => 'required|numeric|min:0'
    ]);

    AdditionalWork::create($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Additional work added successfully.');
}

// Update Additional Work
public function updateAdditionalWork(Request $request, $id){
    $request->validate([
        'work_description' => 'required|string|max:255',
        'rate' => 'required|numeric|min:0'
    ]);

    $additionalWork = AdditionalWork::findOrFail($id);
    $additionalWork->update($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Additional work updated successfully.');
}



// Store Partner Company
public function storePartnerCompany(Request $request){
    $request->validate([
        'company_name' => 'required|string|max:255',
        'created_at' => 'required|date'
    ]);

    PartnerCompany::create($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Partner company added successfully.');
}

// Update Partner Company
public function updatePartnerCompany(Request $request, $id){
    $request->validate([
        'company_name' => 'required|string|max:255',
    ]);

    $partnerCompany = PartnerCompany::findOrFail($id);
    $partnerCompany->update($request->all());

    return redirect()->route('system_settings.index')->with('success', 'Partner company updated successfully.');
}
}