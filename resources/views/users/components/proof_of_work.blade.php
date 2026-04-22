@extends('layout.app')
@section('content')
    <div class="container-fluid py-4">

        {{-- ===== ASSIGNED PROJECTS ===== --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-bold text-center">Assigned Projects</div>
                <table class="table table-bordered table-striped table-hover data-table text-center align-middle mb-0 w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Project ID</th>
                            <th>Customer</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Partner</th>
                            <th>Status</th>
                            <th>Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignedProjects as $assign)
                            @php $proof = $proofRecords[$assign->Project_idProject] ?? null; @endphp
                            <tr>
                                <td>P{{ str_pad($assign->project?->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ucwords(strtolower($assign->project?->customer_name)) }}</td>
                                <td>{{ $assign->project?->location }}</td>
                                <td>{{ $assign->project?->Solar?->capacity }} kW</td>
                                <td>{{ $assign->project?->Partner?->company_name }}</td>
                                <td>
                                    @if ($proof?->approval == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($proof)
                                        <span class="badge bg-warning text-dark">Pending Review</span>
                                    @else
                                        <span class="badge bg-secondary">Not Uploaded</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#uploadModal{{ $assign->Project_idProject }}">
                                        {{ $proof ? 'View / Upload' : 'Upload' }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">No assigned projects</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ===== UPLOAD MODALS (one per project) ===== --}}
    @foreach ($assignedProjects as $assign)
        @php
            $proof = $proofRecords[$assign->Project_idProject] ?? null;
            $uploadedSections = $proof ? $proof->images->pluck('section')->unique()->toArray() : [];
            $isApproved = $proof?->approval == 1;
        @endphp

        <div class="modal fade" id="uploadModal{{ $assign->Project_idProject }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            Proof of Work —
                            P{{ str_pad($assign->project?->idProject, 3, '0', STR_PAD_LEFT) }}
                            {{ ucwords(strtolower($assign->project?->customer_name)) }}
                        </h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        @if ($isApproved)
                            <div class="alert alert-success text-center fw-bold">
                                ✓ This project has been approved. No further uploads allowed.
                            </div>
                        @endif

                        <div class="accordion" id="accordion{{ $assign->Project_idProject }}">
                            @foreach ($sections as $key => $label)
                                @php
                                    $sectionImages = $proof
                                        ? $proof->images->where('section', $key)->values()
                                        : collect();
                                    $alreadyUploaded = in_array($key, $uploadedSections);
                                @endphp

                                <div class="accordion-item mb-2">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-semibold" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $assign->Project_idProject }}_{{ $key }}">
                                            {{ $label }}
                                            @if ($alreadyUploaded)
                                                <span class="badge bg-success ms-2">Uploaded</span>
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $assign->Project_idProject }}_{{ $key }}"
                                        class="accordion-collapse collapse">
                                        <div class="accordion-body">

                                            {{-- Show existing images --}}
                                            @if ($sectionImages->isNotEmpty())
                                                <div class="row g-2 mb-3">
                                                    @foreach ($sectionImages as $img)
                                                        <div class="col-6 col-md-3">
                                                            <img src="{{ Storage::url($img->image_path) }}"
                                                                class="img-fluid rounded shadow-sm"
                                                                style="height:130px;object-fit:cover;width:100%;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Upload form — only if not uploaded yet and not approved --}}
                                            @if (!$alreadyUploaded && !$isApproved)
                                                <form method="POST" action="{{ route('proof_of_work.upload') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="Project_idProject"
                                                        value="{{ $assign->Project_idProject }}">
                                                    <input type="hidden" name="section" value="{{ $key }}">
                                                    <div class="mb-2">
                                                        <input type="file" name="images[]" class="form-control" multiple
                                                            accept="image/*" required>
                                                        <small class="text-muted">Select multiple images if needed.</small>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        Upload Photos
                                                    </button>
                                                </form>
                                            @elseif($alreadyUploaded && !$isApproved)
                                                <div class="alert alert-info py-2 mb-0">
                                                    Photos already uploaded for this section.
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
