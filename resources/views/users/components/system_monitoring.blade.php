@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-grid gap-4 col-8 mx-auto">

            <button class="btn btn-dark p-4" data-bs-toggle="modal" data-bs-target="#activeUsersModal">
                Active Users
            </button>

            <button class="btn btn-primary p-4" data-bs-toggle="modal" data-bs-target="#dataBackupModal">
                Data Backups
            </button>

            <button class="btn btn-secondary p-4" data-bs-toggle="modal" data-bs-target="#storageUsageModal">
                Storage Usage
            </button>

        </div>
    </div>


    <!-- ================================================== MODALS ========================================================== -->

    <!-- LOGIN HISTORY Modal -->
    <div class="modal fade" id="activeUsersModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold">Active Users</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>UID</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Login Time</th>
                                <th>Device</th>
                                <th>IP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($active_users as $active_user)
                                <tr>
                                    <td>
                                        @if ($active_user->UserRegistration)
                                            U{{ str_pad($active_user->UserRegistration->iduser_registration, 3, '0', STR_PAD_LEFT) }}
                                        @else
                                            T{{ str_pad($active_user->TechnicianRegistration->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                        @endif
                                    </td>
                                    <td>{{ $active_user->User->username }}</td>
                                    <td>{{ $active_user->UserRole->role_name ?? 'N/A' }}</td>
                                    <td>{{ $active_user->login_time }}</td>
                                    <td>{{ $active_user->device }}</td>
                                    <td>{{ $active_user->ip_address }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#logoutModal">
                                            Logout
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data found.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Confirm Logout</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to logout this user?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">No</button>
                    <button class="btn btn-danger btn-sm">Yes, Logout</button>
                </div>

            </div>
        </div>
    </div>

    <!--  Data Backup Modal  -->
    <div class="modal fade" id="dataBackupModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-4">

                <div class="modal-header border-0">
                    <h5 class="fw-bold">Data Backup Management</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered text-center align-middle">
                        <tbody>
                            <tr>
                                <td>User Data</td>
                                <td><button class="btn btn-outline-dark btn-sm">Backup</button></td>
                            </tr>
                            <tr>
                                <td>Project Data</td>
                                <td><button class="btn btn-outline-dark btn-sm">Backup</button></td>
                            </tr>
                            <tr>
                                <td>Attendance Records</td>
                                <td><button class="btn btn-outline-dark btn-sm">Backup</button></td>
                            </tr>
                            <tr>
                                <td>Payment Summaries</td>
                                <td><button class="btn btn-outline-dark btn-sm">Backup</button></td>
                            </tr>
                            <tr>
                                <td>Uploaded Photos</td>
                                <td><button class="btn btn-outline-dark btn-sm">Backup</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-4 p-3">

                        <button class="btn btn-dark m-2">Backup All</button>
                        <button class="btn btn-outline-primary m-2">Download Backup</button>

                        <button class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#backupScheduleModal">
                            Set Backup Schedule
                        </button>

                        <button class="btn btn-success m-2">Restore Data</button>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Backup Schedule Modal -->
    <div class="modal fade" id="backupScheduleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">

                <div class="modal-header border-0">
                    <h5 class="fw-bold">Set Backup Schedule</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">

                    <label class="mb-2">Select Frequency</label>
                    <select class="form-select w-75 mx-auto mb-3">
                        <option>Daily</option>
                        <option>Weekly</option>
                        <option>Monthly</option>
                    </select>

                    <label class="mb-2">Select Time</label>
                    <input type="time" class="form-control w-75 mx-auto">

                </div>

                <div class="modal-footer border-0 justify-content-center">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save Schedule</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Storage Usage Modal -->
    <div class="modal fade" id="storageUsageModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content p-5">

                <div class="modal-header border-0">
                    <h4 class="fw-bold">Storage Management</h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- Pie Chart -->
                        <div class="col-md-6 text-center">

                            <div style="height:300px;">
                                <canvas id="pieChart"></canvas>
                            </div>

                            <div class="border p-3 mt-4 d-flex justify-content-between align-items-center">
                                <span class="fs-5">Storage Usage</span>
                                <input type="number" id="usedStorage" class="form-control w-25 text-center"
                                    value="10">
                            </div>

                            <button class="btn btn-outline-dark mt-4">
                                Clear Storage
                            </button>

                        </div>

                        <!-- Line Chart -->
                        <div class="col-md-6 text-center">

                            <div style="height:300px;">
                                <canvas id="lineChart"></canvas>
                            </div>

                            <div class="border p-3 mt-4 d-flex justify-content-between align-items-center">
                                <span class="fs-5">Alert when Exceed storage</span>
                                <input type="number" id="alertLimit" class="form-control w-25 text-center"
                                    value="80">
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ================= LOCAL CHART JS ================= -->
    <script src="{{ asset('assets/bootstrap/js/chart.umd.js') }}"></script>


    <script>
        let pieChart;
        let lineChart;

        document.getElementById('storageUsageModal')
            .addEventListener('shown.bs.modal', function() {

                if (pieChart && lineChart) return;

                let used = 10;
                let total = 100;
                let alertLimit = 80;

                // ================= PIE CHART =================
                const pieCtx = document.getElementById('pieChart').getContext('2d');

                pieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Used', 'Free'],
                        datasets: [{
                            data: [used, total - used],
                            backgroundColor: ['#000000', '#e0e0e0']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                // ================= LINE CHART =================
                const lineCtx = document.getElementById('lineChart').getContext('2d');

                lineChart = new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
                        datasets: [{
                                label: 'Usage %',
                                data: [20, 45, 35, 55, 40, 50],
                                borderColor: '#000',
                                backgroundColor: 'transparent',
                                tension: 0.3
                            },
                            {
                                label: 'Alert Limit',
                                data: [alertLimit, alertLimit, alertLimit, alertLimit, alertLimit,
                                    alertLimit
                                ],
                                borderColor: '#dc3545',
                                borderDash: [6, 6],
                                pointRadius: 0,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });

            });
    </script>
@endsection
