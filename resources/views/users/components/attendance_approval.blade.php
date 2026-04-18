@extends('layout.app')

@section('content')
<div class="container-fluid px-2 px-md-4 px-lg-5 mt-4">

    <div class="card shadow-sm">
        <div class="card-header text-center fw-bold bg-dark text-white">
            Technician Attendance — {{ $today }}
        </div>
        <div class="p-2">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center align-middle mb-0 data-table">
                    <thead class="table-light">
                        <tr>
                            <th>Technician ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Project / Site</th>
                            <th>Location</th>
                            <th>Attendance</th>
                            <th>Approval</th>
                            <th>Action</th>
                            <th>History</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todayAttendance as $record)
                            <tr>
                                <td>
                                    T{{ str_pad($record->user?->TechnicianRegistration?->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    {{ ucwords(strtolower($record->user?->first_name . ' ' . $record->user?->last_name)) }}
                                </td>
                                <td>{{ $record->date }}</td>
                                <td>{{ $record->project?->customer_name ?? 'N/A' }}</td>
                                <td>{{ $record->project?->location ?? 'N/A' }}</td>
                                <td>
                                    @if ($record->attendance == 1)
                                        <span class="badge bg-success">Present</span>
                                    @else
                                        <span class="badge bg-danger">Absent</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($record->approval == 1)
                                        <span class="badge bg-primary">Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($record->approval == 0)
                                        <form method="POST" action="{{ route('attendance_approval.approve') }}">
                                            @csrf
                                            <input type="hidden" name="idattendance" value="{{ $record->idattendance }}">
                                            <input type="hidden" name="approval" value="1">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('attendance_approval.approve') }}">
                                            @csrf
                                            <input type="hidden" name="idattendance" value="{{ $record->idattendance }}">
                                            <input type="hidden" name="approval" value="0">
                                            <button type="submit" class="btn btn-sm btn-warning">Revoke</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    {{-- Button triggers modal unique to this user --}}
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#historyModal{{ $record->user?->iduser }}">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No attendance records for today</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- ================= HISTORY MODALS (one per technician, pure Blade) ================= --}}
@foreach ($todayAttendance as $record)
    <div class="modal fade" id="historyModal{{ $record->user?->iduser }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Attendance History —
                        {{ ucwords(strtolower($record->user?->first_name . ' ' . $record->user?->last_name)) }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Project</th>
                                    <th>Location</th>
                                    <th>Attendance</th>
                                    <th>Approval</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allAttendance[$record->user?->iduser] ?? [] as $history)
                                    <tr>
                                        <td>{{ $history->date }}</td>
                                        <td>{{ $history->project?->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $history->project?->location ?? 'N/A' }}</td>
                                        <td>
                                            @if ($history->attendance == 1)
                                                <span class="badge bg-success">Present</span>
                                            @else
                                                <span class="badge bg-danger">Absent</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($history->approval == 1)
                                                <span class="badge bg-primary">Approved</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($history->approval == 0)
                                                <form method="POST" action="{{ route('attendance_approval.approve') }}">
                                                    @csrf
                                                    <input type="hidden" name="idattendance" value="{{ $history->idattendance }}">
                                                    <input type="hidden" name="approval" value="1">
                                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('attendance_approval.approve') }}">
                                                    @csrf
                                                    <input type="hidden" name="idattendance" value="{{ $history->idattendance }}">
                                                    <input type="hidden" name="approval" value="0">
                                                    <button type="submit" class="btn btn-sm btn-warning">Revoke</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection