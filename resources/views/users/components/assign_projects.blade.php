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
                <div class="card-body table-responsive">

                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Contact Number</th>
                                <th>Capacity</th>
                                <th>Partner Company</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>P01</td>
                                <td>SK Lal</td>
                                <td>URL</td>
                                <td>076xxxx</td>
                                <td>5kW</td>
                                <td>Hayleys</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#cancelModal">
                                        Cancel
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>P02</td>
                                <td>RS Silva</td>
                                <td>URL</td>
                                <td>070xxxx</td>
                                <td>10kW</td>
                                <td>Hayleys</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#cancelModal">
                                        Cancel
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>P04</td>
                                <td>AJ Rahal</td>
                                <td>URL</td>
                                <td>070xxxx</td>
                                <td>10kW</td>
                                <td>Hayleys</td>
                                <td>
                                    <span class="badge bg-success">Completed</span>
                                </td>
                                <td>-</td>
                            </tr>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

</div>


<!-- ================= CANCEL REASON MODAL ================= -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Enter Cancel Reason</label>
                    <textarea class="form-control" rows="4" placeholder="Type reason here..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">OK</button>
            </div>

        </div>
    </div>
</div>

@endsection