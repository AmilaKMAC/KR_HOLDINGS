@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- ================= PROFILE SECTION ================= -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <!-- Profile Image -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle border mx-auto d-flex align-items-center justify-content-center"
                                style="width:150px; height:150px;">
                                <i class="bi bi-person" style="font-size:70px;"></i>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="row justify-content-center mb-4">

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" class="form-control" value="Technician Name" readonly>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Technician ID</label>
                                <input type="text" class="form-control" value="TECH-001" readonly>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Start Date</label>
                                <input type="text" class="form-control" value="2024-01-01" readonly>
                            </div>

                        </div>

                        <!-- ================= PAYMENT DETAILS ================= -->
                        <div class="card">
                            <div class="card-header text-center fw-bold bg-dark text-white">
                                Payment Details
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle mb-0 data-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Month</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>75,000 LKR</td>
                                                <td>
                                                    <span class="badge bg-warning text-dark">
                                                        Pending
                                                    </span>
                                                </td>
                                                <td>October</td>
                                                <td>2024-10-05</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#billModal">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>65,000 LKR</td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        Paid
                                                    </span>
                                                </td>
                                                <td>September</td>
                                                <td>2024-09-05</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#billModal">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- ==================================================== -->

                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- ================= SALARY BILL MODAL ================= -->
    <div class="modal fade" id="billModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-semibold">
                        Technician Payment History
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- ================= CURRENT PAYMENT ================= -->
                    <h6 class="fw-bold text-primary mb-3">Current Payment Details</h6>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Basic Salary</th>
                                    <th>Additional Work</th>
                                    <th>Solar Rate</th>
                                    <th>Others</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2024-10-05</td>
                                    <td>50,000</td>
                                    <td>10,000</td>
                                    <td>8,000</td>
                                    <td>7,000</td>
                                    <td><strong>75,000</strong></td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- ================= PREVIOUS BILLS ================= -->
                    <h6 class="fw-bold text-success mb-3">Previous Bills</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle data-table">

                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Basic Salary</th>
                                    <th>Additional Work</th>
                                    <th>Solar Rate</th>
                                    <th>Others</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>2024-09-05</td>
                                    <td>50,000</td>
                                    <td>5,000</td>
                                    <td>6,000</td>
                                    <td>4,000</td>
                                    <td><strong>65,000</strong></td>
                                    <td>
                                        <span class="badge bg-success">
                                            Paid
                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <!-- Bottom Controls -->
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border">
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- ====================================================== -->
@endsection
