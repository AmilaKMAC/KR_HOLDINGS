@extends('layout.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ================= PAGE TITLE ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4 class="fw-bold mb-0">Assigned Project List</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= PROJECT TABLE ================= -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

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
                                        <button class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
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
                                        <button class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cancelModal">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- ================= BOTTOM CONTROLS ================= -->
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <!-- LIMIT BUTTON GROUP -->
                        <div class="btn-group" role="group">
                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm limit-btn active"
                                    data-limit="5">
                                5
                            </button>

                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm limit-btn"
                                    data-limit="10">
                                10
                            </button>

                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm limit-btn"
                                    data-limit="20">
                                20
                            </button>

                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm limit-btn"
                                    data-limit="all">
                                All
                            </button>
                        </div>

                        <!-- SHOWING INFO -->
                        <div class="text-muted small">
                            Showing 1 to 3 of 3 entries
                        </div>

                    </div>
                    <!-- ==================================================== -->

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
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label fw-semibold">Reason for Cancellation</label>
                <textarea class="form-control"
                          rows="4"
                          placeholder="Enter cancellation reason..."></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary"
                        data-bs-dismiss="modal">
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