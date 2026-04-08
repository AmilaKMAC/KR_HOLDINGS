@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-grid gap-4 col-8 mx-auto">

            <button class="btn btn-dark p-4" data-bs-toggle="modal" data-bs-target="#technicianModal">
                Technician Level
            </button>

            <button class="btn btn-secondary p-4" data-bs-toggle="modal" data-bs-target="#workModal">
                Additional Work
            </button>

            <button class="btn btn-primary p-4" data-bs-toggle="modal" data-bs-target="#solarModal">
                Solar
            </button>

            <button class="btn btn-warning text-white p-4" data-bs-toggle="modal" data-bs-target="#partnerModal">
                Partner Company
            </button>

        </div>
    </div>


    <!-- ===================== TECHNICIAN LEVEL MODAL ===================== -->
    <div class="modal fade" id="technicianModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Technician Level</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Level</th>
                                    <th>Basic Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($technician_level as $level)
                                    <tr>
                                        <td>L{{ str_pad($level->idtechnician_level, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $level->basic_salary }} LKR</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                onclick="openNestedModal('technicianModal','editTechnicianModal{{ $level->idtechnician_level }}')">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-success btn-sm"
                            onclick="openNestedModal('technicianModal','addTechnicianModal')">
                            + Add New
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== ADDITIONAL WORK MODAL ===================== -->
    <div class="modal fade" id="workModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Additional Work</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($additional_work as $additional)
                                    <tr>
                                        <td>W{{ str_pad($additional->idadditional_work, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ ucwords(strtolower($additional->description), ' ,') }}</td>
                                        <td>{{ $additional->rate }} LKR</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                onclick="openNestedModal('workModal','editWorkModal{{ $additional->idadditional_work }}')">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-success btn-sm" onclick="openNestedModal('workModal','addWorkModal')">
                            + Add New
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== SOLAR MODAL ===================== -->
    <div class="modal fade" id="solarModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Solar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Capacity</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($solar_capacity as $solar)
                                    <tr>
                                        <td>C{{ str_pad($solar->idsolar, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $solar->capacity }} kW</td>
                                        <td>{{ $solar->rate }} LKR</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                onclick="openNestedModal('solarModal','editSolarModal{{ $solar->idsolar }}')">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-success btn-sm" onclick="openNestedModal('solarModal','addSolarModal')">
                            + Add New
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== PARTNER COMPANY MODAL ===================== -->
    <div class="modal fade" id="partnerModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Partner Company</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Partner ID</th>
                                    <th>Company Name</th>
                                    <th>Status</th>
                                    <th>Date Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partner_company as $partner)
                                    <tr>
                                        <td>P{{ str_pad($partner->idpartner_company, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ ucwords(strtolower($partner->company_name), ' ,') }}</td>
                                        <td>
                                            @if ($partner->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $partner->created_at?->format('Y-m-d') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                onclick="openNestedModal('partnerModal','editPartnerModal{{ $partner->idpartner_company }}')">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-success btn-sm" onclick="openNestedModal('partnerModal','addPartnerModal')">
                            + Add New
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ================================================== ADD / EDIT MODALS ================================================== -->

    <!-- Add Technician Modal -->
    <div class="modal fade" id="addTechnicianModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5>Add Technician Level</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('system_settings.storeTechnicianLevel') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Level ID</label>
                            <input type="text" class="form-control bg-light"
                                value="L{{ str_pad($technician_level->count() + 1, 3, '0', STR_PAD_LEFT) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Basic Salary</label>
                            <input type="number" name="basic_salary" class="form-control" placeholder="Basic Salary"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeAndReturn('addTechnicianModal','technicianModal')">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Technician Modals -->
    @foreach ($technician_level as $level)
        <div class="modal fade" id="editTechnicianModal{{ $level->idtechnician_level }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5>Edit Technician Level</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST"
                        action="{{ route('system_settings.updateTechnicianLevel', $level->idtechnician_level) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Level ID</label>
                                <input type="text" class="form-control bg-light"
                                    value="L{{ str_pad($level->idtechnician_level, 3, '0', STR_PAD_LEFT) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Basic Salary</label>
                                <input type="number" name="basic_salary" class="form-control"
                                    value="{{ $level->basic_salary }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeAndReturn('editTechnicianModal{{ $level->idtechnician_level }}','technicianModal')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Work Modal -->
    <div class="modal fade" id="addWorkModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5>Add Additional Work</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('system_settings.storeAdditionalWork') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Work ID</label>
                            <input type="text" class="form-control bg-light"
                                value="W{{ str_pad($additional_work->count() + 1, 3, '0', STR_PAD_LEFT) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input name="description" class="form-control" placeholder="Description" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rate</label>
                            <input name="rate" type="number" class="form-control" placeholder="Rate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeAndReturn('addWorkModal','workModal')">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Work Modals -->
    @foreach ($additional_work as $additional)
        <div class="modal fade" id="editWorkModal{{ $additional->idadditional_work }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5>Edit Additional Work</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST"
                        action="{{ route('system_settings.updateAdditionalWork', $additional->idadditional_work) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Work ID</label>
                                <input type="text" class="form-control bg-light"
                                    value="W{{ str_pad($additional->idadditional_work, 3, '0', STR_PAD_LEFT) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input name="description" class="form-control" value="{{ $additional->description }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rate</label>
                                <input name="rate" type="number" class="form-control"
                                    value="{{ $additional->rate }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeAndReturn('editWorkModal{{ $additional->idadditional_work }}','workModal')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Solar Modal -->
    <div class="modal fade" id="addSolarModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5>Add Solar Rate</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('system_settings.storeSolarCapacity') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Solar ID</label>
                            <input type="text" class="form-control bg-light"
                                value="C{{ str_pad($solar_capacity->count() + 1, 3, '0', STR_PAD_LEFT) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Capacity (kW)</label>
                            <input name="capacity" class="form-control" placeholder="e.g. 1-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rate</label>
                            <input name="rate" type="number" class="form-control" placeholder="Rate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeAndReturn('addSolarModal','solarModal')">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Solar Modals -->
    @foreach ($solar_capacity as $solar)
        <div class="modal fade" id="editSolarModal{{ $solar->idsolar }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5>Edit Solar</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('system_settings.updateSolarCapacity', $solar->idsolar) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Solar ID</label>
                                <input type="text" class="form-control bg-light"
                                    value="C{{ str_pad($solar->idsolar, 3, '0', STR_PAD_LEFT) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Capacity (kW)</label>
                                <input name="capacity" class="form-control" value="{{ $solar->capacity }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rate</label>
                                <input name="rate" type="number" class="form-control" value="{{ $solar->rate }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeAndReturn('editSolarModal{{ $solar->idsolar }}','solarModal')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Partner Modal -->
    <div class="modal fade" id="addPartnerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5>Add New Partner</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('system_settings.storePartnerCompany') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Partner ID</label>
                            <input type="text" class="form-control bg-light"
                                value="P{{ str_pad($partner_company->count() + 1, 3, '0', STR_PAD_LEFT) }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input name="company_name" class="form-control" placeholder="Company Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="created_at" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeAndReturn('addPartnerModal','partnerModal')">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Partner Modals -->
    @foreach ($partner_company as $partner)
        <div class="modal fade" id="editPartnerModal{{ $partner->idpartner_company }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5>Edit Partner</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST"
                        action="{{ route('system_settings.updatePartnerCompany', $partner->idpartner_company) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Partner ID</label>
                                <input type="text" class="form-control bg-light"
                                    value="P{{ str_pad($partner->idpartner_company, 3, '0', STR_PAD_LEFT) }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Company Name</label>
                                <input name="company_name" class="form-control" value="{{ $partner->company_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Added</label>
                                <input type="date" name="created_at" class="form-control bg-light"
                                    value="{{ $partner->created_at?->format('Y-m-d') }}" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeAndReturn('editPartnerModal{{ $partner->idpartner_company }}','partnerModal')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


 
@endsection
