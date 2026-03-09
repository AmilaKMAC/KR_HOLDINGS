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

            <button class="btn btn-primary p-4" data-bs-toggle="modal" data-bs-target="#technicianModal">
                Technician Performance
            </button>

            <button class="btn btn-success p-4" data-bs-toggle="modal" data-bs-target="#projectModal">
                Project Progress
            </button>

            <button class="btn btn-warning p-4" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                Attendance Summary
            </button>

            <button class="btn btn-info p-4" data-bs-toggle="modal" data-bs-target="#partnerModal">
                Partner Companies
            </button>

        </div>
    </div>


    <!-- ===================== MODAL 1: SYSTEM ACTIVITY LOG ===================== -->
    <div class="modal fade" id="systemModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">System Activity Log</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
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
                                @foreach($systemLogs ?? [] as $log)
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
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        @include('others.limit_btn_group')
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-dark btn-sm" onclick="printModal('systemModal', 'System Activity Log')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== MODAL 2: USER ACTIVITY REPORT ===================== -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">User Activity Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users ?? [] as $idx => $u)
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
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        @include('others.limit_btn_group')
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-dark btn-sm" onclick="printModal('userModal', 'User Activity Report')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== MODAL 3: TECHNICIAN PERFORMANCE ===================== -->
    <div class="modal fade" id="technicianModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Technician Performance Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tech ID</th>
                                    <th>Technician Name</th>
                                    <th>Total Projects</th>
                                    <th>Completed</th>
                                    <th>Pending</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($technicians ?? [] as $idx => $t)
                                <tr>
                                    <td>{{ $t['id'] }}</td>
                                    <td>{{ $t['name'] }}</td>
                                    <td>{{ $t['total'] }}</td>
                                    <td>{{ $t['completed'] }}</td>
                                    <td>{{ $t['pending'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="showDetail('technician', {{ $idx }}, 'technicianModal')">View</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        @include('others.limit_btn_group')
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-dark btn-sm" onclick="printModal('technicianModal', 'Technician Performance Report')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== MODAL 4: PROJECT PROGRESS ===================== -->
    <div class="modal fade" id="projectModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Project Progress Summary</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Project ID</th>
                                    <th>Customer Name</th>
                                    <th>Location</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects ?? [] as $idx => $p)
                                <tr>
                                    <td>{{ $p['id'] }}</td>
                                    <td>{{ $p['customer'] }}</td>
                                    <td>{{ $p['location'] }}</td>
                                    <td>{{ $p['capacity'] }}</td>
                                    <td>{{ $p['status'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="showDetail('project', {{ $idx }}, 'projectModal')">View</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        @include('others.limit_btn_group')
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-dark btn-sm" onclick="printModal('projectModal', 'Project Progress Summary')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== MODAL 5: ATTENDANCE SUMMARY ===================== -->
    <div class="modal fade" id="attendanceModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Attendance Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Employee</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Leave</th>
                                    <th>Month</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance ?? [] as $idx => $a)
                                <tr>
                                    <td>{{ $a['id'] }}</td>
                                    <td>{{ $a['name'] }}</td>
                                    <td>{{ $a['present'] }}</td>
                                    <td>{{ $a['absent'] }}</td>
                                    <td>{{ $a['leave'] }}</td>
                                    <td>February 2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="showDetail('attendance', {{ $idx }}, 'attendanceModal')">View</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        @include('others.limit_btn_group')
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-dark btn-sm" onclick="printModal('attendanceModal', 'Attendance Summary')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== MODAL 6: PARTNER COMPANIES ===================== -->
    <div class="modal fade" id="partnerModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Partner Company Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Partner ID</th>
                                    <th>Company Name</th>
                                    <th>Total Projects</th>
                                    <th>Completed</th>
                                    <th>Ongoing</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($partners ?? [] as $idx => $p)
                                <tr>
                                    <td>{{ $p['id'] }}</td>
                                    <td>{{ $p['company'] }}</td>
                                    <td>{{ $p['total'] }}</td>
                                    <td>{{ $p['completed'] }}</td>
                                    <td>{{ $p['ongoing'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="showDetail('partner', {{ $idx }}, 'partnerModal')">View</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        @include('others.limit_btn_group')
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-dark btn-sm" onclick="printModal('partnerModal', 'Partner Company Report')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===================== DETAIL MODAL ===================== -->
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
            system:            @json($systemLogs ?? []),
            user:              @json($users ?? []),
            userLogs:          @json($userLogs ?? []),
            technician:        @json($technicians ?? []),
            techProjects:      @json($techProjects ?? []),
            project:           @json($projects ?? []),
            attendance:        @json($attendance ?? []),
            attendanceHistory: @json($attendanceHistory ?? []),
            partner:           @json($partners ?? []),
            partnerProjects:   @json($partnerProjects ?? []),
        };

        let detailState   = {};
        let sourceModalId = null;

        // ── Show detail modal ─────────────────────────────────────────────────────────
        function showDetail(type, idx, fromModalId) {
            sourceModalId = fromModalId;
            let html  = '';
            let title = 'Detailed View';
            detailState   = {};

            if (type === 'user') {
                const u    = data.user[idx];
                const logs = data.userLogs[u.id] || [];
                title = `Login History — ${u.name}`;
                detailState.loginLogs = logs;
                html = `
                    <p class="mb-2 text-muted"><strong>User:</strong> ${u.name} &nbsp;|&nbsp; <strong>Role:</strong> ${u.role} &nbsp;|&nbsp; <strong>Email:</strong> ${u.email}</p>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-dark"><tr><th>#</th><th>IP Address</th><th>Device / Browser</th><th>Login Date & Time</th><th>Logout Date & Time</th></tr></thead>
                        <tbody id="loginLogBody">${renderLoginRows(logs, 5)}</tbody>
                    </table></div>
                    ${detailLimitBtns('loginLog')}`;

            } else if (type === 'technician') {
                const t        = data.technician[idx];
                const projects = data.techProjects[t.id] || { completed: [], pending: [] };
                title = `Projects — ${t.name}`;
                detailState.techCompleted = projects.completed;
                detailState.techPending   = projects.pending;
                html = `
                    <p class="mb-2 text-muted"><strong>Technician:</strong> ${t.name} &nbsp;|&nbsp; <strong>Total:</strong> ${t.total} &nbsp;|&nbsp; <strong>Completed:</strong> ${t.completed} &nbsp;|&nbsp; <strong>Pending:</strong> ${t.pending}</p>
                    <h6 class="fw-bold text-success mt-3 mb-2">Completed Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-success"><tr><th>#</th><th>Project ID</th><th>Project Name</th><th>Completed Date</th></tr></thead>
                        <tbody id="techCompletedBody">${renderTechCompletedRows(projects.completed, 5)}</tbody>
                    </table></div>
                    ${detailLimitBtns('techCompleted')}
                    <h6 class="fw-bold text-danger mt-4 mb-2">Pending Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-danger"><tr><th>#</th><th>Project ID</th><th>Project Name</th><th>Due Date</th></tr></thead>
                        <tbody id="techPendingBody">${renderTechPendingRows(projects.pending, 5)}</tbody>
                    </table></div>
                    ${detailLimitBtns('techPending')}`;

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
                const a       = data.attendance[idx];
                const history = data.attendanceHistory[a.id] || [];
                title = `Attendance History — ${a.name}`;
                detailState.attendanceHistory = history;
                html = `
                    <p class="mb-2 text-muted"><strong>Technician:</strong> ${a.name} &nbsp;|&nbsp; Present: <span class="text-success fw-bold">${a.present}</span> &nbsp; Absent: <span class="text-danger fw-bold">${a.absent}</span> &nbsp; Leave: <span class="text-warning fw-bold">${a.leave}</span></p>
                    <h6 class="fw-bold mb-2">Previous Monthly Attendance</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-dark"><tr><th>#</th><th>Month</th><th>Present Days</th><th>Absent Days</th><th>Leave Days</th></tr></thead>
                        <tbody id="attendanceHistoryBody">${renderAttendanceRows(history, 5)}</tbody>
                    </table></div>
                    ${detailLimitBtns('attendanceHistory')}`;

            } else if (type === 'partner') {
                const p        = data.partner[idx];
                const projects = data.partnerProjects[p.id] || { completed: [], ongoing: [] };
                title = `Projects — ${p.company}`;
                detailState.partnerCompleted = projects.completed;
                detailState.partnerOngoing   = projects.ongoing;
                html = `
                    <p class="mb-2 text-muted"><strong>Partner:</strong> ${p.company} &nbsp;|&nbsp; <strong>Total:</strong> ${p.total} &nbsp;|&nbsp; <strong>Completed:</strong> ${p.completed} &nbsp;|&nbsp; <strong>Ongoing:</strong> ${p.ongoing}</p>
                    <h6 class="fw-bold text-success mt-3 mb-2">Completed Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-success"><tr><th>#</th><th>Project ID</th><th>Customer</th><th>Location</th><th>Capacity</th><th>Completed Date</th></tr></thead>
                        <tbody id="partnerCompletedBody">${renderPartnerCompletedRows(projects.completed, 5)}</tbody>
                    </table></div>
                    ${detailLimitBtns('partnerCompleted')}
                    <h6 class="fw-bold text-primary mt-4 mb-2">Ongoing Projects</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
                        <thead class="table-primary"><tr><th>#</th><th>Project ID</th><th>Customer</th><th>Location</th><th>Capacity</th><th>Start Date</th></tr></thead>
                        <tbody id="partnerOngoingBody">${renderPartnerOngoingRows(projects.ongoing, 5)}</tbody>
                    </table></div>
                    ${detailLimitBtns('partnerOngoing')}`;
            }

            document.getElementById('detailTitle').innerText   = title;
            document.getElementById('detailContent').innerHTML = html;

            // Bind detail limit buttons after content is injected
            document.querySelectorAll('.detail-limit-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const section = this.dataset.section;
                    const limit   = this.dataset.limit;
                    document.querySelectorAll(`.detail-limit-btn[data-section="${section}"]`)
                        .forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const bodyMap = {
                        loginLog:          { el: 'loginLogBody',          fn: () => renderLoginRows(detailState.loginLogs, limit) },
                        techCompleted:     { el: 'techCompletedBody',     fn: () => renderTechCompletedRows(detailState.techCompleted, limit) },
                        techPending:       { el: 'techPendingBody',       fn: () => renderTechPendingRows(detailState.techPending, limit) },
                        attendanceHistory: { el: 'attendanceHistoryBody', fn: () => renderAttendanceRows(detailState.attendanceHistory, limit) },
                        partnerCompleted:  { el: 'partnerCompletedBody',  fn: () => renderPartnerCompletedRows(detailState.partnerCompleted, limit) },
                        partnerOngoing:    { el: 'partnerOngoingBody',    fn: () => renderPartnerOngoingRows(detailState.partnerOngoing, limit) },
                    };
                    if (bodyMap[section]) {
                        document.getElementById(bodyMap[section].el).innerHTML = bodyMap[section].fn();
                    }
                });
            });

            // Hide source modal then open detail modal
            const sourceEl = document.getElementById(sourceModalId);
            const detailEl = document.getElementById('detailModal');
            bootstrap.Modal.getInstance(sourceEl)?.hide();
            sourceEl.addEventListener('hidden.bs.modal', function handler() {
                new bootstrap.Modal(detailEl).show();
                sourceEl.removeEventListener('hidden.bs.modal', handler);
            });
        }

       
        // ── Print ─────────────────────────────────────────────────────────────────────
        function printModal(modalId, title) {
            const table = document.querySelector(`#${modalId} table`).outerHTML;
            openPrintWindow(title, table);
        }

        function printDetailTable() {
            const title   = document.getElementById('detailTitle').innerText;
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
                    <style>body{padding:24px;font-family:Arial,sans-serif;}h5{margin-bottom:16px;}@media print{body{padding:0;}@page{margin:15mm;}}</style>
                </head>
                <body>
                    <h5>${title}</h5>${content}
                    <script>window.onload=function(){window.print();window.close();}<\/script>
                </body></html>`);
            win.document.close();
        }

    </script>
@endsection