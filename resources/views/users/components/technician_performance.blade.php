@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="d-grid gap-4 col-8 mx-auto">

        <button class="btn btn-primary p-4" data-bs-toggle="modal" data-bs-target="#completionModal">
            Technician Completion of Work
        </button>
        <button class="btn btn-success p-4" data-bs-toggle="modal" data-bs-target="#rateModal">
            Completion Rate
        </button>
        <button class="btn btn-secondary p-4" data-bs-toggle="modal" data-bs-target="#attendanceModal">
            Attendance Reliability
        </button>

    </div>
</div>

{{-- ==================== COMPLETION OF WORK MODAL ==================== --}}
<div class="modal fade" id="completionModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Technician Completion of Work</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Technician Name</th>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Solar ID</th>
                                <th>Capacity</th>
                                <th>Completion Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($completionRows as $r)
                            <tr>
                                <td>T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucwords(strtolower($r['tech_name'])) }}</td>
                                <td>P{{ str_pad($r['project_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucwords(strtolower($r['customer'])) }}</td>
                                <td>{{ ucwords(strtolower($r['location'])) }}</td>
                                <td>S{{ str_pad($r['solar_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $r['capacity'] }} kW</td>
                                <td>{{ $r['completion_date'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#completionDetailModal{{ $r['tech_id'] }}_{{ $r['project_id'] }}"
                                        data-bs-dismiss="modal">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-muted">No completions recorded this month.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-outline-dark btn-sm mt-2"
                    onclick="printModal('completionModal', 'Technician Completion of Work')">Print</button>
            </div>
        </div>
    </div>
</div>

{{-- ===== COMPLETION DETAIL MODALS ===== --}}
@foreach ($completionRows as $r)
<div class="modal fade" id="completionDetailModal{{ $r['tech_id'] }}_{{ $r['project_id'] }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Completion Detail — T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}
                    {{ ucwords(strtolower($r['tech_name'])) }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th class="table-light" style="width:35%">Technician ID</th>
                            <td>T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Technician Name</th>
                            <td>{{ ucwords(strtolower($r['tech_name'])) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Project ID</th>
                            <td>P{{ str_pad($r['project_id'], 3, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Customer Name</th>
                            <td>{{ ucwords(strtolower($r['customer'])) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Location</th>
                            <td>{{ ucwords(strtolower($r['location'])) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Solar ID</th>
                            <td>S{{ str_pad($r['solar_id'], 3, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Capacity</th>
                            <td>{{ $r['capacity'] }} kW</td>
                        </tr>
                        <tr>
                            <th class="table-light">Completion Date</th>
                            <td>{{ $r['completion_date'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-dark btn-sm me-auto"
                    onclick="printDetailModal('completionDetailModal{{ $r['tech_id'] }}_{{ $r['project_id'] }}', 'Completion Detail — {{ ucwords(strtolower($r['tech_name'])) }}')">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ==================== COMPLETION RATE MODAL ==================== --}}
<div class="modal fade" id="rateModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Completion Rate</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Technician Name</th>
                                <th>Assigned Projects</th>
                                <th>Completed Projects</th>
                                <th>Completion Rate (%)</th>
                                <th>Time Frame</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($completionRates as $r)
                            <tr>
                                <td>T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucwords(strtolower($r['tech_name'])) }}</td>
                                <td>{{ $r['assigned'] }}</td>
                                <td>{{ $r['completed'] }}</td>
                                <td>{{ $r['rate'] }}</td>
                                <td>{{ $r['time_frame'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rateDetailModal{{ $r['tech_id'] }}"
                                        data-bs-dismiss="modal">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-muted">No data available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-outline-dark btn-sm mt-2"
                    onclick="printModal('rateModal', 'Completion Rate')">Print</button>
            </div>
        </div>
    </div>
</div>

{{-- ===== COMPLETION RATE DETAIL MODALS ===== --}}
@foreach ($completionRates as $r)
<div class="modal fade" id="rateDetailModal{{ $r['tech_id'] }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    Project Breakdown — T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}
                    {{ ucwords(strtolower($r['tech_name'])) }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th class="table-light" style="width:35%">Technician ID</th>
                            <td>T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Technician Name</th>
                            <td>{{ ucwords(strtolower($r['tech_name'])) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Assigned Projects</th>
                            <td>{{ $r['assigned'] }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Completed Projects</th>
                            <td>{{ $r['completed'] }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Completion Rate</th>
                            <td>{{ $r['rate'] }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Time Frame</th>
                            <td>{{ $r['time_frame'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-dark btn-sm me-auto"
                    onclick="printDetailModal('rateDetailModal{{ $r['tech_id'] }}', 'Project Breakdown — {{ ucwords(strtolower($r['tech_name'])) }}')">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ==================== ATTENDANCE RELIABILITY MODAL ==================== --}}
<div class="modal fade" id="attendanceModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Attendance Reliability</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Technician Name</th>
                                <th>Total Workdays</th>
                                <th>Present Days</th>
                                <th>Attendance Reliability (%)</th>
                                <th>Time Frame</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendanceRows as $r)
                            <tr>
                                <td>T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucwords(strtolower($r['tech_name'])) }}</td>
                                <td>{{ $r['total_days'] }}</td>
                                <td>{{ $r['present_days'] }}</td>
                                <td>{{ $r['reliability'] }}</td>
                                <td>{{ $r['time_frame'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#attendanceDetailModal{{ $r['tech_id'] }}"
                                        data-bs-dismiss="modal">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-muted">No attendance records this month.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-outline-dark btn-sm mt-2"
                    onclick="printModal('attendanceModal', 'Attendance Reliability')">Print</button>
            </div>
        </div>
    </div>
</div>

{{-- ===== ATTENDANCE DETAIL MODALS ===== --}}
@foreach ($attendanceRows as $r)
<div class="modal fade" id="attendanceDetailModal{{ $r['tech_id'] }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">
                    Attendance History — T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}
                    {{ ucwords(strtolower($r['tech_name'])) }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered align-middle mb-3">
                    <tbody>
                        <tr>
                            <th class="table-light" style="width:35%">Technician ID</th>
                            <td>T{{ str_pad($r['tech_id'], 3, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Technician Name</th>
                            <td>{{ ucwords(strtolower($r['tech_name'])) }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Total Workdays</th>
                            <td>{{ $r['total_days'] }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Present Days</th>
                            <td>{{ $r['present_days'] }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Attendance Reliability</th>
                            <td>{{ $r['reliability'] }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Time Frame</th>
                            <td>{{ $r['time_frame'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-dark btn-sm me-auto"
                    onclick="printDetailModal('attendanceDetailModal{{ $r['tech_id'] }}', 'Attendance History — {{ ucwords(strtolower($r['tech_name'])) }}')">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@include('others.print')
@endsection