@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- ================= PROJECT TABLE ================= -->
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card shadow-sm">
                    <div class="card-header text-center fw-bold bg-dark text-white">
                        Projects Details
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Project ID</th>
                                    <th>Customer Name</th>
                                    <th>Location</th>
                                    <th>Contact</th>
                                    <th>Capacity</th>
                                    <th>Partner</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>P01</td>
                                    <td>SK Lal</td>
                                    <td>Colombo</td>
                                    <td>076xxxxxxx</td>
                                    <td>5kW</td>
                                    <td>Hayleys</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>P02</td>
                                    <td>RS Silva</td>
                                    <td>Gampaha</td>
                                    <td>070xxxxxxx</td>
                                    <td>10kW</td>
                                    <td>Hayleys</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>-</td>
                                </tr>

                                <tr>
                                    <td>P03</td>
                                    <td>AJ Rahal</td>
                                    <td>Kandy</td>
                                    <td>071xxxxxxx</td>
                                    <td>7kW</td>
                                    <td>Hayleys</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal">
                                            Cancel
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


    <!-- ================= CANCELLATION MODAL ================= -->
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Cancel Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label fw-semibold">Reason for Cancellation</label>
                    <textarea class="form-control" rows="4" placeholder="Enter cancellation reason..."></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-danger">
                        Confirm Cancel
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- ====================================================== -->
@endsection
