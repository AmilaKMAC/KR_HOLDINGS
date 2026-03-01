@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- ================= PAGE TITLE ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h4 class="fw-bold mb-0">Technician Dashboard</h4>
                </div>
            </div>
        </div>
    </div>


    <!-- ================= TOP ACTION BUTTONS ================= -->
    <div class="d-flex justify-content-end align-items-center gap-3 mb-4">

        <button class="btn btn-outline-dark">
            Upload Images
        </button>

        <button class="btn btn-outline-dark">
            Attendance Reminder
        </button>

        <div class="rounded-circle border d-flex justify-content-center align-items-center"
             style="width:60px; height:60px;">
            Profile
        </div>

    </div>


    <!-- ================= ONGOING PROJECTS ================= -->
    <div class="card shadow-sm mb-5">
        <div class="card-header fw-semibold text-center">
            Ongoing Projects
        </div>

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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>P01</td>
                        <td>SK Lal</td>
                        <td>URL</td>
                        <td>076xxxxx</td>
                        <td>5kW</td>
                        <td>Hayleys</td>
                    </tr>
                    <tr>
                        <td>P02</td>
                        <td>RS Silva</td>
                        <td>URL</td>
                        <td>070xxxxx</td>
                        <td>10kW</td>
                        <td>Hayleys</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!-- ================= ATTENDANCE KPI BOXES ================= -->
    <div class="row g-4 mb-5 text-center">

        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold">Working Days</h6>
                    <h3 class="fw-bold">22</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold">Absent Days</h6>
                    <h3 class="fw-bold">2</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold">Attendance Reliability</h6>
                    <h3 class="fw-bold text-primary">91%</h3>
                </div>
            </div>
        </div>

    </div>


    <!-- ================= PERFORMANCE SUMMARY ================= -->
    <div class="card shadow-sm mb-5">
        <div class="card-body text-center">
            <div class="row">

                <div class="col-md-4">
                    <h6 class="fw-semibold">Ongoing Projects</h6>
                    <h4 class="fw-bold">3</h4>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-semibold">Completed Projects</h6>
                    <h4 class="fw-bold">25</h4>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-semibold">Project Completion Rate</h6>
                    <h4 class="fw-bold text-success">89%</h4>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection