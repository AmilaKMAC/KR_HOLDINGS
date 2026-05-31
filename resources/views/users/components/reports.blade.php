@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-grid gap-4 col-8 mx-auto">

            <button class="btn btn-primary p-4" data-bs-toggle="modal" data-bs-target="#technicianModal">Technician
                Performance</button>
            <button class="btn btn-success p-4" data-bs-toggle="modal" data-bs-target="#projectModal">Project Progress</button>
            <button class="btn btn-warning p-4" data-bs-toggle="modal" data-bs-target="#attendanceModal">Attendance
                Summary</button>
            <button class="btn btn-info p-4" data-bs-toggle="modal" data-bs-target="#partnerModal">Partner
                Companies</button>

        </div>
    </div>

    {{-- ==================== TECHNICIAN MODAL ==================== --}}
    <div class="modal fade" id="technicianModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Technician Performance Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Technician ID</th>
                                    <th>Name</th>
                                    <th>Total</th>
                                    <th>Completed</th>
                                    <th>Pending</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($technicians as $t)
                                    <tr>
                                        <td>T{{ str_pad($t['raw_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ ucwords(strtolower($t['name'])) }}</td>
                                        <td>{{ $t['total'] }}</td>
                                        <td>{{ $t['completed'] }}</td>
                                        <td>{{ $t['pending'] }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#techDetailModal{{ $t['raw_id'] }}"
                                                data-bs-dismiss="modal">View</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No technicians found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-dark btn-sm mt-2"
                        onclick="printModal('technicianModal', 'Technician Performance Report')">Print</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TECHNICIAN DETAIL MODALS ===== --}}
    @foreach ($technicians as $t)
        <div class="modal fade" id="techDetailModal{{ $t['raw_id'] }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            Projects — T{{ str_pad($t['raw_id'], 3, '0', STR_PAD_LEFT) }}
                            {{ ucwords(strtolower($t['name'])) }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="fw-bold text-success">Completed Projects</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center align-middle data-table">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Project ID</th>
                                        <th>Customer</th>
                                        <th>Capacity</th>
                                        <th>Completed Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($t['completed_projects'] as $i => $a)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>P{{ str_pad($a->project->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ ucwords(strtolower($a->project->customer_name)) }}</td>
                                            <td>{{ optional($a->project->Solar)->capacity ?? '-' }} kW</td>
                                            <td>{{ optional($a->project->updated_at)->format('Y-m-d') ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No completed projects.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <h6 class="fw-bold text-danger mt-4">Pending Projects</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center align-middle data-table">
                                <thead class="table-danger">
                                    <tr>
                                        <th>#</th>
                                        <th>Project ID</th>
                                        <th>Customer</th>
                                        <th>Capacity</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($t['pending_projects'] as $i => $a)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>P{{ str_pad($a->project->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ ucwords(strtolower($a->project->customer_name)) }}</td>
                                            <td>{{ optional($a->project->Solar)->capacity ?? '-' }} kW</td>
                                            <td>{{ optional($a->project->updated_at)->format('Y-m-d') ?? 'TBD' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No pending projects.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-dark btn-sm me-auto"
                            onclick="printDetailModal('techDetailModal{{ $t['raw_id'] }}', 'Projects — {{ ucwords(strtolower($t['name'])) }}')">Print</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- ==================== PROJECT MODAL ==================== --}}
    <div class="modal fade" id="projectModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Project Progress Summary</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Project ID</th>
                                    <th>Customer</th>
                                    <th>Location</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projects as $p)
                                    <tr>
                                        <td>P{{ str_pad($p['raw_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ ucwords(strtolower($p['customer'])) }}</td>
                                        <td>{{ ucwords(strtolower($p['location'])) }}</td>
                                        <td>{{ $p['capacity'] }} kW</td>
                                        <td>
                                            @if ($p['status'] == 1)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Ongoing</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#projectDetailModal{{ $p['raw_id'] }}"
                                                data-bs-dismiss="modal">View</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No projects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-dark btn-sm mt-2"
                        onclick="printModal('projectModal', 'Project Progress Summary')">Print</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PROJECT DETAIL MODALS ===== --}}
    @foreach ($projects as $p)
        <div class="modal fade" id="projectDetailModal{{ $p['raw_id'] }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Project Details — P{{ str_pad($p['raw_id'], 3, '0', STR_PAD_LEFT) }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th class="table-light" style="width:35%">Project ID</th>
                                    <td>P{{ str_pad($p['raw_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <th class="table-light">Customer Name</th>
                                    <td>{{ ucwords(strtolower($p['customer'])) }}</td>
                                </tr>
                                <tr>
                                    <th class="table-light">Location</th>
                                    <td>{{ ucwords(strtolower($p['location'])) }}</td>
                                </tr>
                                <tr>
                                    <th class="table-light">Capacity</th>
                                    <td>{{ $p['capacity'] }} kW</td>
                                </tr>
                                <tr>
                                    <th class="table-light">Partner Company</th>
                                    <td>{{ $p['partner'] }}</td>
                                </tr>
                                <tr>
                                    <th class="table-light">Assigned Technicians</th>
                                    <td>
                                        @forelse ($p['technicians'] as $tech)
                                            {{ ucwords(strtolower($tech['name'])) }}@unless ($loop->last), @endunless
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">Status</th>
                                    <td>
                                        @if ($p['status'] == 1)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Ongoing</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">Start Date</th>
                                    <td>{{ $p['start_date'] }}</td>
                                </tr>
                                <tr>
                                    <th class="table-light">End Date</th>
                                    <td>{{ $p['end_date'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-dark btn-sm me-auto"
                            onclick="printDetailModal('projectDetailModal{{ $p['raw_id'] }}', 'Project Details — P{{ str_pad($p['raw_id'], 3, '0', STR_PAD_LEFT) }}')">Print</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- ==================== ATTENDANCE MODAL ==================== --}}
    <div class="modal fade" id="attendanceModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Attendance Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Employee</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Leave</th>
                                    <th>Month</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendance as $a)
                                    <tr>
                                        <td>T{{ str_pad($a['raw_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ ucwords(strtolower($a['name'])) }}</td>
                                        <td>{{ $a['present'] }}</td>
                                        <td>{{ $a['absent'] }}</td>
                                        <td>{{ $a['leave'] }}</td>
                                        <td>{{ $a['month'] }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#attendanceDetailModal{{ $a['raw_id'] }}"
                                                data-bs-dismiss="modal">View</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No attendance records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-dark btn-sm mt-2"
                        onclick="printModal('attendanceModal', 'Attendance Summary')">Print</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== ATTENDANCE DETAIL MODALS ===== --}}
    @foreach ($attendance as $a)
        <div class="modal fade" id="attendanceDetailModal{{ $a['raw_id'] }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            Attendance History — T{{ str_pad($a['raw_id'], 3, '0', STR_PAD_LEFT) }}
                            {{ ucwords(strtolower($a['name'])) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle data-table">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Month</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                        <th>Leave</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($a['history'] as $i => $r)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $r['month'] }}</td>
                                            <td>{{ $r['present'] }}</td>
                                            <td>{{ $r['absent'] }}</td>
                                            <td>{{ $r['leave'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No attendance records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-dark btn-sm me-auto"
                            onclick="printDetailModal('attendanceDetailModal{{ $a['raw_id'] }}', 'Attendance History — {{ ucwords(strtolower($a['name'])) }}')">Print</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- ==================== PARTNER MODAL ==================== --}}
    <div class="modal fade" id="partnerModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Partner Company Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Partner ID</th>
                                    <th>Company</th>
                                    <th>Total</th>
                                    <th>Completed</th>
                                    <th>Ongoing</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partners as $p)
                                    <tr>
                                        <td>C{{ str_pad($p['raw_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ ucwords(strtolower($p['company'])) }}</td>
                                        <td>{{ $p['total'] }}</td>
                                        <td>{{ $p['completed'] }}</td>
                                        <td>{{ $p['ongoing'] }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#partnerDetailModal{{ $p['raw_id'] }}"
                                                data-bs-dismiss="modal">View</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No partners found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-dark btn-sm mt-2"
                        onclick="printModal('partnerModal', 'Partner Company Report')">Print</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PARTNER DETAIL MODALS ===== --}}
    @foreach ($partners as $p)
        <div class="modal fade" id="partnerDetailModal{{ $p['raw_id'] }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            Projects — C{{ str_pad($p['raw_id'], 3, '0', STR_PAD_LEFT) }}
                            {{ ucwords(strtolower($p['company'])) }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="fw-bold text-success">Completed Projects</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center align-middle data-table">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Project ID</th>
                                        <th>Customer</th>
                                        <th>Location</th>
                                        <th>Capacity</th>
                                        <th>Completed Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($p['completed_projects'] as $i => $proj)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>P{{ str_pad($proj['raw_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ ucwords(strtolower($proj['customer'])) }}</td>
                                            <td>{{ ucwords(strtolower($proj['location'])) }}</td>
                                            <td>{{ $proj['capacity'] }} kW</td>
                                            <td>{{ $proj['end_date'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No completed projects.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <h6 class="fw-bold text-primary mt-4">Ongoing Projects</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center align-middle data-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Project ID</th>
                                        <th>Customer</th>
                                        <th>Location</th>
                                        <th>Capacity</th>
                                        <th>Start Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($p['ongoing_projects'] as $i => $proj)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>P{{ str_pad($proj['raw_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ ucwords(strtolower($proj['customer'])) }}</td>
                                            <td>{{ ucwords(strtolower($proj['location'])) }}</td>
                                            <td>{{ $proj['capacity'] }} kW</td>
                                            <td>{{ $proj['start_date'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No ongoing projects.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-dark btn-sm me-auto"
                            onclick="printDetailModal('partnerDetailModal{{ $p['raw_id'] }}', 'Projects — {{ ucwords(strtolower($p['company'])) }}')">Print</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('others.print')
@endsection