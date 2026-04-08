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


<!-- ================= ACTIVE USERS MODAL ================= -->
<div class="modal fade" id="activeUsersModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Active Users</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body table-responsive">
                <table class="table table-bordered text-center align-middle data-table">
                    <thead class="table-light">
                        <tr>
                            <th>UID</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Last Logout</th>
                            <th>IP Address</th>
                            <th>Device</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($active_users as $active_user)
                            <tr>
                                <td>
                                    @if ($active_user->UserRegistration)
                                        U{{ str_pad($active_user->UserRegistration->iduser_registration, 3, '0', STR_PAD_LEFT) }}
                                    @elseif ($active_user->TechnicianRegistration)
                                        T{{ str_pad($active_user->TechnicianRegistration->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $active_user->username }}</td>
                                <td>{{ ucwords(strtolower(($active_user->first_name ?? '') . ' ' . ($active_user->last_name ?? ''))) }}</td>
                                <td>{{ $active_user->UserRole?->role_name ?? 'N/A' }}</td>
                                <td>
                                    @if ($active_user->is_online)
                                        <span class="badge bg-success">Online</span>
                                    @else
                                        <span class="badge bg-secondary">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $active_user->login_time
                                        ? \Carbon\Carbon::parse($active_user->login_time)->format('d M Y, h:i A')
                                        : 'Never' }}
                                </td>
                                <td>
                                    {{ $active_user->logout_time
                                        ? \Carbon\Carbon::parse($active_user->logout_time)->format('d M Y, h:i A')
                                        : ($active_user->login_time ? ' - ' : 'Never') }}
                                </td>
                                <td>{{ $active_user->ip_address }}</td>
                                <td style="max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    {{ $active_user->device }}
                                </td>
                                <td>
                                    @if ($active_user->is_online)
                                        <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#logoutModal"
                                            data-user="{{ $active_user->iduser }}">
                                            Force Logout
                                        </button>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- ================= FORCE LOGOUT CONFIRM MODAL ================= -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirm Force Logout</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to force logout this user?
            </div>

            <form method="POST" id="logoutForm">
                @csrf
                @method('POST')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Yes, Force Logout</button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- ================= DATA BACKUP MODAL ================= -->
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
                    <button class="btn btn-secondary m-2"
                        data-bs-toggle="modal"
                        data-bs-target="#backupScheduleModal">
                        Set Backup Schedule
                    </button>
                    <button class="btn btn-success m-2">Restore Data</button>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- ================= BACKUP SCHEDULE MODAL ================= -->
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


<!-- ================= STORAGE USAGE MODAL ================= -->
<div class="modal fade" id="storageUsageModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content p-5">

            <div class="modal-header border-0">
                <h4 class="fw-bold">Storage Management</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-md-6 text-center">
                        <div style="height:300px;">
                            <canvas id="pieChart"></canvas>
                        </div>
                        <div class="border p-3 mt-4 d-flex justify-content-between align-items-center">
                            <span class="fs-5">Storage Usage</span>
                            <input type="number" id="usedStorage" class="form-control w-25 text-center" value="10">
                        </div>
                        <button class="btn btn-outline-dark mt-4">Clear Storage</button>
                    </div>

                    <div class="col-md-6 text-center">
                        <div style="height:300px;">
                            <canvas id="lineChart"></canvas>
                        </div>
                        <div class="border p-3 mt-4 d-flex justify-content-between align-items-center">
                            <span class="fs-5">Alert when Exceed storage</span>
                            <input type="number" id="alertLimit" class="form-control w-25 text-center" value="80">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- ================= SCRIPTS ================= -->
<script src="{{ asset('assets/bootstrap/js/chart.umd.js') }}"></script>

<script>
    // Force logout — set form action dynamically
    document.getElementById('logoutModal').addEventListener('show.bs.modal', function (event) {
        const userId = event.relatedTarget.getAttribute('data-user');
        document.getElementById('logoutForm').action = '/KR_HOLDINGS/public/force-logout/' + userId;
    });

    // Charts
    let pieChart, lineChart;

    document.getElementById('storageUsageModal').addEventListener('shown.bs.modal', function () {
        if (pieChart && lineChart) return;

        const used       = parseInt(document.getElementById('usedStorage').value);
        const total      = 100;
        const alertLimit = parseInt(document.getElementById('alertLimit').value);

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
            options: { responsive: true, maintainAspectRatio: false }
        });

        const lineCtx = document.getElementById('lineChart').getContext('2d');
        lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
                datasets: [
                    {
                        label: 'Usage %',
                        data: [20, 45, 35, 55, 40, 50],
                        borderColor: '#000',
                        backgroundColor: 'transparent',
                        tension: 0.3
                    },
                    {
                        label: 'Alert Limit',
                        data: Array(6).fill(alertLimit),
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
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
    });
</script>
@endsection