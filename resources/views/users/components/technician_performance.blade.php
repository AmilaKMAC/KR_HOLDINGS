@extends('layout.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ================= PAGE TITLE ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4 class="mb-0 fw-bold">Technician Performance</h4>
                </div>
            </div>
        </div>
    </div>


    <!-- ================= TECHNICIAN COMPLETION OF WORK ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Technician Completion of Work
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Technician Name</th>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Completion Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>T001</td>
                                <td>John Silva</td>
                                <td>P101</td>
                                <td>ABC Pvt Ltd</td>
                                <td>Colombo</td>
                                <td>High</td>
                                <td>2026-02-15</td>
                            </tr>
                            <tr>
                                <td>T002</td>
                                <td>Kasun Perera</td>
                                <td>P102</td>
                                <td>XYZ Holdings</td>
                                <td>Kandy</td>
                                <td>Medium</td>
                                <td>2026-02-18</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- ================= COMPLETION RATE ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Completion Rate
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Technician Name</th>
                                <th>Assigned Projects</th>
                                <th>Completed Projects</th>
                                <th>Completion Rate (%)</th>
                                <th>Time Frame</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>T001</td>
                                <td>John Silva</td>
                                <td>10</td>
                                <td>9</td>
                                <td>90%</td>
                                <td>Jan 2026</td>
                            </tr>
                            <tr>
                                <td>T002</td>
                                <td>Kasun Perera</td>
                                <td>8</td>
                                <td>6</td>
                                <td>75%</td>
                                <td>Jan 2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- ================= ATTENDANCE RELIABILITY ================= -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Attendance Reliability
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Technician Name</th>
                                <th>Total Workdays</th>
                                <th>Present Days</th>
                                <th>Attendance Reliability (%)</th>
                                <th>Time Frame</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>T001</td>
                                <td>John Silva</td>
                                <td>22</td>
                                <td>21</td>
                                <td>95%</td>
                                <td>Jan 2026</td>
                            </tr>
                            <tr>
                                <td>T002</td>
                                <td>Kasun Perera</td>
                                <td>22</td>
                                <td>19</td>
                                <td>86%</td>
                                <td>Jan 2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection