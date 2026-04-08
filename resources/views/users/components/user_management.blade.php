@extends('layout.app')

@section('content')
    <div class="container-fluid px-2 px-md-4 px-lg-5">

        <!-- ================= USER TABLE ================= -->
        <div class="row mb-5 justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header text-center fw-bold bg-dark text-white">
                        User Registration
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-bordered table-striped table-hover data-table text-center align-middle mb-0 w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>UID</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            @if ($user->UserRegistration)
                                                U{{ str_pad($user->UserRegistration->iduser_registration, 3, '0', STR_PAD_LEFT) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ ucwords(strtolower($user->first_name)) }}
                                            {{ ucwords(strtolower($user->last_name)) }}</td>
                                        <td>{{ $user->contact_no }}</td>
                                        <td>{{ $user->UserRole?->role_name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($user->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#infoUserModal{{ $user->iduser }}">
                                                Info
                                            </button>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal{{ $user->iduser }}">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end px-3 py-2 bg-light border-top">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            + Add User
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TECHNICIAN TABLE ================= -->
        <div class="row mb-5 justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header text-center fw-bold bg-secondary text-white">
                        Technician Registration
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-bordered table-striped data-table table-hover text-center align-middle mb-0 w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>UID</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($technicians as $technician)
                                    <tr>
                                        <td>
                                            @if ($technician->TechnicianRegistration)
                                                T{{ str_pad($technician->TechnicianRegistration->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ ucwords(strtolower($technician->first_name)) }}
                                            {{ ucwords(strtolower($technician->last_name)) }}</td>
                                        <td>{{ $technician->contact_no }}</td>
                                        <td>
                                            L{{ str_pad($technician->TechnicianRegistration?->technician_level_idtechnician_level ?? 0, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            @if ($technician->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#infoTechModal{{ $technician->iduser }}">
                                                Info
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editTechnicianModal{{ $technician->iduser }}">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No technicians found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end px-3 py-2 bg-light border-top">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addTechnicianModal">
                            + Add Technician
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- ========================== MODALS ========================== -->

    <!-- ===== INFO USER MODALS ===== -->
    @foreach ($users as $user)
        <div class="modal fade" id="infoUserModal{{ $user->iduser }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title fw-bold">
                            User Info — {{ ucwords(strtolower($user->first_name)) }}
                            {{ ucwords(strtolower($user->last_name)) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">First Name</small>
                                {{ ucwords(strtolower($user->first_name)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Last Name</small>
                                {{ ucwords(strtolower($user->last_name)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">NIC</small>
                                {{ strtoupper($user->nic) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Date of Birth</small>
                                {{ $user->dob }}
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Address</small>
                                {{ ucwords(strtolower($user->address)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Contact</small>
                                {{ $user->contact_no }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Gender</small>
                                {{ ucfirst(strtolower($user->gender)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Username</small>
                                {{ $user->username }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Role</small>
                                {{ $user->UserRole?->role_name ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status</small>
                                @if ($user->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Start Date</small>
                                {{ $user->created_at?->format('Y-m-d') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- ===== INFO TECHNICIAN MODALS ===== -->
    @foreach ($technicians as $technician)
        <div class="modal fade" id="infoTechModal{{ $technician->iduser }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title fw-bold">
                            Technician Info — {{ ucwords(strtolower($technician->first_name)) }}
                            {{ ucwords(strtolower($technician->last_name)) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">First Name</small>
                                {{ ucwords(strtolower($technician->first_name)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Last Name</small>
                                {{ ucwords(strtolower($technician->last_name)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">NIC</small>
                                {{ strtoupper($technician->nic) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Date of Birth</small>
                                {{ $technician->dob }}
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Address</small>
                                {{ ucwords(strtolower($technician->address)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Contact</small>
                                {{ $technician->contact_no }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Gender</small>
                                {{ ucfirst(strtolower($technician->gender)) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Username</small>
                                {{ $technician->username }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Experience Level</small>
                                L{{ str_pad($technician->TechnicianRegistration?->technician_level_idtechnician_level ?? 0, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status</small>
                                @if ($technician->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Start Date</small>
                                {{ $technician->created_at?->format('Y-m-d') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- ===== ADD USER MODAL ===== -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('userManagement.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIC</label>
                                <input type="text" name="nic" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact_no" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Role</label>
                                <select name="user_role_iduser_role" class="form-select" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->iduser_role }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== EDIT USER MODALS ===== -->
    @foreach ($users as $user)
        <div class="modal fade" id="editUserModal{{ $user->iduser }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('userManagement.update', $user->iduser) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ $user->first_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ $user->last_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIC</label>
                                    <input type="text" name="nic" class="form-control"
                                        value="{{ $user->nic }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">DOB</label>
                                    <input type="date" name="dob" class="form-control"
                                        value="{{ $user->dob }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ $user->address }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact</label>
                                    <input type="text" name="contact_no" class="form-control"
                                        value="{{ $user->contact_no }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control bg-light"
                                        value="{{ $user->created_at?->format('Y-m-d') }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Role</label>
                                    <select name="user_role_iduser_role" class="form-select">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->iduser_role }}"
                                                {{ $user->user_role_iduser_role == $role->iduser_role ? 'selected' : '' }}>
                                                {{ $role->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ $user->username }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Leave blank to keep current">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- ===== ADD TECHNICIAN MODAL ===== -->
    <div class="modal fade" id="addTechnicianModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Add Technician</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('userManagement.storeTechnician') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIC</label>
                                <input type="text" name="nic" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact_no" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Experience Level</label>
                                <select name="experience_level" class="form-select" required>
                                    <option value="">Select Level</option>
                                    @foreach ($technicianLevels as $level)
                                        <option value="{{ $level->idtechnician_level }}">
                                            L{{ str_pad($level->idtechnician_level, 2, '0', STR_PAD_LEFT) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Technician</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== EDIT TECHNICIAN MODALS ===== -->
    @foreach ($technicians as $technician)
        <div class="modal fade" id="editTechnicianModal{{ $technician->iduser }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Technician</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('userManagement.updateTechnician', $technician->iduser) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ $technician->first_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ $technician->last_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIC</label>
                                    <input type="text" name="nic" class="form-control"
                                        value="{{ $technician->nic }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">DOB</label>
                                    <input type="date" name="dob" class="form-control"
                                        value="{{ $technician->dob }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ $technician->address }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact</label>
                                    <input type="text" name="contact_no" class="form-control"
                                        value="{{ $technician->contact_no }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ $technician->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ $technician->gender == 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control bg-light"
                                        value="{{ $technician->created_at?->format('Y-m-d') }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Experience Level</label>
                                    <select name="experience_level" class="form-select">
                                        @foreach ($technicianLevels as $level)
                                            <option value="{{ $level->idtechnician_level }}"
                                                {{ $technician->TechnicianRegistration?->technician_level_idtechnician_level == $level->idtechnician_level ? 'selected' : '' }}>
                                                L{{ str_pad($level->idtechnician_level, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $technician->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $technician->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ $technician->username }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Leave blank to keep current">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Technician</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
