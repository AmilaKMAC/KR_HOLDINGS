@extends('layout.app')

@section('content')
<div class="container-fluid px-2 px-md-4 px-lg-5">

    <!-- ================= ATTENDANCE TABLE ================= -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">

                <div class="card-header text-center fw-bold">
                    Technician Attendance Management
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Attendance</th>
                                <th>Approval</th>
                                <th>Previous Attendance</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>T01</td>
                                <td>Kamal</td>
                                <td>2024-10-05</td>

                                <!-- Attendance Status -->
                                <td>
                                    <span class="badge bg-secondary">Not Marked</span>
                                </td>

                                <!-- Approve Button -->
                                <td>
                                    <button class="btn btn-sm btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#attendanceModal">
                                        Approve
                                    </button>
                                </td>

                                <!-- View Previous -->
                                <td>
                                    <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewAttendanceModal">
                                        View
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

</div>



<!-- ================= APPROVE / CHANGE ATTENDANCE MODAL ================= -->
<div class="modal fade" id="attendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Approve / Change Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body text-center">

                    <p class="fw-bold mb-4">
                        Select Attendance Status
                    </p>

                    <!-- YES BUTTON -->
                    <button type="submit"
                        name="attendance"
                        value="Yes"
                        class="btn btn-success me-3 px-4">
                        YES
                    </button>

                    <!-- NO BUTTON -->
                    <button type="submit"
                        name="attendance"
                        value="No"
                        class="btn btn-danger px-4">
                        NO
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>



<!-- ================= VIEW PREVIOUS ATTENDANCE MODAL ================= -->
<div class="modal fade" id="viewAttendanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Previous Attendance Records</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Attendance</th>
                                <th>Edit</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>2024-10-01</td>
                                <td>
                                    <span class="badge bg-success">Yes</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#attendanceModal">
                                        Change
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2024-09-30</td>
                                <td>
                                    <span class="badge bg-danger">No</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#attendanceModal">
                                        Change
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

@endsection