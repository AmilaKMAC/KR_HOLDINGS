@extends('layout.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ================= PAGE TITLE ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4 class="fw-bold mb-0">Profile</h4>
                </div>
            </div>
        </div>
    </div>

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
                            <!-- If not using Bootstrap Icons, replace with image:
                            <img src="{{ asset('images/profile.png') }}" 
                                 class="img-fluid rounded-circle"> -->

                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="row justify-content-center mb-4">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" class="form-control"
                                   value="Technician Name" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Technician ID</label>
                            <input type="text" class="form-control"
                                   value="TECH-001" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Start Date</label>
                            <input type="text" class="form-control"
                                   value="2024-01-01" readonly>
                        </div>

                    </div>

                    <!-- ================= PAYMENT DETAILS ================= -->
                    <div class="card">
                        <div class="card-header text-center fw-bold">
                            Payment Details
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Month</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>50,000 LKR</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    Paid
                                                </span>
                                            </td>
                                            <td>January</td>
                                            <td>2025-01-30</td>
                                        </tr>

                                        <tr>
                                            <td>50,000 LKR</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    Pending
                                                </span>
                                            </td>
                                            <td>February</td>
                                            <td>-</td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ================================================ -->

                </div>
            </div>
        </div>
    </div>

</div>

@endsection