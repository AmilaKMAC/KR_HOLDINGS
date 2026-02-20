@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- ================= Technician Level ================= -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center fw-bold">
                        Technician Level
                    </div>
                    <div class="card-body p-0 table-responsive ">
                        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0 ">
                            <thead class="table-light">
                                <tr>
                                    <th>Level</th>
                                    <th>Basic Salary</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>L01</td>
                                    <td>25000</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editTechnicianModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3" class="bg-light">
                                        <div class="d-flex justify-content-end ">
                                            <button type="button" class="btn btn-success p-1 w-25" data-bs-toggle="modal"
                                                data-bs-target="#addTechnicianModal">
                                                + Add
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


        <!-- ================= Solar ================= -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center fw-bold">
                        Solar
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Capacity</th>
                                    <th>Rate</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>C01</td>
                                    <td>1-3 kW</td>
                                    <td>500</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editSolarModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="bg-light">
                                        <div class="d-flex justify-content-end ">
                                            <button type="button" class="btn btn-success p-1 w-25" data-bs-toggle="modal"
                                                data-bs-target="#addSolarModal">
                                                + Add
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <!-- ================= Additional Work ================= -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center fw-bold">
                        Additional Work
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th>Rate</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Panel Lifting</td>
                                    <td>200</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editWorkModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="bg-light">
                                        <div class="d-flex justify-content-end ">
                                            <button type="button" class="btn btn-success p-1 w-25" data-bs-toggle="modal"
                                                data-bs-target="#addWorkModal">
                                                + Add
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


        <!-- ================= Partner Company ================= -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header text-center fw-bold">
                        Partner Company
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Partner ID</th>
                                    <th>Company Name</th>
                                    <th>Status</th>
                                    <th>Date Added</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P01</td>
                                    <td>Hayleys</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>2023-02-15</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editPartnerModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="bg-light">
                                        <div class="d-flex justify-content-end ">
                                            <button type="button" class="btn btn-success w-25" data-bs-toggle="modal"
                                                data-bs-target="#addPartnerModal">
                                                + Add
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


    <!-- ======================= MODALS ======================= -->

    <!-- Add Technician Modal -->
    <div class="modal fade" id="addTechnicianModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Technician Level</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" placeholder="Level">
                    <input type="number" class="form-control" placeholder="Basic Salary">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Technician Modal -->
    <div class="modal fade" id="editTechnicianModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Technician</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" value="L01">
                    <input type="number" class="form-control" value="25000">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Solar Modal -->
    <div class="modal fade" id="addSolarModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Solar Rate</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-2" placeholder="ID">
                    <input class="form-control mb-2" placeholder="Capacity">
                    <input class="form-control" placeholder="Rate">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Solar Modal -->
    <div class="modal fade" id="editSolarModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Solar</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-2" value="C01">
                    <input class="form-control mb-2" value="1-3 kW">
                    <input class="form-control" value="500">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Additional Work Modal -->
    <div class="modal fade" id="addWorkModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Additional Work</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-2" placeholder="Description">
                    <input class="form-control" placeholder="Rate">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Additional Work Modal -->
    <div class="modal fade" id="editWorkModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Work</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-2" value="Panel Lifting">
                    <input class="form-control" value="200">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Partner Modal -->
    <div class="modal fade" id="addPartnerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add New Partner</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-2" placeholder="Partner ID">
                    <input class="form-control mb-2" placeholder="Company Name">
                    <select class="form-control mb-2">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                    <input type="date" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Partner Modal -->
    <div class="modal fade" id="editPartnerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Partner</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-2" value="P01">
                    <input class="form-control mb-2" value="Hayleys">
                    <select class="form-control mb-2">
                        <option selected>Active</option>
                        <option>Inactive</option>
                    </select>
                    <input type="date" class="form-control" value="2023-02-15">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection
