@extends('layout.app')

@section('content')

<div class="container-fluid mt-4">

    <!-- ================= HEADER ================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <h3 class="fw-bold">Project Coordinator Dashboard</h3>
        </div>
    </div>


    <!-- ================= KPI SECTION ================= -->
    <div class="row mb-4">

        <div class="col-md-6">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Ongoing Projects</h6>
                    <h2 class="fw-bold text-primary">12</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Completed Projects</h6>
                    <h2 class="fw-bold text-success">35</h2>
                </div>
            </div>
        </div>

    </div>


    <!-- ================= AVAILABLE TECHNICIANS ================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">
            Available Technicians
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Technician ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>T04</td>
                            <td>Supun</td>
                        </tr>
                        <tr>
                            <td>T06</td>
                            <td>Anuhas</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- ================= PROJECT OVERVIEW ================= -->
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">
            Project Overview
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Project ID</th>
                            <th>Customer Name</th>
                            <th>Location</th>
                            <th>Contact Number</th>
                            <th>Capacity</th>
                            <th>Partner Company</th>
                            <th>Assigned Technician ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>P01</td>
                            <td>SK Lal</td>
                            <td>Colombo</td>
                            <td>076xxxxxx</td>
                            <td>5kW</td>
                            <td>Hayleys</td>
                            <td>T01, T02</td>
                        </tr>
                        <tr>
                            <td>P02</td>
                            <td>RS Silva</td>
                            <td>Kandy</td>
                            <td>070xxxxxx</td>
                            <td>10kW</td>
                            <td>Hayleys</td>
                            <td>T01, T03, T05</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection