@extends('layout.app')

@section('title', 'Proof of Work')

@section('content')

<div class="container-fluid py-4">

    <!-- ================= PAGE TITLE ================= -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3 class="fw-bold">Proof of Work</h3>
        </div>
    </div>

    <!-- ================= MAIN OPTIONS (no card) ================= -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="d-grid gap-3">

                <button class="btn btn-outline-primary py-3"
                        data-bs-toggle="modal"
                        data-bs-target="#assignedProjectModal">
                    Assigned Project
                </button>

                <button class="btn btn-outline-secondary py-3"
                        data-bs-toggle="modal"
                        data-bs-target="#previousProjectModal">
                    Previous Projects
                </button>

                <button class="btn btn-outline-success py-3"
                        data-bs-toggle="modal"
                        data-bs-target="#viewUploadedModal">
                    View Uploaded Photos
                </button>

            </div>
        </div>
    </div>

</div>


<!-- ========================================================= -->
<!-- ================= ASSIGNED PROJECT MODAL ================= -->
<!-- ========================================================= -->

<div class="modal fade" id="assignedProjectModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title fw-bold">Proof of Work Review for Approval</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body table-responsive">

    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
        <tr>
            <th>Project ID</th>
            <th>Customer</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>View</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>P001</td>
            <td>Kasun Perera</td>
            <td>Colombo</td>
            <td>10kW</td>
            <td>
                <button class="btn btn-sm btn-primary openProofModal" data-mode="upload">
                    View
                </button>
            </td>
        </tr>
        </tbody>
    </table>

</div>
</div>
</div>
</div>


<!-- ========================================================= -->
<!-- ================= PREVIOUS PROJECT MODAL ================= -->
<!-- ========================================================= -->

<div class="modal fade" id="previousProjectModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title fw-bold">Upload Photos for Previous Project</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <div class="mb-3">
        <label class="form-label fw-semibold">Select Project</label>
        <select class="form-select" id="previousProjectSelect">
            <option value="">-- Select a Project --</option>
            <option value="P002">P002 - Nimal Silva</option>
            <option value="P003">P003 - Sunil Fernando</option>
        </select>
    </div>

    <!-- Upload Button shown after project is selected -->
    <div id="previousUploadTriggerWrapper" class="d-none text-center mt-4">
        <button class="btn btn-primary px-5 py-2" id="openPreviousProofBtn">
            Upload Photos
        </button>
    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>


<!-- ========================================================= -->
<!-- ================= VIEW UPLOADED MODAL ================= -->
<!-- ========================================================= -->

<div class="modal fade" id="viewUploadedModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title fw-bold">Uploaded Projects</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body table-responsive">

    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
        <tr>
            <th>Project ID</th>
            <th>Customer</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>View</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>P003</td>
            <td>Sunil Fernando</td>
            <td>Galle</td>
            <td>8kW</td>
            <td>
                <button class="btn btn-sm btn-success openProofModal" data-mode="view">
                    View
                </button>
            </td>
        </tr>
        </tbody>
    </table>

</div>
</div>
</div>
</div>


<!-- ========================================================= -->
<!-- ================= PROOF DETAILS MODAL (Upload/View/Edit) ================= -->
<!-- ========================================================= -->

<div class="modal fade" id="proofDetailsModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title fw-bold">Proof of Work</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <!-- Project Details -->
    <div class="border border-dark rounded mb-4 p-3">

        <div class="text-center mb-4">
            <h5 class="fw-bold">Project Details</h5>
        </div>

        <div class="row g-3 text-center">

            <div class="col-md-3 col-6">
                <div class="border p-3 rounded">
                    <strong>Project ID</strong>
                    <div id="proofProjectId">P001</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="border p-3 rounded">
                    <strong>Customer Name</strong>
                    <div id="proofCustomerName">Kasun Perera</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="border p-3 rounded">
                    <strong>Capacity</strong>
                    <div id="proofCapacity">10kW</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="border p-3 rounded">
                    <strong>Partner Company</strong>
                    <div id="proofPartnerCompany">ABC Energy</div>
                </div>
            </div>

        </div>

    </div>

    <!-- Work Sections -->
    @php
        $sections = [
            "panel_installation"        => "Panel Installation",
            "water_proofing"            => "Water Proofing on Roof Top",
            "railing_installation"      => "Railing Installation",
            "dc_wiring"                 => "DC Wiring",
            "inverter_installation"     => "Inverter Installation (Mounting, QR Code, Serial Number)",
            "combiner_box"              => "Combiner Box",
            "hybrid_battery"            => "Hybrid Battery (Optional)",
            "casing"                    => "Casing",
            "grounding"                 => "Grounding",
            "additional_work"           => "Additional Work (Optional)",
        ];
    @endphp

    <div class="accordion" id="proofAccordion">

        @foreach($sections as $key => $label)
        <div class="accordion-item mb-2 border rounded">

            <h2 class="accordion-header" id="heading_{{ $key }}">
                <button class="accordion-button collapsed fw-semibold"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse_{{ $key }}"
                        aria-expanded="false"
                        aria-controls="collapse_{{ $key }}">
                    {{ $label }}
                </button>
            </h2>

            <div id="collapse_{{ $key }}"
                 class="accordion-collapse collapse"
                 aria-labelledby="heading_{{ $key }}"
                 data-bs-parent="">

                <div class="accordion-body">

                    <!-- Upload area (shown in upload mode) -->
                    <div class="upload-area">

                        <!-- Preview thumbnails of uploaded/existing images -->
                        <div class="row g-2 mb-3 image-preview-row" id="preview_{{ $key }}">
                            <!-- Dynamically populated thumbnails appear here -->
                        </div>

                        <!-- Upload input (shown in upload & edit mode, hidden in view-only mode) -->
                        <div class="upload-input-wrapper">
                            <label class="form-label fw-semibold">
                                <span class="upload-action-label">Upload Photos</span>
                            </label>
                            <input type="file"
                                   class="form-control section-file-input"
                                   data-section="{{ $key }}"
                                   multiple
                                   accept="image/*">
                            <div class="form-text text-muted">You can select multiple images.</div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        @endforeach

    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <!-- Save button visible only in upload/edit mode -->
    <button class="btn btn-primary" id="proofSaveBtn">Save</button>
</div>

</div>
</div>
</div>


<!-- ========================================================= -->
<!-- ================= IMAGE LIGHTBOX MODAL ================= -->
<!-- ========================================================= -->

<div class="modal fade" id="imageLightboxModal" tabindex="-1" style="z-index:1090;">
<div class="modal-dialog modal-dialog-centered modal-xl">
<div class="modal-content bg-dark border-0">

    <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close btn-close-white ms-auto"
                data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body text-center px-4 pb-4">
        <img id="lightboxImage" src="" class="img-fluid rounded" style="max-height:75vh;" alt="Preview">
        <div class="mt-3">
            <!-- Change button visible in edit/upload mode only -->
            <button class="btn btn-warning me-2 d-none" id="lightboxChangeBtn">
                Change Image
            </button>
            <input type="file" id="lightboxChangeInput" class="d-none" accept="image/*">
        </div>
    </div>

</div>
</div>
</div>


<!-- ========================================================= -->
<!-- ================= SCRIPTS ================= -->
<!-- ========================================================= -->

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* =========================================================
       State
    ========================================================= */
    let currentMode   = 'upload'; // 'upload' | 'view'
    // Stores images per section: { section_key: [{ src, file }] }
    let sectionImages = {};

    let activeLightboxSection = null;
    let activeLightboxIndex   = null;

    /* =========================================================
       Bootstrap modals
    ========================================================= */
    const proofModal     = new bootstrap.Modal(document.getElementById('proofDetailsModal'));
    const lightboxModal  = new bootstrap.Modal(document.getElementById('imageLightboxModal'));
    const prevProjModal  = new bootstrap.Modal(document.getElementById('previousProjectModal'));

    /* =========================================================
       Open Proof Modal from Assigned / View Uploaded tables
    ========================================================= */
    document.querySelectorAll('.openProofModal').forEach(btn => {
        btn.addEventListener('click', function () {
            currentMode = this.dataset.mode || 'upload';
            openProofDetailsModal(currentMode);

            // Hide the parent modal first (Bootstrap handles stacking)
        });
    });

    /* =========================================================
       Previous Project – show Upload button after selecting project
    ========================================================= */
    document.getElementById('previousProjectSelect').addEventListener('change', function () {
        const wrapper = document.getElementById('previousUploadTriggerWrapper');
        wrapper.classList.toggle('d-none', !this.value);
    });

    document.getElementById('openPreviousProofBtn').addEventListener('click', function () {
        currentMode = 'upload';
        // Close previous project modal then open proof modal
        bootstrap.Modal.getInstance(document.getElementById('previousProjectModal')).hide();
        setTimeout(() => openProofDetailsModal('upload'), 400);
    });

    /* =========================================================
       Open Proof Details Modal
    ========================================================= */
    function openProofDetailsModal(mode) {
        // Upload inputs: visible in upload mode; hidden in view mode
        const uploadWrappers = document.querySelectorAll('.upload-input-wrapper');
        const saveBtn        = document.getElementById('proofSaveBtn');

        if (mode === 'view') {
            uploadWrappers.forEach(w => w.classList.add('d-none'));
            saveBtn.classList.add('d-none');
        } else {
            uploadWrappers.forEach(w => w.classList.remove('d-none'));
            saveBtn.classList.remove('d-none');
        }

        renderAllPreviews(mode);
        proofModal.show();
    }

    /* =========================================================
       File Input Change – add images to state & re-render
    ========================================================= */
    document.querySelectorAll('.section-file-input').forEach(input => {
        input.addEventListener('change', function () {
            const section = this.dataset.section;
            const files   = Array.from(this.files);

            if (!sectionImages[section]) sectionImages[section] = [];

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    sectionImages[section].push({ src: e.target.result, file });
                    renderPreview(section, currentMode);
                };
                reader.readAsDataURL(file);
            });

            // Reset input so same file can be re-selected if needed
            this.value = '';
        });
    });

    /* =========================================================
       Render Previews
    ========================================================= */
    function renderAllPreviews(mode) {
        document.querySelectorAll('.section-file-input').forEach(input => {
            renderPreview(input.dataset.section, mode);
        });
    }

    function renderPreview(section, mode) {
        const container = document.getElementById('preview_' + section);
        if (!container) return;

        container.innerHTML = '';
        const images = sectionImages[section] || [];

        images.forEach((imgObj, index) => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-3';

            col.innerHTML = `
                <div class="position-relative">
                    <img src="${imgObj.src}"
                         class="img-fluid rounded shadow-sm section-thumb"
                         style="width:100%;height:130px;object-fit:cover;cursor:pointer;"
                         data-section="${section}"
                         data-index="${index}"
                         alt="Photo">
                    ${mode !== 'view' ? `
                    <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-img-btn"
                            data-section="${section}" data-index="${index}"
                            style="line-height:1;padding:2px 6px;">&times;</button>` : ''}
                </div>`;

            container.appendChild(col);
        });

        // Bind thumb click → lightbox
        container.querySelectorAll('.section-thumb').forEach(img => {
            img.addEventListener('click', function () {
                openLightbox(this.dataset.section, parseInt(this.dataset.index), mode);
            });
        });

        // Bind remove buttons
        container.querySelectorAll('.remove-img-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const sec = this.dataset.section;
                const idx = parseInt(this.dataset.index);
                sectionImages[sec].splice(idx, 1);
                renderPreview(sec, currentMode);
            });
        });
    }

    /* =========================================================
       Lightbox
    ========================================================= */
    function openLightbox(section, index, mode) {
        activeLightboxSection = section;
        activeLightboxIndex   = index;

        const imgObj = sectionImages[section][index];
        document.getElementById('lightboxImage').src = imgObj.src;

        const changeBtn = document.getElementById('lightboxChangeBtn');
        if (mode !== 'view') {
            changeBtn.classList.remove('d-none');
        } else {
            changeBtn.classList.add('d-none');
        }

        lightboxModal.show();
    }

    // Change image from lightbox
    document.getElementById('lightboxChangeBtn').addEventListener('click', function () {
        document.getElementById('lightboxChangeInput').click();
    });

    document.getElementById('lightboxChangeInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file || activeLightboxSection === null) return;

        const reader = new FileReader();
        reader.onload = e => {
            sectionImages[activeLightboxSection][activeLightboxIndex] = { src: e.target.result, file };
            document.getElementById('lightboxImage').src = e.target.result;
            renderPreview(activeLightboxSection, currentMode);
        };
        reader.readAsDataURL(file);
        this.value = '';
    });

    /* =========================================================
       Save Button
    ========================================================= */
    document.getElementById('proofSaveBtn').addEventListener('click', function () {
        // TODO: Implement actual save/upload logic (FormData / AJAX)
        alert('Photos saved successfully!');
        proofModal.hide();
    });

});
</script>

@endsection