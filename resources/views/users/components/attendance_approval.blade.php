@extends('layout.app')

@section('content')
    <div class="container-fluid px-2 px-md-4 px-lg-5 mt-4">

        {{-- ===== TABLE 1: TODAY'S ATTENDANCE ===== --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header text-center fw-bold bg-dark text-white">
                Technician Attendance — {{ $today }}
            </div>
            <div class="p-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Technician ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Project / Site</th>
                                <th>Location</th>
                                <th>Attendance</th>
                                <th>Approval</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($technicians as $tech)
                                @php $record = $todayAttendance[$tech->iduser] ?? null; @endphp
                                <tr>
                                    <td>T{{ str_pad($tech->TechnicianRegistration?->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td>{{ ucwords(strtolower($tech->first_name . ' ' . $tech->last_name)) }}</td>
                                    <td>{{ $record?->date ?? $today }}</td>
                                    <td>{{ $record?->project?->customer_name ?? '—' }}</td>
                                    <td>{{ $record?->project?->location ?? '—' }}</td>
                                    <td>
                                        @if ($record && $record->attendance == 1)
                                            <span class="badge bg-success">Present</span>
                                        @elseif ($record && $record->attendance == 0)
                                            <span class="badge bg-danger">Absent</span>
                                        @else
                                            <span class="badge bg-secondary">Not Marked</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($record && $record->approval == 1)
                                            <span class="badge bg-primary">Approved</span>
                                        @elseif ($record)
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($record && $record->approval == 0)
                                            <form method="POST" action="{{ route('attendance_approval.approve') }}">
                                                @csrf
                                                <input type="hidden" name="idattendance"
                                                    value="{{ $record->idattendance }}">
                                                <input type="hidden" name="approval" value="1">
                                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                        @elseif ($record && $record->approval == 1)
                                            <form method="POST" action="{{ route('attendance_approval.approve') }}">
                                                @csrf
                                                <input type="hidden" name="idattendance"
                                                    value="{{ $record->idattendance }}">
                                                <input type="hidden" name="approval" value="0">
                                                <button type="submit" class="btn btn-sm btn-warning">Revoke</button>
                                            </form>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No technicians found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- ===== TABLE 2: ATTENDANCE HISTORY ===== --}}
        <div class="card shadow-sm">
            <div class="card-header text-center fw-bold bg-secondary text-white">
                Attendance History
            </div>
            <div class="p-2">
                <div class="table-responsive p-2">
                    <table
                        class="table table-bordered table-striped table-hover data-table text-center align-middle mb-0 w-100">
                        <thead class="table-secondary">
                            <tr>
                                <th>Technician ID</th>
                                <th>Name</th>
                                <th>Total Days</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Pending Approval</th>
                                <th>Manual Mark</th>
                                <th>View History</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- ===== TABLE 2: ATTENDANCE HISTORY ===== --}}
                            @forelse ($technicians as $tech)
                                @php
                                    $history = $allAttendance[$tech->iduser] ?? collect(); // all including today
                                    $present = $history->where('attendance', 1)->count();
                                    $absent = $history->where('attendance', 0)->count();
                                    $pending = $history->where('approval', 0)->count();
                                @endphp
                                <tr>
                                    <td>T{{ str_pad($tech->TechnicianRegistration?->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td>{{ ucwords(strtolower($tech->first_name . ' ' . $tech->last_name)) }}</td>
                                    <td>{{ $history->count() }}</td>
                                    <td><span class="badge bg-success">{{ $present }}</span></td>
                                    <td><span class="badge bg-danger">{{ $absent }}</span></td>
                                    <td>
                                        @if ($pending > 0)
                                            <span class="badge bg-warning text-dark">{{ $pending }}</span>
                                        @else
                                            <span class="badge bg-primary">All Approved</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#manualMarkModal{{ $tech->iduser }}">
                                            + Mark
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#historyModal{{ $tech->iduser }}">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No technicians found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    {{-- ===== HISTORY MODALS (one per technician) ===== --}}
    @foreach ($technicians as $tech)
        @php
        $history = $pastAttendance[$tech->iduser] ?? collect();
        @endphp

        <div class="modal fade" id="historyModal{{ $tech->iduser }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title">
                            Attendance History —
                            T{{ str_pad($tech->TechnicianRegistration?->idtechnician_registration, 3, '0', STR_PAD_LEFT) }}
                            {{ ucwords(strtolower($tech->first_name . ' ' . $tech->last_name)) }}
                        </h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-2">
                        <div class="table-responsive p-2">
                            <table
                                class="table table-bordered table-striped table-hover data-table text-center align-middle mb-0 w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Project / Site</th>
                                        <th>Location</th>
                                        <th>Attendance</th>
                                        <th>Approval</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($history as $h)
                                        <tr>
                                            <td>{{ $h->date }}</td>
                                            <td>{{ $h->project?->customer_name ?? 'N/A' }}</td>
                                            <td>{{ $h->project?->location ?? 'N/A' }}</td>
                                            <td>
                                                @if ($h->attendance == 1)
                                                    <span class="badge bg-success">Present</span>
                                                @else
                                                    <span class="badge bg-danger">Absent</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($h->approval == 1)
                                                    <span class="badge bg-primary">Approved</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($h->approval == 0)
                                                    <form method="POST"
                                                        action="{{ route('attendance_approval.approve') }}">
                                                        @csrf
                                                        <input type="hidden" name="idattendance"
                                                            value="{{ $h->idattendance }}">
                                                        <input type="hidden" name="approval" value="1">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success">Approve</button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('attendance_approval.approve') }}">
                                                        @csrf
                                                        <input type="hidden" name="idattendance"
                                                            value="{{ $h->idattendance }}">
                                                        <input type="hidden" name="approval" value="0">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-warning">Revoke</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-muted fst-italic">No history found.</td>
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


        {{-- ===== MANUAL MARK MODAL ===== --}}
        <div class="modal fade" id="manualMarkModal{{ $tech->iduser }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title">
                            Manual Mark —
                            {{ ucwords(strtolower($tech->first_name . ' ' . $tech->last_name)) }}
                        </h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('attendance_approval.manualMark') }}">
                        @csrf
                        <input type="hidden" name="user_iduser" value="{{ $tech->iduser }}">
                        <input type="hidden" name="attendance" value="1">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Project / Site</label>
                                <select name="project_idProject" class="form-select" required>
                                    <option value="">Select Project</option>
                                    @foreach ($tech->assignedProjects ?? [] as $assign)
                                        <option value="{{ $assign->Project_idProject }}">
                                            P{{ str_pad($assign->Project_idProject, 3, '0', STR_PAD_LEFT) }}
                                            — {{ $assign->project?->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Attendance</label>
                                <select name="attendance" class="form-select">
                                    <option value="1">Present</option>
                                    <option value="0">Absent</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
