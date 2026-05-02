@extends('layout.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header fw-bold text-center bg-dark text-white">
                My Assigned Projects
            </div>
            <div class="p-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Contact</th>
                                <th>Capacity</th>
                                <th>Partner</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $assignment)
                                <tr>
                                    <td>P{{ str_pad($assignment->project?->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ ucwords(strtolower($assignment->project?->customer_name ?? '')) }}</td>
                                    <td>
                                        @if ($assignment->project?->site_url)
                                            <a href="{{ $assignment->project?->site_url }}" target="_blank" title="View Site Location">
                                                <i class="bi bi-geo-alt-fill"> </i>
                                                {{ $assignment->project?->location }}
                                            </a>
                                        @else
                                            {{ $assignment->project?->location }}
                                        @endif
                                    </td>                                    <td>{{ $assignment->project?->contact ?? 'N/A' }}</td>
                                    <td>{{ $assignment->project?->Solar?->capacity ?? 'N/A' }} kW</td>
                                    <td>{{ $assignment->project?->Partner?->company_name ?? 'N/A' }}</td>

                                    {{-- Status --}}
                                    <td>
                                        @if ($assignment->project?->status == 1)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning text-dark">In Progress</span>
                                        @endif
                                    </td>

                                    {{-- Action --}}
                                    <td class="d-flex gap-1 justify-content-center">
                                        {{-- View button always visible --}}
                                        <button class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewTechModal{{ $assignment->idassign_technician }}">
                                            View
                                        </button>

                                        {{-- Cancel only for ongoing projects --}}
                                        @if ($assignment->project?->status != 1)
                                            <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal{{ $assignment->idassign_technician }}">
                                                Cancel
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No projects assigned</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================== MODALS ========================== --}}
    @foreach ($assignments as $assignment)

        {{-- ===== VIEW TECHNICIANS MODAL ===== --}}
        <div class="modal fade" id="viewTechModal{{ $assignment->idassign_technician }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            Technicians — P{{ str_pad($assignment->project?->idProject, 3, '0', STR_PAD_LEFT) }}
                            {{ ucwords(strtolower($assignment->project?->customer_name ?? '')) }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold mb-2">Assigned Technicians:</p>
                        @if ($assignment->project?->assignedTechnicians?->isNotEmpty())
                            @foreach ($assignment->project->assignedTechnicians as $at)
                                <span class="badge bg-secondary mb-1">
                                    {{ ucwords(strtolower($at->technician?->first_name ?? '')) }}
                                    {{ ucwords(strtolower($at->technician?->last_name ?? '')) }}
                                </span>
                            @endforeach
                        @else
                            <p class="text-muted">No technicians assigned.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== CANCEL MODAL (ongoing only) ===== --}}
        @if ($assignment->project?->status != 1)
            <div class="modal fade" id="cancelModal{{ $assignment->idassign_technician }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Cancel Project Assignment</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('assign_projects.cancel') }}">
                            @csrf
                            <input type="hidden"
                                name="assign_technician_idassign_technician"
                                value="{{ $assignment->idassign_technician }}">
                            <div class="modal-body">
                                <p class="mb-3">
                                    Are you sure you want to cancel your assignment for
                                    <strong>
                                        P{{ str_pad($assignment->project?->idProject, 3, '0', STR_PAD_LEFT) }}
                                        — {{ $assignment->project?->customer_name }}
                                    </strong>?
                                </p>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Reason for Cancellation</label>
                                    <textarea name="reason" class="form-control" rows="3"
                                        placeholder="Enter reason..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep</button>
                                <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    @endforeach

@endsection