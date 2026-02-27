@extends('layout.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <!-- ================= PAGE HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Reports Module</h4>
    </div>


    <!-- ===================================================== -->
    <!-- ================= SYSTEM ACTIVITY LOG ================= -->
    <!-- ===================================================== -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white fw-bold">
            System Activity Log
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Event</th>
                        <th>Module</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Triggered By</th>
                        <th>Timestamp</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($systemLogs ?? [] as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->event }}</td>
                        <td>{{ $log->module }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $log->severity }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">
                                {{ $log->status }}
                            </span>
                        </td>
                        <td>{{ $log->user->name ?? '-' }}</td>
                        <td>{{ $log->created_at }}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#systemLogModal"
                                data-id="{{ $log->id }}">
                                View
                            </button>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="8">No Records Found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!-- ===================================================== -->
    <!-- ================= USER ACTIVITY LOG ================== -->
    <!-- ===================================================== -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-secondary text-white fw-bold">
            User Activity Log
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>IP Address</th>
                        <th>Device</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($userLogs ?? [] as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td>{{ $log->device }}</td>
                        <td>{{ $log->created_at }}</td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#userLogModal"
                                data-id="{{ $log->id }}">
                                View
                            </button>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7">No Records Found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!-- ===================================================== -->
    <!-- ========== TECHNICIAN PERFORMANCE REPORT ============= -->
    <!-- ===================================================== -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white fw-bold">
            Technician Performance Report
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Technician</th>
                        <th>Total Projects</th>
                        <th>Completed</th>
                        <th>Pending</th>
                        <th>Average Completion (Days)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($technicianReports ?? [] as $tech)
                    <tr>
                        <td>{{ $tech->id }}</td>
                        <td>{{ $tech->name }}</td>
                        <td>{{ $tech->total_projects }}</td>
                        <td><span class="badge bg-success">{{ $tech->completed }}</span></td>
                        <td><span class="badge bg-warning text-dark">{{ $tech->pending }}</span></td>
                        <td>{{ $tech->avg_completion_days }}</td>
                        <td>
                            <button class="btn btn-sm btn-info">View</button>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7">No Records Found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!-- ===================================================== -->
    <!-- ============ PROJECT PROGRESS SUMMARY ================= -->
    <!-- ===================================================== -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-success text-white fw-bold">
            Project Progress Summary
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>Partner Company</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Expected Completion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects ?? [] as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->partner->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $project->status }}
                            </span>
                        </td>
                        <td>{{ $project->start_date }}</td>
                        <td>{{ $project->expected_completion }}</td>
                        <td>
                            <button class="btn btn-sm btn-info">View</button>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7">No Records Found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!-- ===================================================== -->
    <!-- ============= MONTHLY ATTENDANCE REPORT ============== -->
    <!-- ===================================================== -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-warning text-dark fw-bold">
            Monthly Attendance Report
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Leave</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceReports ?? [] as $attendance)
                    <tr>
                        <td>{{ $attendance->id }}</td>
                        <td>{{ $attendance->user->name }}</td>
                        <td>{{ $attendance->month }}</td>
                        <td>{{ $attendance->present }}</td>
                        <td>{{ $attendance->absent }}</td>
                        <td>{{ $attendance->leave }}</td>
                        <td>
                            <button class="btn btn-sm btn-info">View</button>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7">No Records Found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!-- ===================================================== -->
    <!-- ============ PARTNER COMPANY REPORT =================== -->
    <!-- ===================================================== -->
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white fw-bold">
            Partner Company Reports
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Partner Company</th>
                        <th>Total Projects</th>
                        <th>Completed</th>
                        <th>Ongoing</th>
                        <th>Revenue Generated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partnerReports ?? [] as $partner)
                    <tr>
                        <td>{{ $partner->id }}</td>
                        <td>{{ $partner->name }}</td>
                        <td>{{ $partner->total_projects }}</td>
                        <td><span class="badge bg-success">{{ $partner->completed }}</span></td>
                        <td><span class="badge bg-warning text-dark">{{ $partner->ongoing }}</span></td>
                        <td>{{ $partner->revenue }}</td>
                        <td>
                            <button class="btn btn-sm btn-info">View</button>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7">No Records Found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection