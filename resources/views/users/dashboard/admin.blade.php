@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- ===================================================== TOP SECTION ====================================================== -->
    <div class="row mb-4 align-items-stretch">

        <!-- ================= NO OF USERS CARD ================= -->
        <div class="col-12 col-lg-4 mb-3">

            <!-- CARD TITLE  -->
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center bg-success text-white">
                    <h4 class="fw-bold mb-0">No of Users</h4>
                </div>
            </div>

            <!-- COUNT CARD -->
            <div class="card shadow-sm h-auto">
                <div class="card-body d-flex flex-column justify-content-center text-center ">
                    <h1 class="display-2 fw-bold text-success mb-0">24</h1>
                    <small class="text-muted">Total Registered Users</small>
                </div>
            </div>

        </div>

        <!-- ================= ACTIVE USERS TABLE ================= -->
        <div class="col-12 col-lg-8">

            <!-- SECTION TITLE -->
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center bg-primary text-white">
                    <h4 class="fw-bold mb-0">Active Users</h4>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>User Id</th>
                                    <th>Role</th>
                                    <th>Login Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td>Admin</td>
                                    <td>08:30 AM</td>
                                </tr>
                                <tr>
                                    <td>002</td>
                                    <td>User</td>
                                    <td>09:10 AM</td>
                                </tr>
                                <tr>
                                    <td>003</td>
                                    <td>Technician</td>
                                    <td>09:45 AM</td>
                                </tr>
                                <tr>
                                    <td>004</td>
                                    <td>Manager</td>
                                    <td>10:05 AM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- ================================================ STORAGE SECTION ==================================================== -->

    <div class="card shadow-sm mb-3">
        <div class="card-body text-center bg-secondary text-white">
            <h4 class="fw-bold mb-0">Storage Overview</h4>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-1">
                        <span>Used</span>
                        <span>Available</span>
                    </div>

                    <div class="progress" style="height:25px;">
                        <div class="progress-bar bg-primary" style="width:40%">
                            40% Used
                        </div>
                        <div class="progress-bar bg-light text-dark" style="width:60%">
                            60% Available
                        </div>
                    </div>

                    <div class="text-center mt-3 fw-bold">
                        Available Storage: 120GB
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- ============================================= CHART SECTION ============================================================ -->

    <div class="card shadow-sm mb-3">
        <div class="card-body text-center bg-dark text-white">
            <h4 class="fw-bold mb-0">System Analytics</h4>
        </div>
    </div>

    <div class="row">

        <!-- Storage Chart -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body" style="height:350px;">
                    <h6 class="text-center">Storage Usage</h6>
                    <canvas id="storageChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Backup Chart -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body" style="height:350px;">
                    <h6 class="text-center">Monthly Backups</h6>
                    <canvas id="backupChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>


<!-- Chart Script (Local File) -->
<script src="{{ asset('assets/bootstrap/js/chart.umd.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const storageCtx = document.getElementById('storageChart');
    new Chart(storageCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Storage Usage (GB)',
                data: [20, 35, 30, 50, 60, 80],
                borderWidth: 2,
                tension: 0.4
            }]
        }
    });

    const backupCtx = document.getElementById('backupChart');
    new Chart(backupCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Backups',
                data: [5, 8, 6, 10, 12, 9],
                borderWidth: 1
            }]
        }
    });

});
</script>

@endsection