@extends('layout.app')

@section('content')

<div class="container-fluid mt-4">

    <!-- ================= HEADER ================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <h3 class="fw-bold">Project Management</h3>
        </div>
    </div>

    <!-- ================= PROJECT DETAILS ================= -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light fw-bold text-center">
            Project Details
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
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
                        <tr>
                            <td>P01</td>
                            <td>SK Lal</td>
                            <td>Colombo</td>
                            <td>076XXXXXXX</td>
                            <td>5kW</td>
                            <td>Hayleys</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editProjectModal">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Add New Project Button -->
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-success px-4"
                    data-bs-toggle="modal"
                    data-bs-target="#addProjectModal">
                    Add New Project
                </button>
            </div>

        </div>
    </div>

    <!-- ================= ASSIGN TECHNICIANS ================= -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light fw-bold text-center">
            Assign Technicians
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Project ID</th>
                            <th>Assigned Technicians</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>P01</td>
                            <td>T01, T02</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAssignModal">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Add Technician Button -->
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addAssignModal">
                    Add Technician
                </button>
            </div>

        </div>
    </div>

    <!-- ================= CANCELLATION (VIEW ONLY) ================= -->
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold text-center">
            Cancellation
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Project ID</th>
                            <th>Technician</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>P02</td>
                            <td>T04</td>
                            <td>Customer Request</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ================= ADD PROJECT MODAL ================= -->
<div class="modal fade" id="addProjectModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header bg-success text-white">
    <h5 class="modal-title">Add New Project</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form>
<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Project ID</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Customer Name</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Contact Number</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Capacity</label>
        <select class="form-select">
            <option>1kW</option>
            <option>3kW</option>
            <option>5kW</option>
            <option>10kW</option>
            <option>15kW</option>
            <option>20kW</option>
            <option>30kW</option>
            <option>50kW</option>
            <option>100kW</option>
            <option>200kW</option>
            <option>More</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Partner Company</label>
        <input type="text" class="form-control">
    </div>

</div>
</form>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button class="btn btn-success">Save Project</button>
</div>

</div>
</div>
</div>

<!-- ================= EDIT PROJECT MODAL ================= -->
<div class="modal fade" id="editProjectModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Edit Project</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form>
<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Customer Name</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Contact Number</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Capacity</label>
        <select class="form-select">
            <option>1kW</option>
            <option>3kW</option>
            <option>5kW</option>
            <option>10kW</option>
            <option>15kW</option>
            <option>20kW</option>
            <option>30kW</option>
            <option>50kW</option>
            <option>100kW</option>
            <option>200kW</option>
            <option>More</option>
        </select>
    </div>

</div>
</form>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Update</button>
</div>

</div>
</div>
</div>

<!-- ================= ADD ASSIGN MODAL ================= -->
<div class="modal fade" id="addAssignModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Add Technician</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form>

    <div class="mb-3">
        <label class="form-label fw-bold">Project</label>
        <select class="form-select">
            <option>P01</option>
            <option>P02</option>
        </select>
    </div>

    <label class="form-label fw-bold">Select Technicians</label>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="T01" id="tech1">
        <label class="form-check-label" for="tech1">T01 - John</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="T02" id="tech2">
        <label class="form-check-label" for="tech2">T02 - David</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="T03" id="tech3">
        <label class="form-check-label" for="tech3">T03 - Alex</label>
    </div>

</form>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Assign</button>
</div>

</div>
</div>
</div>

<!-- ================= EDIT ASSIGN MODAL ================= -->
<div class="modal fade" id="editAssignModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-warning">
    <h5 class="modal-title">Edit Technician Assignment</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form>

    <label class="form-label fw-bold">Assigned Technicians</label>
    <small class="text-muted d-block mb-2">Uncheck to remove technician</small>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="T01" checked>
        <label class="form-check-label">T01 - John</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="T02" checked>
        <label class="form-check-label">T02 - David</label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="T03">
        <label class="form-check-label">T03 - Alex</label>
    </div>

</form>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-warning">Update Assignment</button>
</div>

</div>
</div>
</div>

@endsection