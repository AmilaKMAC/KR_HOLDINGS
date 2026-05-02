@extends('layout.app')
@section('content')

<div class="container-fluid py-4">

    {{-- ================= PENDING ================= --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-warning bg-opacity-25 fw-bold">Pending Approval</div>
        <div class="table-responsive p-2">
            <table class="table table-bordered table-striped table-hover data-table text-center align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>Project ID</th>
                        <th>Customer</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Partner</th>
                        <th>Technicians</th>
                        <th>View</th>
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $proof)
                        <tr>
                            <td>P{{ str_pad($proof->project?->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ ucwords(strtolower($proof->project?->customer_name)) }}</td>
                            <td>{{ $proof->project?->location }}</td>
                            <td>{{ $proof->project?->Solar?->capacity }} kW</td>
                            <td>{{ $proof->project?->Partner?->company_name }}</td>
                            <td>
                                @foreach ($proof->project?->assignedTechnicians ?? [] as $at)
                                    <span class="badge bg-secondary">
                                        {{ ucwords(strtolower($at->technician?->first_name)) }}
                                        {{ ucwords(strtolower($at->technician?->last_name)) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $proof->idproof_of_work }}">
                                    View
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#approveModal{{ $proof->idproof_of_work }}">
                                    Approve
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">No pending approvals</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= APPROVED ================= --}}
    <div class="card shadow-sm">
        <div class="card-header bg-success bg-opacity-25 fw-bold">Approved Projects</div>
        <div class="table-responsive p-2">
            <table class="table table-bordered table-striped table-hover data-table text-center align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>Project ID</th>
                        <th>Customer</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Partner</th>
                        <th>Technicians</th>
                        <th>Additional Work</th>
                        <th>View</th>
                        <th>Unapprove</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approved as $proof)
                        <tr>
                            <td>P{{ str_pad($proof->project?->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ ucwords(strtolower($proof->project?->customer_name)) }}</td>
                            <td>{{ $proof->project?->location }}</td>
                            <td>{{ $proof->project?->Solar?->capacity }} kW</td>
                            <td>{{ $proof->project?->Partner?->company_name }}</td>
                            <td>
                                @foreach ($proof->project?->assignedTechnicians ?? [] as $at)
                                    <span class="badge bg-secondary">
                                        {{ ucwords(strtolower($at->technician?->first_name)) }}
                                        {{ ucwords(strtolower($at->technician?->last_name)) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                @forelse ($proof->additionalWorks as $work)
                                    <span class="badge bg-dark">{{ $work->description }}</span>
                                @empty
                                    <span class="text-muted">None</span>
                                @endforelse
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $proof->idproof_of_work }}">
                                    View
                                </button>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('proof_of_work_approval.unapprove') }}">
                                    @csrf
                                    <input type="hidden" name="idproof_of_work" value="{{ $proof->idproof_of_work }}">
                                    <button type="submit" class="btn btn-sm btn-warning"
                                            onclick="return confirm('Revoke approval?')">
                                        Unapprove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted">No approved projects</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= ALL MODALS ================= --}}
@php
    $allProofs = $pending->merge($approved);
    $sectionLabels = [
        'panel_installation'    => 'Panel Installation',
        'water_proofing'        => 'Water Proofing on Roof Top',
        'railing_installation'  => 'Railing Installation',
        'dc_wiring'             => 'DC Wiring',
        'inverter_installation' => 'Inverter Installation',
        'combiner_box'          => 'Combiner Box',
        'hybrid_battery'        => 'Hybrid Battery (Optional)',
        'casing'                => 'Casing',
        'grounding'             => 'Grounding',
        'additional_work'       => 'Additional Work (Optional)',
    ];
@endphp

@foreach ($allProofs as $proof)

    {{-- ===== 1. VIEW PHOTOS MODAL ===== --}}
    <div class="modal fade" id="viewModal{{ $proof->idproof_of_work }}" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Photos — P{{ str_pad($proof->project?->idProject, 3, '0', STR_PAD_LEFT) }}
                        {{ ucwords(strtolower($proof->project?->customer_name)) }}
                    </h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach ($sectionLabels as $key => $label)
                        @php $imgs = $proof->images->where('section', $key); @endphp
                        @if ($imgs->isNotEmpty())
                            <h6 class="fw-bold text-primary mt-3">{{ $label }}</h6>
                            <div class="row g-2 mb-3">
                                @foreach ($imgs as $img)
                                    <div class="col-6 col-md-3">
                                        <img src="{{ asset($img->image_path) }}"
                                             class="img-fluid rounded shadow-sm"
                                             style="height:130px;object-fit:cover;width:100%;cursor:pointer;"
                                             onclick="openLightbox('{{ asset($img->image_path) }}')">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== 2. APPROVE MODAL (additional works + approve) ===== --}}
    {{-- Only render for pending proofs --}}
    @if ($proof->approval == 0)
        <div class="modal fade" id="approveModal{{ $proof->idproof_of_work }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            Approve — P{{ str_pad($proof->project?->idProject, 3, '0', STR_PAD_LEFT) }}
                            {{ ucwords(strtolower($proof->project?->customer_name)) }}
                        </h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('proof_of_work_approval.approve') }}">
                        @csrf
                        <input type="hidden" name="idproof_of_work" value="{{ $proof->idproof_of_work }}">
                        <div class="modal-body" style="max-height:400px; overflow-y:auto;">

                            <p class="text-muted small mb-3">
                                Select any additional work completed for this project, then click Approve.
                                Additional work is optional.
                            </p>

                            @forelse ($additionalWorkOptions as $work)
                                <div class="form-check mb-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="additional_work_idadditional_work[]"
                                           value="{{ $work->idadditional_work }}"
                                           id="approve_{{ $proof->idproof_of_work }}_{{ $work->idadditional_work }}">
                                    <label class="form-check-label"
                                           for="approve_{{ $proof->idproof_of_work }}_{{ $work->idadditional_work }}">
                                        {{ $work->description ?? 'No Description' }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No additional work options available.</p>
                            @endforelse

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endforeach

{{-- ===== LIGHTBOX ===== --}}
<div class="modal fade" id="lightboxModal" tabindex="-1" style="z-index:1090;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0">
                <button class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <img id="lightboxImg" src="" class="img-fluid rounded" style="max-height:75vh;">
            </div>
        </div>
    </div>
</div>

<script>
    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        new bootstrap.Modal(document.getElementById('lightboxModal')).show();
    }
</script>

@endsection