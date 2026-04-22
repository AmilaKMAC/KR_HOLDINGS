@extends('layout.app')
@section('content')
    <div class="container-fluid py-4">



        {{-- ===== PENDING ===== --}}
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-warning bg-opacity-25 fw-bold">Pending Approval</div>
            <div class="table-responsive p-2">
                <table class="table table-bordered table-striped table-hover data-table text-center align-middle mb-0 w-100">
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
                                    {{-- Additional Work selector --}}
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#additionalWorkModal{{ $proof->idproof_of_work }}">
                                        {{ $proof->additionalWork?->name ?? 'Select' }}
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $proof->idproof_of_work }}">
                                        View Photos
                                    </button>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('proof_of_work_approval.approve') }}">
                                        @csrf
                                        <input type="hidden" name="idproof_of_work" value="{{ $proof->idproof_of_work }}">
                                        <input type="hidden" name="additional_work_idadditional_work"
                                            value="{{ $proof->additional_work_idadditional_work }}">
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted">No pending approvals</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== APPROVED ===== --}}
        <div class="card shadow-sm">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Approved Projects</div>
            <div class="table-responsive p-2">
                <table
                    class="table table-bordered table-striped table-hover data-table text-center align-middle mb-0 w-100">
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
                                <td>{{ $proof->additionalWork?->name ?? '—' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $proof->idproof_of_work }}">
                                        View Photos
                                    </button>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('proof_of_work_approval.unapprove') }}">
                                        @csrf
                                        <input type="hidden" name="idproof_of_work" value="{{ $proof->idproof_of_work }}">
                                        <button type="submit" class="btn btn-sm btn-warning"
                                            onclick="return confirm('Revoke approval and require re-upload?')">
                                            Unapprove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted">No approved projects yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ===== VIEW PHOTO MODALS ===== --}}
    @php
        $allProofs = $pending->merge($approved);
        $sectionLabels = [
            'panel_installation' => 'Panel Installation',
            'water_proofing' => 'Water Proofing on Roof Top',
            'railing_installation' => 'Railing Installation',
            'dc_wiring' => 'DC Wiring',
            'inverter_installation' => 'Inverter Installation',
            'combiner_box' => 'Combiner Box',
            'hybrid_battery' => 'Hybrid Battery (Optional)',
            'casing' => 'Casing',
            'grounding' => 'Grounding',
            'additional_work' => 'Additional Work (Optional)',
        ];
    @endphp

    @foreach ($allProofs as $proof)
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
                                            <img src="{{ Storage::url($img->image_path) }}"
                                                class="img-fluid rounded shadow-sm"
                                                style="height:130px;object-fit:cover;width:100%;">
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

        {{-- Additional Work Modal per proof --}}
        <div class="modal fade" id="additionalWorkModal{{ $proof->idproof_of_work }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title">Select Additional Work</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('proof_of_work_approval.approve') }}">
                        @csrf
                        <input type="hidden" name="idproof_of_work" value="{{ $proof->idproof_of_work }}">
                        <div class="modal-body">
                            <select name="additional_work_idadditional_work" class="form-select">
                                <option value="">None</option>
                                @foreach ($additionalWorkOptions as $work)
                                    <option value="{{ $work->idadditional_work }}"
                                        {{ $proof->additional_work_idadditional_work == $work->idadditional_work ? 'selected' : '' }}>
                                        {{ $work->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save & Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection
