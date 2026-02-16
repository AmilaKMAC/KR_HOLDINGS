@extends('layout.app')


@section('content')
    <div class="container py-4">

        <!-- ===================== TOP SECTION ===================== -->
        <div class="row mb-4 align-items-start">

            <!-- No of Users Box -->
            <div class="col-12 col-lg-3 mb-3 mb-lg-0 d-flex justify-content-center">
                <div class="card text-bg-success mb-3 text-center" style="max-width: 18rem;">
                    <div class="card-header">No of Users</div>
                    <div class="card-body">
                        <h5 class="card-title">3</h5>
                    </div>
                </div>
            </div>

            <!-- Active Users Table -->
            <div class="col-12 col-lg-9">
                <div class="border">

                    <div class="bg-light border-bottom p-2 fw-bold text-center">
                        Active Users
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 text-center">
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
                                    <td>Technician 1</td>
                                    <td>09:45 AM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <hr class="mt-5 mb-5">

        <!-- ===================== STORAGE SECTION ===================== -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">

                <div class="border p-3">

                    <div class="d-flex justify-content-between mb-1">
                        <span>Used</span>
                        <span>Available</span>
                    </div>

                    <div class="progress" style="height:25px;">
                        <div class="progress-bar bg-primary" style="width:30%"></div>
                        <div class="progress-bar bg-light text-dark" style="width:70%">Available</div>
                    </div>

                    <div class="text-center mt-2 fw-bold">
                        Available Storage
                    </div>

                </div>
            </div>
        </div>


        <hr class="mt-5 mb-5">
        <!-- ===================== CHART SECTION ===================== -->
        <div class="row">

            

            <!-- Storage Usage Chart -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="border p-3" style="height:350px;">
                    <h6 class="text-center">Storage Usage</h6>
                    <canvas id="storageChart"></canvas>
                </div>
            </div>

            <!-- Monthly Backups Chart -->
            <div class="col-12 col-lg-6">
                <div class="border p-3" style="height:350px;">
                    <h6 class="text-center">Monthly Backups</h6>
                    <canvas id="backupChart"></canvas>
                </div>
            </div>

        </div>


    </div>

    <!-- Load The Chart -->

    {{-- 
        <script src="{{ asset('assets/js/chart.js') }}"></script>
    --}}

    <script src="{{ asset('assets/js/chart.umd.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Line Chart
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

            // Bar Chart
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
