@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-grid gap-4 col-8 mx-auto">


                <button class="btn btn-dark p-4" data-bs-toggle="modal" data-bs-target="#systemModal">
                    System Activity Log
                </button>

                <button class="btn btn-secondary p-4" data-bs-toggle="modal" data-bs-target="#userModal">
                    User Activity Report
                </button>


                <!-- MODAL 1: SYSTEM ACTIVITY LOG -->
                <div class="modal fade" id="systemModal" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title">System Activity Log</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center align-middle data-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Event</th>
                                                <th>Module</th>
                                                <th>Severity</th>
                                                <th>Status</th>
                                                <th>Triggered By</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($systemLogs ?? [] as $log)
                                                <tr>
                                                    <td>{{ $log['id'] }}</td>
                                                    <td>{{ $log['event'] }}</td>
                                                    <td>{{ $log['module'] }}</td>
                                                    <td>{{ $log['severity'] }}</td>
                                                    <td>{{ $log['status'] }}</td>
                                                    <td>{{ $log['triggered_by'] }}</td>
                                                    <td>{{ $log['date'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <button class="btn btn-outline-dark btn-sm"
                                        onclick="printModal('systemModal', 'System Activity Log')">Print</button>
                                    <button class="btn btn-outline-success btn-sm">Export Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL 2: USER ACTIVITY REPORT -->
                <div class="modal fade" id="userModal" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-secondary text-white">
                                <h5 class="modal-title">User Activity Report</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center align-middle data-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>User ID</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Username</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users ?? [] as $idx => $u)
                                                <tr>
                                                    <td>{{ $u['id'] }}</td>
                                                    <td>{{ $u['name'] }}</td>
                                                    <td>{{ $u['role'] }}</td>
                                                    <td>{{ $u['email'] }}</td>
                                                    <td>{{ $u['status'] }}</td>
                                                    <td>{{ $u['created'] }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary"
                                                            onclick="showDetail('user', {{ $idx }}, 'userModal')">View</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <button class="btn btn-outline-dark btn-sm"
                                        onclick="printModal('userModal', 'User Activity Report')">Print</button>
                                    <button class="btn btn-outline-success btn-sm">Export Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           

    <!-- DETAIL MODAL (shared for both roles) -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailTitle">Detailed View</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent"></div>
                <div class="modal-footer">
                    <button class="btn btn-outline-dark btn-sm me-auto" onclick="printDetailTable()">Print</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        const data = {
            system: @json($systemLogs ?? []),
            user: @json($users ?? []),
            userLogs: @json($userLogs ?? []),
            technician: @json($technicians ?? []),
            techProjects: @json($techProjects ?? []),
            project: @json($projects ?? []),
            attendance: @json($attendance ?? []),
            attendanceHistory: @json($attendanceHistory ?? []),
            partner: @json($partners ?? []),
            partnerProjects: @json($partnerProjects ?? []),
        };

        let detailState = {};
        let sourceModalId = null;

        function showDetail(type, idx, fromModalId) {
            sourceModalId = fromModalId;
            let html = '';
            let title = 'Detailed View';
            detailState = {};

            if (type === 'user') {
                const u = data.user[idx];
                const logs = data.userLogs[u.id] || [];
                title = `Login History — ${u.name}`;
                detailState.loginLogs = logs;
                html = `
                    <p class="mb-2 text-muted"><strong>User:</strong> ${u.name} &nbsp;|&nbsp; <strong>Role:</strong> ${u.role} &nbsp;|&nbsp; <strong>Email:</strong> ${u.email}</p>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-dark"><tr><th>#</th><th>IP Address</th><th>Device / Browser</th><th>Login Date & Time</th><th>Logout Date & Time</th></tr></thead>
                        <tbody id="loginLogBody">${renderLoginRows(logs, 5)}</tbody>
                    </table></div>`;

            } else if (type === 'technician') {
                const t = data.technician[idx];
                const projects = data.techProjects[t.id] || {
                    completed: [],
                    pending: []
                };
                title = `Projects — ${t.name}`;
                detailState.techCompleted = projects.completed;
                detailState.techPending = projects.pending;
                html = `
                    <p class="mb-2 text-muted"><strong>Technician:</strong> ${t.name}</p>
                    <h6 class="fw-bold text-success mt-3 mb-2">Completed Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-success"><tr><th>#</th><th>Project ID</th><th>Project Name</th><th>Completed Date</th></tr></thead>
                        <tbody id="techCompletedBody">${renderTechCompletedRows(projects.completed, 5)}</tbody>
                    </table></div>
                    <h6 class="fw-bold text-danger mt-4 mb-2">Pending Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-danger"><tr><th>#</th><th>Project ID</th><th>Project Name</th><th>Due Date</th></tr></thead>
                        <tbody id="techPendingBody">${renderTechPendingRows(projects.pending, 5)}</tbody>
                    </table></div>`;

            } else if (type === 'project') {
                const p = data.project[idx];
                title = `Project Details — ${p.id}`;
                html = `
                    <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <tbody>
                            <tr><th class="table-light" style="width:35%">Project ID</th><td>${p.id}</td></tr>
                            <tr><th class="table-light">Customer Name</th><td>${p.customer}</td></tr>
                            <tr><th class="table-light">Location</th><td>${p.location}</td></tr>
                            <tr><th class="table-light">Capacity</th><td>${p.capacity}</td></tr>
                            <tr><th class="table-light">Start Date</th><td>${p.start}</td></tr>
                            <tr><th class="table-light">End Date</th><td>${p.end}</td></tr>
                            <tr><th class="table-light">Assigned Technician</th><td>${p.tech}</td></tr>
                            <tr><th class="table-light">Partner Company</th><td>${p.partner}</td></tr>
                            <tr><th class="table-light">Status</th><td>${p.status}</td></tr>
                            <tr><th class="table-light">Additional Work</th><td>${p.addWork}</td></tr>
                        </tbody>
                    </table></div>`;

            } else if (type === 'attendance') {
                const a = data.attendance[idx];
                const history = data.attendanceHistory[a.id] || [];
                title = `Attendance History — ${a.name}`;
                detailState.attendanceHistory = history;
                html = `
                    <p class="mb-2 text-muted"><strong>Technician:</strong> ${a.name}</p>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-dark"><tr><th>#</th><th>Month</th><th>Present Days</th><th>Absent Days</th><th>Leave Days</th></tr></thead>
                        <tbody id="attendanceHistoryBody">${renderAttendanceRows(history, 5)}</tbody>
                    </table></div>`;

            } else if (type === 'partner') {
                const p = data.partner[idx];
                const projects = data.partnerProjects[p.id] || {
                    completed: [],
                    ongoing: []
                };
                title = `Projects — ${p.company}`;
                html = `
                    <p class="mb-2 text-muted"><strong>Partner:</strong> ${p.company}</p>
                    <h6 class="fw-bold text-success mt-3 mb-2">Completed Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-success"><tr><th>#</th><th>Project ID</th><th>Customer</th><th>Location</th><th>Capacity</th><th>Completed Date</th></tr></thead>
                        <tbody id="partnerCompletedBody">${renderPartnerCompletedRows(projects.completed, 5)}</tbody>
                    </table></div>
                    <h6 class="fw-bold text-primary mt-4 mb-2">Ongoing Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-primary"><tr><th>#</th><th>Project ID</th><th>Customer</th><th>Location</th><th>Capacity</th><th>Start Date</th></tr></thead>
                        <tbody id="partnerOngoingBody">${renderPartnerOngoingRows(projects.ongoing, 5)}</tbody>
                    </table></div>`;
            }

            document.getElementById('detailTitle').innerText = title;
            document.getElementById('detailContent').innerHTML = html;

            const sourceEl = document.getElementById(sourceModalId);
            const detailEl = document.getElementById('detailModal');
            bootstrap.Modal.getInstance(sourceEl)?.hide();
            sourceEl.addEventListener('hidden.bs.modal', function handler() {
                new bootstrap.Modal(detailEl).show();
                sourceEl.removeEventListener('hidden.bs.modal', handler);
            });
        }

        function printModal(modalId, title) {
            const table = document.querySelector(`#${modalId} table`).outerHTML;
            openPrintWindow(title, table);
        }

        function printDetailTable() {
            const title = document.getElementById('detailTitle').innerText;
            const content = document.getElementById('detailContent').innerHTML;
            openPrintWindow(title, content);
        }

        function openPrintWindow(title, content) {
            const win = window.open('', '_blank');
            win.document.write(`
                <!DOCTYPE html><html>
                <head>
                    <title>${title}</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                    <style>body{padding:24px;}@media print{@page{margin:15mm;}}</style>
                </head>
                <body><h5>${title}</h5>${content}
                <script>window.onload=function(){window.print();window.close();}<\/script>
                </body></html>`);
            win.document.close();
        }

        // Render helpers (keep your existing ones or use empty fallbacks)
        function renderLoginRows(rows, limit) {
            return (limit == -1 ? rows : rows.slice(0, limit)).map((r, i) =>
                    `<tr><td>${i+1}</td><td>${r.ip}</td><td>${r.device}</td><td>${r.login}</td><td>${r.logout}</td></tr>`)
                .join('') || '<tr><td colspan="5">No data.</td></tr>';
        }

        function renderTechCompletedRows(rows, limit) {
            return (limit == -1 ? rows : rows.slice(0, limit)).map((r, i) =>
                    `<tr><td>${i+1}</td><td>${r.id}</td><td>${r.name}</td><td>${r.date}</td></tr>`).join('') ||
                '<tr><td colspan="4">No data.</td></tr>';
        }

        function renderTechPendingRows(rows, limit) {
            return (limit == -1 ? rows : rows.slice(0, limit)).map((r, i) =>
                    `<tr><td>${i+1}</td><td>${r.id}</td><td>${r.name}</td><td>${r.due}</td></tr>`).join('') ||
                '<tr><td colspan="4">No data.</td></tr>';
        }

        function renderAttendanceRows(rows, limit) {
            return (limit == -1 ? rows : rows.slice(0, limit)).map((r, i) =>
                `<tr><td>${i+1}</td><td>${r.month}</td><td>${r.present}</td><td>${r.absent}</td><td>${r.leave}</td></tr>`
            ).join('') || '<tr><td colspan="5">No data.</td></tr>';
        }

        function renderPartnerCompletedRows(rows, limit) {
            return (limit == -1 ? rows : rows.slice(0, limit)).map((r, i) =>
                `<tr><td>${i+1}</td><td>${r.id}</td><td>${r.customer}</td><td>${r.location}</td><td>${r.capacity}</td><td>${r.date}</td></tr>`
            ).join('') || '<tr><td colspan="6">No data.</td></tr>';
        }

        function renderPartnerOngoingRows(rows, limit) {
            return (limit == -1 ? rows : rows.slice(0, limit)).map((r, i) =>
                `<tr><td>${i+1}</td><td>${r.id}</td><td>${r.customer}</td><td>${r.location}</td><td>${r.capacity}</td><td>${r.start}</td></tr>`
            ).join('') || '<tr><td colspan="6">No data.</td></tr>';
        }
    </script>
@endsection
