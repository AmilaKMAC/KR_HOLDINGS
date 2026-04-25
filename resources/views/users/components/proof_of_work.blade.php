@extends('layout.app')
@section('content')
<div class="container-fluid py-4">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold text-center">Assigned Projects</div>
        <div class="table-responsive p-2">
            <table class="table table-bordered table-striped table-hover data-table text-center align-middle mb-0 w-100">
                <thead class="table-light">
                    <tr>
                        <th>Project ID</th>
                        <th>Customer</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Partner</th>
                        <th>Status</th>
                        <th>Action</th>
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
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadModal{{ $assign->Project_idProject }}">
                                    {{ $proof ? 'View / Upload' : 'Upload Photos' }}
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
        $proof            = $proofRecords[$assign->Project_idProject] ?? null;
        $uploadedSections = $proof ? $proof->images->pluck('section')->unique()->toArray() : [];
        $isApproved       = $proof?->approval == 1;
        $allUploaded      = count($uploadedSections) === count($sections);
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

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if ($isApproved)
                        <div class="alert alert-success text-center fw-bold">
                            ✓ This project has been approved. No further uploads allowed.
                        </div>
                    @endif

                    {{-- Single form with all sections --}}
                    @if (!$isApproved && !$allUploaded)
                        <form method="POST"
                            action="{{ route('proof_of_work.upload') }}"
                            enctype="multipart/form-data"
                            class="card border-primary mb-4">
                            @csrf
                            <div class="card-header bg-primary text-white fw-bold">
                                Upload Photos — Select images for each section
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="Project_idProject"
                                    value="{{ $assign->Project_idProject }}">

                                <div class="row g-3">
                                    @foreach ($sections as $key => $label)
                                        @if (!in_array($key, $uploadedSections))
                                            <div class="col-md-6">
                                                <div class="border rounded p-3">
                                                    <label class="form-label fw-bold mb-2">
                                                        {{ $label }}
                                                    </label>
                                                    <input type="file"
                                                        name="images[{{ $key }}][]"
                                                        class="form-control"
                                                        multiple
                                                        accept="image/*">
                                                    <small class="text-muted">
                                                        Select one or more images. Leave empty to skip.
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary px-5">
                                        Upload All Selected Photos
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                    {{-- Show already uploaded sections --}}
                    @if($proof && $proof->images->isNotEmpty())
                        <h6 class="fw-bold mb-3">Uploaded Photos</h6>
                        <div class="accordion" id="accordion{{ $assign->Project_idProject }}">
                            @foreach ($sections as $key => $label)
                                @php
                                    $sectionImages   = $proof->images->where('section', $key)->values();
                                    $alreadyUploaded = in_array($key, $uploadedSections);
                                @endphp

                                @if ($alreadyUploaded)
                                    <div class="accordion-item mb-2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-semibold"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $assign->Project_idProject }}_{{ $key }}">
                                                {{ $label }}
                                                <span class="badge bg-success ms-2">
                                                    {{ $sectionImages->count() }} Photo(s)
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $assign->Project_idProject }}_{{ $key }}"
                                            class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <div class="row g-2">
                                                    @foreach ($sectionImages as $img)
                                                        <div class="col-6 col-md-3">
                                                            <img src="{{ asset($img->image_path) }}"
                                                                class="img-fluid rounded shadow-sm"
                                                                style="height:130px;object-fit:cover;width:100%;cursor:pointer;"
                                                                onclick="openLightbox('{{ asset($img->image_path) }}')">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach


{{-- Lightbox --}}
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