@extends('layout.app')

@section('content')
    <div class="container-fluid mt-4">

        <!-- ================= PROJECT DETAILS ================= -->
        <div class="card shadow-sm mb-5">
            <div class="card-header fw-bold text-center bg-dark text-white">
                Project Details
            </div>
            <div class="p-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Contact</th>
                                <th>Capacity</th>
                                <th>Partner</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                <tr>
                                    <td>P{{ str_pad($project->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ ucwords(strtolower($project->customer_name)) }}</td>
                                    <td>{{ $project->location }}</td>
                                    <td>{{ $project->contact }}</td>
                                    <td>{{ $project->Solar?->capacity ?? ($project->capacity ?? 'N/A') }} kW</td>
                                    <td>{{ $project->Partner?->company_name ?? ($project->partner_company ?? 'N/A') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editProjectModal{{ $project->idProject }}">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No projects found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end px-3 py-2 bg-light border-top">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        + Add New Project
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= ASSIGN TECHNICIANS ================= -->
        <div class="card shadow-sm mb-5">
            <div class="card-header fw-bold text-center bg-secondary text-white">
                Assign Technicians
            </div>
            <div class="p-2">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Assigned Technicians</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                <tr>
                                    <td>P{{ str_pad($project->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                    <td>
                                        @if ($project->assignedTechnicians->isNotEmpty())
                                            @foreach ($project->assignedTechnicians as $assign)
                                                {{ ucwords(strtolower($assign->technician?->first_name ?? '')) }}
                                                {{ ucwords(strtolower($assign->technician?->last_name ?? '')) }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-muted">No technicians assigned</span>
                                        @endif
                                    </td>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editAssignModal{{ $project->idProject }}">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No projects found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end px-3 py-2 bg-light border-top">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssignModal">
                        + Add Technician
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= CANCELLATION ================= -->
        <div class="card shadow-sm mb-5">
            <div class="card-header fw-bold text-center bg-primary text-white">
                Cancellation
            </div>
            <div class="p-2">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Technician</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cancellations as $cancel)
                                <tr>
                                    <td>P{{ str_pad($cancel->project?->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        {{ ucwords(strtolower($cancel->assignTechnician?->technician?->first_name ?? 'N/A')) }}
                                        {{ ucwords(strtolower($cancel->assignTechnician?->technician?->last_name ?? '')) }}
                                    </td>
                                    <td>{{ $cancel->reason }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No cancellations found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="mt-3"></div>


    <!-- ========================== ADD PROJECT MODAL ========================== -->
    <div class="modal fade" id="addProjectModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Add New Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('project_management.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Customer Name</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Capacity</label>
                                <select name="solar_idsolar" class="form-select" required>
                                    <option value="">Select Capacity</option>
                                    @foreach ($solarOptions as $solar)
                                        <option value="{{ $solar->idsolar }}">
                                            {{ $solar->capacity }} kW
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Partner Company</label>
                                <select name="partner_company_idpartner_company" class="form-select" required>
                                    <option value="">Select Partner</option>
                                    @foreach ($partnerOptions as $partner)
                                        <option value="{{ $partner->idpartner_company }}">
                                            {{ $partner->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ========================== EDIT PROJECT MODALS ========================== -->
    @foreach ($projects as $project)
        <div class="modal fade" id="editProjectModal{{ $project->idProject }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Project</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('project_management.update', $project->idProject) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control"
                                        value="{{ $project->customer_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control"
                                        value="{{ $project->location }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" name="contact" class="form-control"
                                        value="{{ $project->contact }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Capacity</label>
                                    <select name="solar_idsolar" class="form-select">
                                        @foreach ($solarOptions as $solar)
                                            <option value="{{ $solar->idsolar }}"
                                                {{ $project->solar_idsolar == $solar->idsolar ? 'selected' : '' }}>
                                                {{ $solar->capacity }} kW
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Partner Company</label>
                                    <select name="partner_company_idpartner_company" class="form-select">
                                        @foreach ($partnerOptions as $partner)
                                            <option value="{{ $partner->idpartner_company }}"
                                                {{ $project->partner_company_idpartner_company == $partner->idpartner_company ? 'selected' : '' }}>
                                                {{ $partner->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="2">{{ $project->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <!-- ========================== ADD ASSIGN MODAL ========================== -->
    <div class="modal fade" id="addAssignModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Assign Technician</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('project_management.assign') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Project</label>
                            <select name="Project_idProject" class="form-select" required>
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->idProject }}">
                                        P{{ str_pad($project->idProject, 3, '0', STR_PAD_LEFT) }}
                                        — {{ $project->customer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="form-label fw-bold">Select Technicians</label>
                        @foreach ($technicianOptions as $tech)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="technicians[]"
                                    value="{{ $tech->iduser }}" id="addTech{{ $tech->iduser }}">
                                <label class="form-check-label" for="addTech{{ $tech->iduser }}">
                                    T{{ str_pad($tech->TechnicianRegistration?->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                    — {{ ucwords(strtolower($tech->first_name)) }}
                                    {{ ucwords(strtolower($tech->last_name)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ========================== EDIT ASSIGN MODALS ========================== -->
    @foreach ($projects as $project)
        <div class="modal fade" id="editAssignModal{{ $project->idProject }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Edit Technician Assignment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('project_management.assign') }}">
                        @csrf
                        <input type="hidden" name="Project_idProject" value="{{ $project->idProject }}">
                        <div class="modal-body">
                            <label class="form-label fw-bold">Assigned Technicians</label>
                            <small class="text-muted d-block mb-2">Uncheck to remove technician</small>
                            @foreach ($technicianOptions as $tech)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="technicians[]"
                                        value="{{ $tech->iduser }}"
                                        id="editTech{{ $project->idProject }}_{{ $tech->iduser }}"
                                        {{ $project->assignedTechnicians->pluck('user_iduser')->contains($tech->iduser) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="editTech{{ $project->idProject }}_{{ $tech->iduser }}">
                                        T{{ str_pad($tech->TechnicianRegistration?->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                        — {{ ucwords(strtolower($tech->first_name)) }}
                                        {{ ucwords(strtolower($tech->last_name)) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection
