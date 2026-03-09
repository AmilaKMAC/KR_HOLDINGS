@extends('layout.app')

@section('content')

<div class="container mt-5">
    <div class="d-grid gap-4 col-8 mx-auto">

        <button class="btn btn-dark p-4 report-btn"
                data-report="technician"
                data-title="Technician Level">
            Technician Level
        </button>

        <button class="btn btn-secondary p-4 report-btn"
                data-report="work"
                data-title="Additional Work">
            Additional Work
        </button>

        <button class="btn btn-primary p-4 report-btn"
                data-report="solar"
                data-title="Solar">
            Solar
        </button>

        <button class="btn btn-warning p-4 report-btn"
                data-report="partner"
                data-title="Partner Company">
            Partner Company
        </button>

    </div>
</div>


<!-- ===================== MAIN REPORT MODAL ===================== -->
<div class="modal fade" id="reportModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-dark text-white">
    <h5 class="modal-title" id="reportTitle"></h5>
    <button type="button" class="btn-close btn-close-white"
            data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle" id="mainReportTable">
            <thead class="table-light">
                <tr id="tableHead"></tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>

    <!-- Bottom Controls -->
    <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-success btn-sm" id="addNewBtn">+ Add New</button>
    </div>

</div>
</div>
</div>
</div>


<!-- ================================================== ADD / EDIT MODALS ================================================== -->

<!-- Add Technician Modal -->
<div class="modal fade" id="addTechnicianModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Add Technician Level</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-3" placeholder="Level">
                <input type="number" class="form-control" placeholder="Basic Salary">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Technician Modal -->
<div class="modal fade" id="editTechnicianModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5>Edit Technician Level</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-3" value="L01">
                <input type="number" class="form-control" value="25000">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Additional Work Modal -->
<div class="modal fade" id="addWorkModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Add Additional Work</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" placeholder="Description">
                <input class="form-control" placeholder="Rate">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Additional Work Modal -->
<div class="modal fade" id="editWorkModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5>Edit Additional Work</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" value="Panel Lifting">
                <input class="form-control" value="200">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Solar Modal -->
<div class="modal fade" id="addSolarModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Add Solar Rate</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" placeholder="ID">
                <input class="form-control mb-2" placeholder="Capacity">
                <input class="form-control" placeholder="Rate">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Solar Modal -->
<div class="modal fade" id="editSolarModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5>Edit Solar</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" value="C01">
                <input class="form-control mb-2" value="1-3 kW">
                <input class="form-control" value="500">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Partner Modal -->
<div class="modal fade" id="addPartnerModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Add New Partner</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" placeholder="Partner ID">
                <input class="form-control mb-2" placeholder="Company Name">
                <select class="form-select mb-2">
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
                <input type="date" class="form-control">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Partner Modal -->
<div class="modal fade" id="editPartnerModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5>Edit Partner</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" value="P01">
                <input class="form-control mb-2" value="Hayleys">
                <select class="form-select mb-2">
                    <option selected>Active</option>
                    <option>Inactive</option>
                </select>
                <input type="date" class="form-control" value="2023-02-15">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>


<script>

let currentReport = null;

// ── Report Config ─────────────────────────────────────────────────────────────
const reportConfig = {
    technician: {
        headers:  ["Level", "Basic Salary", "Action"],
        addModal: "addTechnicianModal",
        rows: [
            ["L01", "25,000", `<button class="btn btn-sm btn-primary" onclick="openEdit('editTechnicianModal')">Edit</button>`],
            ["L02", "30,000", `<button class="btn btn-sm btn-primary" onclick="openEdit('editTechnicianModal')">Edit</button>`],
        ]
    },
    work: {
        headers:  ["Description", "Rate", "Action"],
        addModal: "addWorkModal",
        rows: [
            ["Panel Lifting", "200", `<button class="btn btn-sm btn-primary" onclick="openEdit('editWorkModal')">Edit</button>`],
            ["Wiring Setup",  "350", `<button class="btn btn-sm btn-primary" onclick="openEdit('editWorkModal')">Edit</button>`],
        ]
    },
    solar: {
        headers:  ["ID", "Capacity", "Rate", "Action"],
        addModal: "addSolarModal",
        rows: [
            ["C01", "1-3 kW",  "500", `<button class="btn btn-sm btn-primary" onclick="openEdit('editSolarModal')">Edit</button>`],
            ["C02", "4-7 kW",  "750", `<button class="btn btn-sm btn-primary" onclick="openEdit('editSolarModal')">Edit</button>`],
            ["C03", "8-10 kW", "950", `<button class="btn btn-sm btn-primary" onclick="openEdit('editSolarModal')">Edit</button>`],
        ]
    },
    partner: {
        headers:  ["Partner ID", "Company Name", "Status", "Date Added", "Action"],
        addModal: "addPartnerModal",
        rows: [
            ["P01", "Hayleys",    `<span class="badge bg-success">Active</span>`,   "2023-02-15", `<button class="btn btn-sm btn-primary" onclick="openEdit('editPartnerModal')">Edit</button>`],
            ["P02", "SolarTech",  `<span class="badge bg-success">Active</span>`,   "2023-06-10", `<button class="btn btn-sm btn-primary" onclick="openEdit('editPartnerModal')">Edit</button>`],
            ["P03", "EcoPower",   `<span class="badge bg-danger">Inactive</span>`,  "2024-01-05", `<button class="btn btn-sm btn-primary" onclick="openEdit('editPartnerModal')">Edit</button>`],
        ]
    },
};

// ── Open main modal ───────────────────────────────────────────────────────────
document.querySelectorAll('.report-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        currentReport = this.dataset.report;
        document.getElementById('reportTitle').innerText = this.dataset.title;
        loadTable();
        new bootstrap.Modal(document.getElementById('reportModal')).show();
    });
});

// ── Add New button ────────────────────────────────────────────────────────────
document.getElementById('addNewBtn').addEventListener('click', function () {
    const addModalId = reportConfig[currentReport]?.addModal;
    if (!addModalId) return;

    const reportModalEl = document.getElementById('reportModal');
    bootstrap.Modal.getInstance(reportModalEl)?.hide();

    reportModalEl.addEventListener('hidden.bs.modal', function openAdd() {
        new bootstrap.Modal(document.getElementById(addModalId)).show();
        reportModalEl.removeEventListener('hidden.bs.modal', openAdd);
    });
});

// ── Load table ────────────────────────────────────────────────────────────────
function loadTable() {
    const config = reportConfig[currentReport];
    const head   = document.getElementById('tableHead');
    const body   = document.getElementById('tableBody');
    head.innerHTML = "";
    body.innerHTML = "";

    config.headers.forEach(h => { head.innerHTML += `<th>${h}</th>`; });

    config.rows.forEach(r => {
        let rowHtml = "<tr>";
        r.forEach(c => { rowHtml += `<td>${c}</td>`; });
        rowHtml += "</tr>";
        body.innerHTML += rowHtml;
    });
}

// ── Open edit modal (hide report modal first) ─────────────────────────────────
function openEdit(editModalId) {
    const reportModalEl = document.getElementById('reportModal');
    bootstrap.Modal.getInstance(reportModalEl)?.hide();

    reportModalEl.addEventListener('hidden.bs.modal', function openEditModal() {
        new bootstrap.Modal(document.getElementById(editModalId)).show();
        reportModalEl.removeEventListener('hidden.bs.modal', openEditModal);
    });
}

</script>

@endsection