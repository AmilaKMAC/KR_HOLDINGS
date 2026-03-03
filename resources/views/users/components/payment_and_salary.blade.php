@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- ================= PAGE TITLE ================= -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h4 class="fw-bold mb-0">Payment & Salary Management</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TECHNICIAN DETAILS TABLE ================= -->
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-11">
                <div class="card shadow-sm">
                    <div class="card-header fw-semibold text-center">
                        Technician Details
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Technician ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Total Payment</th>
                                    <th>Payment Status</th>
                                    <th>Update Payment</th>
                                    <th>View Bills</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>T01</td>
                                    <td>Kamal</td>
                                    <td>2024-10-05</td>
                                    
                                    <td>75,000 LKR</td>

                                    <td>
                                        <span class="badge bg-warning text-dark status-badge">
                                            Pending
                                        </span>
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-primary update-btn">
                                            Update
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success view-btn">
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


    <!-- ================= SALARY BILL MODAL ================= -->
    <div class="modal fade" id="billModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow">

                <div class="modal-header">
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
                                        <span class="badge bg-warning text-dark status-badge">
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
                                    <th>Update</th>
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
                                        <span class="badge bg-success status-badge">
                                            Paid
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary update-btn">
                                            Update
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


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ================= STATUS TOGGLE (ALL TABLES) =================
            document.querySelectorAll('.update-btn').forEach(button => {

                button.addEventListener('click', function() {

                    let badge = this.closest('tr').querySelector('.status-badge');

                    if (!badge) return;

                    if (badge.textContent.trim() === "Pending") {
                        badge.textContent = "Paid";
                        badge.classList.remove('bg-warning', 'text-dark');
                        badge.classList.add('bg-success');
                    } else {
                        badge.textContent = "Pending";
                        badge.classList.remove('bg-success');
                        badge.classList.add('bg-warning', 'text-dark');
                    }

                });

            });

            // ================= VIEW MODAL =================
            const modal = new bootstrap.Modal(document.getElementById('billModal'));

            document.querySelectorAll('.view-btn').forEach(button => {
                button.addEventListener('click', function() {
                    modal.show();
                });
            });

        });
    </script>
@endsection
