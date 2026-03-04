@extends('layout.app')

@section('content')
    <div class="container-fluid px-2 px-md-4 px-lg-5">

        <!-- ================= USER REGISTRATION Table ================= -->
        <div class="row mb-5">
            <div class="col-12">

                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center bg-dark text-white">
                        <h5 class="fw-bold mb-0">User Registration</h5>
                    </div>
                </div>

                <div class="card shadow-sm">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>UID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>NIC</th>
                                    <th>DOB</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Gender</th>
                                    <th>Start Date</th>
                                    <th>Role</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td>Admin</td>
                                    <td>Perera</td>
                                    <td>123456789V</td>
                                    <td>1995-01-01</td>
                                    <td>Colombo</td>
                                    <td>0771234567</td>
                                    <td>Male</td>
                                    <td>2024-01-01</td>
                                    <td>Admin</td>
                                    <td>admin</td>
                                    <td>*****</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editUserModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="14" class="bg-light">
                                        <div class="d-flex justify-content-end p-1">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#addUserModal" w-25>
                                                + Add User
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= TECHNICIAN REGISTRATION Table ================= -->
        <div class="row mb-5">
            <div class="col-12">

                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center bg-secondary text-white">
                        <h5 class="fw-bold mb-0">Technician Registration</h5>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>UID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>NIC</th>
                                    <th>DOB</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Gender</th>
                                    <th>Start Date</th>
                                    <th>Experience Level</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>002</td>
                                    <td>Tech</td>
                                    <td>Silva</td>
                                    <td>987654321V</td>
                                    <td>1998-05-10</td>
                                    <td>Kandy</td>
                                    <td>0712345678</td>
                                    <td>Male</td>
                                    <td>2024-02-01</td>
                                    <td>L02</td>
                                    <td>tech01</td>
                                    <td>*****</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editTechnicianModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="14" class="bg-light">
                                        <div class="d-flex justify-content-end p-1">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#addTechnicianModal" w-25>
                                                + Add Technician
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>



    <!-- ========================== MODALS ===================== -->

    <!-- ADD USER MODAL -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NIC</label>
                                <input type="text" name="nic" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
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
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Executive">Executive</option>
                                    <option value="Project Coordinator">Project Coordinator</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
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


    <!-- EDIT USER MODAL -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="Admin" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="Perera" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NIC</label>
                                <input type="text" name="nic" class="form-control" value="123456789V" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control" value="1995-01-01" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="Colombo" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control" value="0771234567" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="2024-01-01"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Executive">Executive</option>
                                    <option value="Project Coordinator">Project Coordinator</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="admin" required>
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


    <!-- ADD TECHNICIAN MODAL -->
    <div class="modal fade" id="addTechnicianModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Technician</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NIC</label>
                                <input type="text" name="nic" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
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
                                    <option value="L01">L01</option>
                                    <option value="L02">L02</option>
                                    <option value="L03">L03</option>

                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
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


    <!-- EDIT TECHNICIAN MODAL -->
    <div class="modal fade" id="editTechnicianModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Technician</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="Tech" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="Silva" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NIC</label>
                                <input type="text" name="nic" class="form-control" value="987654321V" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control" value="1998-05-10" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="Kandy" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control" value="0712345678" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="2024-02-01"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Experience Level</label>
                                <select name="experience_level" class="form-select" required>
                                    <option value="L01">L01</option>
                                    <option value="L02">L02</option>
                                    <option value="L03">L03</option>
                                    <option value="L04">L04</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="tech01" required>
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
@endsection
