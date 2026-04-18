@extends('layout.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card border-dark shadow-sm rounded-4">
                <div class="card-header fw-bold text-center bg-dark text-white">
                    Attendance
                </div>
                <div class="card-body text-center py-5">

                    <h4 class="mb-4">Attend to the Site</h4>
                    <div class="fs-5 fw-medium mb-4">{{ $today }}</div>

                    @if ($todayAttendance)
                        <div class="mb-3">
                            <span class="badge bg-success fs-6 px-4 py-2">
                                ✓ Attendance Marked for Today
                            </span>
                        </div>
                        <div class="mb-2 text-muted">
                            Project: <strong>{{ $todayAttendance->project?->customer_name ?? 'N/A' }}</strong>
                            — {{ $todayAttendance->project?->location ?? '' }}
                        </div>
                        <div class="mt-3">
                            @if ($todayAttendance->approval == 1)
                                <span class="badge bg-primary fs-6 px-4 py-2">
                                    ✓ Approved by Coordinator
                                </span>
                            @else
                                <span class="badge bg-warning text-dark fs-6 px-4 py-2">
                                    ⏳ Pending Coordinator Approval
                                </span>
                            @endif
                        </div>
                    @else
                        <form method="POST" action="{{ route('attendance.mark') }}">
                            @csrf
                            <div class="mb-4 text-start">
                                <label class="form-label fw-bold">Select Project / Site</label>
                                <select name="project_idProject" class="form-select" required>
                                    <option value="">Select your project for today</option>
                                    @foreach ($assignedProjects as $assign)
                                        <option value="{{ $assign->project?->idProject }}">
                                            P{{ str_pad($assign->project?->idProject, 3, '0', STR_PAD_LEFT) }}
                                            — {{ $assign->project?->customer_name }}
                                            ({{ $assign->project?->location }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                Yes — I'm at the Site
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection