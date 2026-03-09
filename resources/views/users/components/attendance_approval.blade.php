@extends('layout.app')

@section('content')
    <div class="container-fluid px-2 px-md-4 px-lg-5">

        <!-- ================= ATTENDANCE TABLE ================= -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm">

                    <div class="card-header text-center fw-bold bg-dark text-white">
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

                                    <!-- Attendance badge — updated by JS when YES/NO clicked -->
                                    <td>
                                        <span class="attendance-badge badge bg-secondary">Not Marked</span>
                                    </td>

                                    <!-- Approve button — toggles attendance badge -->
                                    <td>
                                        <button class="btn btn-sm btn-success approve-btn">Approve</button>
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

                                <tr>
                                    <td>T02</td>
                                    <td>Nimal</td>
                                    <td>2024-10-05</td>
                                    <td>
                                        <span class="attendance-badge badge bg-secondary">Not Marked</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success approve-btn">Approve</button>
                                    </td>
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

                    <!-- Bottom Controls -->
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-top">
                        @include('others.limit_btn_group')
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- ================= APPROVE / CHANGE ATTENDANCE MODAL ================= -->
    <div class="modal fade" id="attendanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Change Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body text-center">

                        <p class="fw-bold mb-4">Select Attendance Status</p>

                        <button type="button" class="btn btn-success me-3 px-4" id="attendanceYesBtn">YES</button>
                        <button type="button" class="btn btn-danger px-4"        id="attendanceNoBtn">NO</button>

                    </div>

                </form>

            </div>
        </div>
    </div>


    <!-- ================= VIEW PREVIOUS ATTENDANCE MODAL ================= -->
    <div class="modal fade" id="viewAttendanceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Previous Attendance Records</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
                                    <td><span class="badge bg-success">Yes</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning open-attendance-modal"
                                            data-context="change"
                                            data-source-modal="viewAttendanceModal">
                                            Change
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2024-09-30</td>
                                    <td><span class="badge bg-danger">No</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning open-attendance-modal"
                                            data-context="change"
                                            data-source-modal="viewAttendanceModal">
                                            Change
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <script>

        // ── Approve button — cycles: Not Marked → Yes → No → Yes … ──────────────────
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const badge = this.closest('tr').querySelector('.attendance-badge');
                if (badge.innerText.trim() === 'Not Marked' || badge.innerText.trim() === 'No') {
                    badge.className = 'attendance-badge badge bg-success';
                    badge.innerText = 'Yes';
                } else {
                    badge.className = 'attendance-badge badge bg-danger';
                    badge.innerText = 'No';
                }
            });
        });

        // ── Change button inside viewAttendanceModal — hide view modal, show change modal ──
        document.querySelectorAll('.open-attendance-modal').forEach(btn => {
            btn.addEventListener('click', function () {
                const sourceEl = document.getElementById(this.dataset.sourceModal);
                bootstrap.Modal.getInstance(sourceEl)?.hide();
                sourceEl.addEventListener('hidden.bs.modal', function handler() {
                    new bootstrap.Modal(document.getElementById('attendanceModal')).show();
                    sourceEl.removeEventListener('hidden.bs.modal', handler);
                });
            });
        });

        // ── YES/NO inside attendanceModal — just close it ────────────────────────────
        document.getElementById('attendanceYesBtn').addEventListener('click', function () {
            bootstrap.Modal.getInstance(document.getElementById('attendanceModal'))?.hide();
        });

        document.getElementById('attendanceNoBtn').addEventListener('click', function () {
            bootstrap.Modal.getInstance(document.getElementById('attendanceModal'))?.hide();
        });

    </script>

@endsection