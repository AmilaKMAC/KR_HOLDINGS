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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $assignment)
                                <tr>
                                    <td>P{{ str_pad($assignment->project?->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ ucwords(strtolower($assignment->project?->customer_name ?? '')) }}</td>
                                    <td>{{ $assignment->project?->location ?? 'N/A' }}</td>
                                    <td>{{ $assignment->project?->contact ?? 'N/A' }}</td>
                                    <td>{{ $assignment->project?->Solar?->capacity ?? 'N/A' }} kW</td>
                                    <td>{{ $assignment->project?->Partner?->company_name ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#cancelModal{{ $assignment->idassign_technician }}">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No projects assigned</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- ========================== CANCEL MODALS ========================== -->
    @foreach ($assignments as $assignment)
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
    @endforeach
@endsection