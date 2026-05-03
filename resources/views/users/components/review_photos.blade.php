@extends('layout.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ================= PROJECT TABLE ================= -->
    <div class="card shadow-sm">
        <div class="card-header fw-bold text-center bg-dark text-white">
            Completed Projects — Photo Review
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center data-table">
                <thead class="table-light">
                    <tr>
                        <th>Project ID</th>
                        <th>Customer Name</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Partner Company</th>
                        <th>Technicians</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proofs as $proof)
                        <tr>
                            <td>P{{ str_pad($proof->project?->idProject, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ ucwords(strtolower($proof->project?->customer_name ?? '')) }}</td>
                            <td>
                                @if ($proof->project?->site_url)
                                    <a href="{{ $proof->project->site_url }}" target="_blank">
                                        {{ $proof->project->location }}
                                    </a>
                                @else
                                    {{ $proof->project?->location ?? 'N/A' }}
                                @endif
                            </td>
                            <td>{{ $proof->project?->Solar?->capacity ?? 'N/A' }} kW</td>
                            <td>{{ $proof->project?->Partner?->company_name ?? 'N/A' }}</td>
                            <td>
                                @foreach ($proof->project?->assignedTechnicians ?? [] as $at)
                                    <span class="badge bg-secondary">
                                        {{ ucwords(strtolower($at->technician?->first_name ?? '')) }}
                                        {{ ucwords(strtolower($at->technician?->last_name ?? '')) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#photoModal{{ $proof->idproof_of_work }}">
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted text-center">No completed projects found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= PHOTO MODALS PER PROOF ================= --}}
@php
    $sectionLabels = [
        'panel_installation'    => 'Panel Installation',
        'water_proofing'        => 'Waterproofing (Roof Top)',
        'railing_installation'  => 'Railing Installation',
        'dc_wiring'             => 'DC Wiring',
        'inverter_installation' => 'Inverter Installation',
        'combiner_box'          => 'Combiner Boxes',
        'hybrid_battery'        => 'Hybrid Battery (Optional)',
        'casing'                => 'Casing',
        'grounding'             => 'Grounding',
        'additional_work'       => 'Additional Work (Optional)',
    ];
@endphp

@foreach ($proofs as $proof)
    <div class="modal fade" id="photoModal{{ $proof->idproof_of_work }}" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-semibold">
                        Photos — P{{ str_pad($proof->project?->idProject, 3, '0', STR_PAD_LEFT) }}
                        {{ ucwords(strtolower($proof->project?->customer_name ?? '')) }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- Additional Works Badges --}}
                    @if ($proof->additionalWorks->isNotEmpty())
                        <div class="mb-3">
                            <span class="fw-bold text-secondary me-2">Additional Works:</span>
                            @foreach ($proof->additionalWorks as $work)
                                <span class="badge bg-dark">{{ $work->description }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Download All --}}
                    @if ($proof->images->isNotEmpty())
                        <div class="text-end mb-4">
                            <a href="{{ route('review_photos.download', $proof->idproof_of_work) }}"
                               class="btn btn-success btn-sm">
                                Download All Photos
                            </a>
                        </div>
                    @endif

                    {{-- Photos by section --}}
                    @foreach ($sectionLabels as $key => $label)
                        @php $imgs = $proof->images->where('section', $key); @endphp
                        @if ($imgs->isNotEmpty())
                            <h6 class="fw-bold text-primary mt-3">{{ $label }}</h6>
                            <div class="row g-3 mb-3">
                                @foreach ($imgs as $img)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <img src="{{ asset($img->image_path) }}"
                                             class="img-fluid rounded shadow-sm preview-image"
                                             style="height:130px;object-fit:cover;width:100%;cursor:pointer;"
                                             data-src="{{ asset($img->image_path) }}"
                                             alt="Photo">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endforeach

{{-- ================= IMAGE LIGHTBOX MODAL ================= --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" style="z-index:1090;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <img id="previewImage" src="" class="img-fluid rounded mb-3" style="max-height:75vh;">
                <div>
                    <a id="downloadImageBtn" href="#" download class="btn btn-success btn-sm">
                        Download Image
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));

    document.querySelectorAll('.preview-image').forEach(img => {
        img.addEventListener('click', function () {
            const src = this.getAttribute('data-src');
            document.getElementById('previewImage').src = src;
            document.getElementById('downloadImageBtn').href = src;
            previewModal.show();
        });
    });

});
</script>

@endsection