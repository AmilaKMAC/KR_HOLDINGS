@extends('layout.app')

@section('content')

<div class="container-fluid py-4">

    <!-- ================= PAGE TITLE ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4 class="fw-bold mb-0">Proof of Work Review for Approval</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= PENDING APPROVAL TABLE ================= -->
    <div class="row justify-content-center mb-5">
        <div class="col-12 col-xxl-11">
            <div class="card shadow-sm">
                <div class="card-header bg-warning bg-opacity-25">
                    <h6 class="fw-bold mb-0 text-warning-emphasis">Pending Approval</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Approval</th>
                                <th>Partner Company</th>
                                <th>Technician ID's</th>
                                <th>Additional Work</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody id="pendingTableBody">
                            <tr
                                data-project-id="P001"
                                data-customer="Kasun Perera"
                                data-location="Colombo"
                                data-capacity="10kW"
                                data-partner="ABC Solar"
                                data-technicians="T01, T02"
                                data-additional="">
                                <td>P001</td>
                                <td>Kasun Perera</td>
                                <td>Colombo</td>
                                <td>10kW</td>
                                <td>
                                    <button class="btn btn-sm btn-warning approval-trigger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#approvalModal">
                                        Approve
                                    </button>
                                </td>
                                <td>ABC Solar</td>
                                <td>T01, T02</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary additional-work-trigger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#additionalWorkModal">
                                        Select Work
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary view-btn">View</button>
                                </td>
                            </tr>
                            <tr
                                data-project-id="P002"
                                data-customer="Nimal Silva"
                                data-location="Kandy"
                                data-capacity="5kW"
                                data-partner="SunTech Lanka"
                                data-technicians="T03, T04"
                                data-additional="">
                                <td>P002</td>
                                <td>Nimal Silva</td>
                                <td>Kandy</td>
                                <td>5kW</td>
                                <td>
                                    <button class="btn btn-sm btn-warning approval-trigger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#approvalModal">
                                        Approve
                                    </button>
                                </td>
                                <td>SunTech Lanka</td>
                                <td>T03, T04</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary additional-work-trigger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#additionalWorkModal">
                                        Select Work
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary view-btn">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= APPROVED PROJECTS TABLE ================= -->
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
            <div class="card shadow-sm">
                <div class="card-header bg-success bg-opacity-25">
                    <h6 class="fw-bold mb-0 text-success-emphasis">Approved Projects</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Partner Company</th>
                                <th>Technician ID's</th>
                                <th>Additional Work</th>
                                <th>Approved At</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody id="approvedTableBody">
                            <tr id="approvedEmptyRow" style="display:none;">
                                <td colspan="9" class="text-muted fst-italic py-3">No approved projects yet.</td>
                            </tr>
                            <tr>
                                <td>P003</td>
                                <td>Sunil Fernando</td>
                                <td>Galle</td>
                                <td>8kW</td>
                                <td>GreenPower Co.</td>
                                <td>T05, T06</td>
                                <td>Panel Lifting, Extra Cabling</td>
                                <td><span class="badge bg-success">12/02/2025, 10:30 AM</span></td>
                                <td><button class="btn btn-sm btn-primary view-btn">View</button></td>
                            </tr>
                            <tr>
                                <td>P004</td>
                                <td>Amara Jayasinghe</td>
                                <td>Negombo</td>
                                <td>15kW</td>
                                <td>SolarMax PVT</td>
                                <td>T07, T08, T09</td>
                                <td>Structure Reinforcement</td>
                                <td><span class="badge bg-success">18/02/2025, 02:15 PM</span></td>
                                <td><button class="btn btn-sm btn-primary view-btn">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>



<!-- ================= ADDITIONAL WORK MODAL ================= -->
<div class="modal fade" id="additionalWorkModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Additional Work</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-start">
                <div class="form-check">
                    <input class="form-check-input additional-work-check" type="checkbox" id="wire1" value="Ground Mounting Wire">
                    <label class="form-check-label" for="wire1">Ground Mounting Wire</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input additional-work-check" type="checkbox" id="lift1" value="Panel Lifting">
                    <label class="form-check-label" for="lift1">Panel Lifting</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input additional-work-check" type="checkbox" id="angle1" value="Angle Adjust">
                    <label class="form-check-label" for="angle1">Angle Adjust</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input additional-work-check" type="checkbox" id="cable1" value="Extra Cabling">
                    <label class="form-check-label" for="cable1">Extra Cabling</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input additional-work-check" type="checkbox" id="structure1" value="Structure Reinforcement">
                    <label class="form-check-label" for="structure1">Structure Reinforcement</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveAdditionalWork">Save Selection</button>
            </div>
        </div>
    </div>
</div>



<!-- ================= APPROVAL MODAL ================= -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="fw-bold mb-4">Select Approval Status</p>
                <button type="button" id="approveYesBtn" class="btn btn-success me-3 px-4">YES</button>
                <button type="button" id="approveNoBtn" class="btn btn-danger px-4">NO</button>
            </div>
        </div>
    </div>
</div>



<!-- ================= PHOTO REVIEW MODAL ================= -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow">

            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title fw-semibold me-auto">Installation Photo Review</h5>
                <button class="btn btn-sm btn-danger me-2"
                        data-bs-toggle="modal"
                        data-bs-target="#messageModal">
                    Report Issue
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="text-end mb-4">
                    <a href="#" class="btn btn-success">Download All Photos</a>
                </div>

                @php
                    $sections = [
                        "Panel Installation",
                        "Waterproofing (Roof Top)",
                        "Railing Installation",
                        "DC Wiring",
                        "Inverter Installation",
                        "Combiner Boxes",
                        "Hybrid Battery (Optional)",
                        "Casing",
                        "Grounding",
                        "Additional Work (Optional)"
                    ];
                @endphp

                @foreach($sections as $section)
                <div class="mb-5">
                    <h6 class="fw-bold text-primary mb-3">{{ $section }}</h6>
                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="https://via.placeholder.com/600x400"
                                 class="img-fluid rounded shadow-sm preview-image"
                                 style="cursor:pointer" alt="Photo">
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="https://via.placeholder.com/600x400"
                                 class="img-fluid rounded shadow-sm preview-image"
                                 style="cursor:pointer" alt="Photo">
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>



<!-- ================= MESSAGE TECHNICIAN MODAL ================= -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Send Message to Technician</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Issue Type</label>
                    <select class="form-select">
                        <option>Missing Photo</option>
                        <option>Incorrect Installation</option>
                        <option>Incomplete Work</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" rows="4"
                        placeholder="Describe the issue clearly..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger">Send Message</button>
            </div>
        </div>
    </div>
</div>



<!-- ================= IMAGE PREVIEW MODAL ================= -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" class="img-fluid rounded mb-3" style="max-height:75vh;">
                <div>
                    <a id="downloadImageBtn" href="#" download class="btn btn-success">Download Image</a>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function () {

    const photoModal          = new bootstrap.Modal(document.getElementById('photoModal'));
    const previewModal        = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    const approvalModal       = new bootstrap.Modal(document.getElementById('approvalModal'));
    const additionalWorkModal = new bootstrap.Modal(document.getElementById('additionalWorkModal'));

    let activeRow = null;

    /* -------- View button -------- */
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('view-btn')) {
            photoModal.show();
        }
    });

    /* -------- Approval trigger -------- */
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('approval-trigger')) {
            activeRow = e.target.closest('tr');
        }
    });

    /* -------- Additional Work trigger -------- */
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('additional-work-trigger')) {
            activeRow = e.target.closest('tr');
            document.querySelectorAll('.additional-work-check').forEach(cb => cb.checked = false);
            const saved = activeRow.dataset.additional || '';
            if (saved) {
                saved.split(', ').forEach(val => {
                    document.querySelectorAll('.additional-work-check').forEach(cb => {
                        if (cb.value === val) cb.checked = true;
                    });
                });
            }
        }
    });

    /* -------- Save Additional Work -------- */
    document.getElementById('saveAdditionalWork').addEventListener('click', function () {
        if (!activeRow) return;
        const selected = [];
        document.querySelectorAll('.additional-work-check:checked').forEach(cb => selected.push(cb.value));
        activeRow.dataset.additional = selected.join(', ');
        const trigger = activeRow.querySelector('.additional-work-trigger');
        trigger.textContent = selected.length > 0 ? `${selected.length} Selected` : 'Select Work';
        additionalWorkModal.hide();
    });

    /* -------- YES → move row to Approved table -------- */
    document.getElementById('approveYesBtn').addEventListener('click', function () {
        if (!activeRow) return;

        const approvedAt = new Date().toLocaleString();
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${activeRow.dataset.projectId}</td>
            <td>${activeRow.dataset.customer}</td>
            <td>${activeRow.dataset.location}</td>
            <td>${activeRow.dataset.capacity}</td>
            <td>${activeRow.dataset.partner}</td>
            <td>${activeRow.dataset.technicians}</td>
            <td>${activeRow.dataset.additional || '—'}</td>
            <td><span class="badge bg-success">${approvedAt}</span></td>
            <td><button class="btn btn-sm btn-primary view-btn">View</button></td>
        `;

        const emptyRow = document.getElementById('approvedEmptyRow');
        if (emptyRow) emptyRow.style.display = 'none';

        document.getElementById('approvedTableBody').appendChild(newRow);
        activeRow.remove();

        approvalModal.hide();
        activeRow = null;
    });

    /* -------- NO → just close -------- */
    document.getElementById('approveNoBtn').addEventListener('click', function () {
        approvalModal.hide();
        activeRow = null;
    });

    /* -------- Image preview -------- */
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('preview-image')) {
            const src = e.target.getAttribute('src');
            document.getElementById('previewImage').src = src;
            document.getElementById('downloadImageBtn').href = src;
            previewModal.show();
        }
    });

});
</script>

@endsection