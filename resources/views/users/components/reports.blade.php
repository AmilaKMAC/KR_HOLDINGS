@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-grid gap-4 col-8 mx-auto">

            <button class="btn btn-dark p-4 report-btn" data-report="system" data-title="System Activity Log">
                System Activity Log
            </button>

            <button class="btn btn-secondary p-4 report-btn" data-report="user" data-title="User Activity Report">
                User Activity Report
            </button>

            <button class="btn btn-primary p-4 report-btn" data-report="technician"
                data-title="Technician Performance Report">
                Technician Performance
            </button>

            <button class="btn btn-success p-4 report-btn" data-report="project" data-title="Project Progress Summary">
                Project Progress
            </button>

            <button class="btn btn-warning p-4 report-btn" data-report="attendance" data-title="Attendance Summary">
                Attendance Summary
            </button>

            <button class="btn btn-info p-4 report-btn" data-report="partner" data-title="Partner Company Report">
                Partner Companies
            </button>

        </div>
    </div>


    <!-- ===================== MAIN REPORT MODAL ===================== -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="reportTitle"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm limit-btn active"
                                data-limit="5">5</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm limit-btn"
                                data-limit="10">10</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm limit-btn"
                                data-limit="20">20</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm limit-btn"
                                data-limit="all">All</button>
                        </div>
                        <div>
                            <button class="btn btn-outline-dark btn-sm me-1" onclick="printMainTable()">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- ===================== VIEW DETAIL MODAL ===================== -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailTitle">Detailed View</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="detailContent">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-dark btn-sm me-auto" onclick="printDetailTable()">Print</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <script>
        let currentReport = null;


        // ── Data from Laravel controller (passed via Blade) ──────────────────────────
        // In your controller, pass these variables:
        //   return view('reports', [
        //       'systemLogs'         => $systemLogs,         // collection/array
        //       'users'              => $users,
        //       'userLogs'           => $userLogs,            // keyed by user id
        //       'technicians'        => $technicians,
        //       'techProjects'       => $techProjects,        // keyed by tech id
        //       'projects'           => $projects,
        //       'attendance'         => $attendance,
        //       'attendanceHistory'  => $attendanceHistory,   // keyed by tech id
        //       'partners'           => $partners,
        //       'partnerProjects'    => $partnerProjects,     // keyed by partner id
        //   ]);

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

        // ── Report Config ─────────────────────────────────────────────────────────────
        const reportConfig = {
            system: {
                headers: ["ID", "Event", "Module", "Severity", "Status", "Triggered By", "Date"],
                view: false
            },
            user: {
                headers: ["User ID", "Name", "Role", "Email", "Status", "Created At"],
                view: true
            },
            technician: {
                headers: ["Tech ID", "Technician Name", "Total Projects", "Completed", "Pending"],
                view: true
            },
            project: {
                headers: ["Project ID", "Customer Name", "Location", "Capacity", "Status"],
                view: true
            },
            attendance: {
                headers: ["Emp ID", "Employee", "Present", "Absent", "Leave", "Month"],
                view: true
            },
            partner: {
                headers: ["Partner ID", "Company Name", "Total Projects", "Completed", "Ongoing"],
                view: true
            }
        };

        // ── Fetch rows ────────────────────────────────────────────────────────────────
        function fetchData(type, limit) {
            const lim = limit === 'all' ? 9999 : parseInt(limit);
            const pools = {
                system: () => data.system.slice(0, lim),
                user: () => data.user.slice(0, lim).map(u => [u.id, u.name, u.role, u.email, u.status, u.created]),
                technician: () => data.technician.slice(0, lim).map(t => [t.id, t.name, t.total, t.completed, t
                    .pending
                ]),
                project: () => data.project.slice(0, lim).map(p => [p.id, p.customer, p.location, p.capacity, p
                    .status
                ]),
                attendance: () => data.attendance.slice(0, lim).map(a => [a.id, a.name, a.present, a.absent, a.leave,
                    "February 2026"
                ]),
                partner: () => data.partner.slice(0, lim).map(p => [p.id, p.company, p.total, p.completed, p.ongoing]),
            };
            return pools[type] ? pools[type]() : [];
        }

        // ── Open main modal ───────────────────────────────────────────────────────────
        document.querySelectorAll('.report-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentReport = this.dataset.report;
                document.getElementById('reportTitle').innerText = this.dataset.title;
                // reset limit buttons to 5
                document.querySelectorAll('.limit-btn').forEach(b => b.classList.remove('active'));
                document.querySelector('.limit-btn[data-limit="5"]').classList.add('active');
                loadTable(5);
                new bootstrap.Modal(document.getElementById('reportModal')).show();
            });
        });

        document.querySelectorAll('.limit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.limit-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                loadTable(this.dataset.limit);
            });
        });

        // ── Load main table ───────────────────────────────────────────────────────────
        function loadTable(limit) {
            const head = document.getElementById('tableHead');
            const body = document.getElementById('tableBody');
            head.innerHTML = "";
            body.innerHTML = "";

            reportConfig[currentReport].headers.forEach(h => {
                head.innerHTML += `<th>${h}</th>`;
            });
            if (reportConfig[currentReport].view) {
                head.innerHTML += "<th>Action</th>";
            }

            const rows = fetchData(currentReport, limit);

            rows.forEach((r, idx) => {
                let rowHtml = "<tr>";
                r.forEach(c => {
                    rowHtml += `<td>${c}</td>`;
                });
                if (reportConfig[currentReport].view) {
                    rowHtml += `<td>
                <button class="btn btn-sm btn-outline-primary"
                        onclick="showDetail('${currentReport}', ${idx})">
                    View
                </button>
            </td>`;
                }
                rowHtml += "</tr>";
                body.innerHTML += rowHtml;
            });
        }



        // ── Detail limit state ────────────────────────────────────────────────────────
        let detailState = {};

        function detailLimitBtns(sectionId) {
            return `
    <div class="btn-group btn-group-sm mt-2 mb-1" role="group">
        <button type="button" class="btn btn-outline-secondary detail-limit-btn active"
                data-section="${sectionId}" data-limit="5">5</button>
        <button type="button" class="btn btn-outline-secondary detail-limit-btn"
                data-section="${sectionId}" data-limit="10">10</button>
        <button type="button" class="btn btn-outline-secondary detail-limit-btn"
                data-section="${sectionId}" data-limit="20">20</button>
        <button type="button" class="btn btn-outline-secondary detail-limit-btn"
                data-section="${sectionId}" data-limit="all">All</button>
    </div>`;
        }

        function sliceLimit(arr, limit) {
            return limit === 'all' ? arr : arr.slice(0, parseInt(limit));
        }

        function renderLoginRows(logs, limit) {
            const rows = sliceLimit(logs, limit);
            return rows.length > 0 ?
                rows.map((l, i) => `<tr>
            <td>${i+1}</td><td>${l.ip}</td><td>${l.device}</td>
            <td>${l.login}</td><td>${l.logout}</td>
          </tr>`).join('') :
                `<tr><td colspan="5" class="text-muted">No login records found.</td></tr>`;
        }

        function renderTechCompletedRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0 ?
                rows.map((p, i) => `<tr>
            <td>${i+1}</td><td>${p.id}</td>
            <td class="text-start">${p.name}</td><td>${p.date}</td>
          </tr>`).join('') :
                `<tr><td colspan="4" class="text-muted">No completed projects.</td></tr>`;
        }

        function renderTechPendingRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0 ?
                rows.map((p, i) => `<tr>
            <td>${i+1}</td><td>${p.id}</td>
            <td class="text-start">${p.name}</td><td>${p.dueDate}</td>
          </tr>`).join('') :
                `<tr><td colspan="4" class="text-success fw-semibold">No pending projects — all done!</td></tr>`;
        }

        function renderAttendanceRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0 ?
                rows.map((h, i) => `<tr>
            <td>${i+1}</td><td>${h.month}</td>
            <td class="text-success fw-bold">${h.present}</td>
            <td class="text-danger fw-bold">${h.absent}</td>
            <td class="text-warning fw-bold">${h.leave}</td>
          </tr>`).join('') :
                `<tr><td colspan="5" class="text-muted">No previous records found.</td></tr>`;
        }

        function renderPartnerCompletedRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0 ?
                rows.map((pr, i) => `<tr>
            <td>${i+1}</td><td>${pr.id}</td><td class="text-start">${pr.customer}</td>
            <td>${pr.location}</td><td>${pr.capacity}</td><td>${pr.date}</td>
          </tr>`).join('') :
                `<tr><td colspan="6" class="text-muted">No completed projects.</td></tr>`;
        }

        function renderPartnerOngoingRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0 ?
                rows.map((pr, i) => `<tr>
            <td>${i+1}</td><td>${pr.id}</td><td class="text-start">${pr.customer}</td>
            <td>${pr.location}</td><td>${pr.capacity}</td><td>${pr.startDate}</td>
          </tr>`).join('') :
                `<tr><td colspan="6" class="text-muted">No ongoing projects.</td></tr>`;
        }

        // ── Detail modal ──────────────────────────────────────────────────────────────
        function showDetail(type, idx) {
            let html = "";
            let title = "Detailed View";
            detailState = {};

            if (type === "user") {
                const u = data.user[idx];
                const logs = data.userLogs[u.id] || [];
                title = `Login History — ${u.name}`;
                detailState.loginLogs = logs;
                html = `
        <p class="mb-2 text-muted">
            <strong>User:</strong> ${u.name} &nbsp;|&nbsp;
            <strong>Role:</strong> ${u.role} &nbsp;|&nbsp;
            <strong>Email:</strong> ${u.email}
        </p>
        <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th><th>IP Address</th><th>Device / Browser</th>
                    <th>Login Date & Time</th><th>Logout Date & Time</th>
                </tr>
            </thead>
            <tbody id="loginLogBody">${renderLoginRows(logs, 5)}</tbody>
        </table>
        </div>
        ${detailLimitBtns('loginLog')}`;
            } else if (type === "technician") {
                const t = data.technician[idx];
                const projects = data.techProjects[t.id] || {
                    completed: [],
                    pending: []
                };
                title = `Projects — ${t.name}`;
                detailState.techCompleted = projects.completed;
                detailState.techPending = projects.pending;
                html = `
        <p class="mb-2 text-muted">
            <strong>Technician:</strong> ${t.name} &nbsp;|&nbsp;
            <strong>Total:</strong> ${t.total} &nbsp;|&nbsp;
            <strong>Completed:</strong> ${t.completed} &nbsp;|&nbsp;
            <strong>Pending:</strong> ${t.pending}
        </p>

        <h6 class="fw-bold text-success mt-3 mb-2">Completed Projects</h6>
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
            <thead class="table-success">
                <tr><th>#</th><th>Project ID</th><th>Project Name</th><th>Completed Date</th></tr>
            </thead>
            <tbody id="techCompletedBody">${renderTechCompletedRows(projects.completed, 5)}</tbody>
        </table>
        </div>
        ${detailLimitBtns('techCompleted')}

        <h6 class="fw-bold text-danger mt-4 mb-2">Pending Projects</h6>
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
            <thead class="table-danger">
                <tr><th>#</th><th>Project ID</th><th>Project Name</th><th>Due Date</th></tr>
            </thead>
            <tbody id="techPendingBody">${renderTechPendingRows(projects.pending, 5)}</tbody>
        </table>
        </div>
        ${detailLimitBtns('techPending')}`;
            } else if (type === "project") {
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
        </table>
        </div>`;
            } else if (type === "attendance") {
                const a = data.attendance[idx];
                const history = data.attendanceHistory[a.id] || [];
                title = `Attendance History — ${a.name}`;
                detailState.attendanceHistory = history;
                html = `
        <p class="mb-2 text-muted">
            <strong>Technician:</strong> ${a.name} &nbsp;|&nbsp;
            <strong>Current Month (Feb 2026):</strong>&nbsp;
            Present: <span class="text-success fw-bold">${a.present}</span> &nbsp;
            Absent: <span class="text-danger fw-bold">${a.absent}</span> &nbsp;
            Leave: <span class="text-warning fw-bold">${a.leave}</span>
        </p>
        <h6 class="fw-bold mb-2">Previous Monthly Attendance</h6>
        <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th><th>Month</th>
                    <th>Present Days</th><th>Absent Days</th><th>Leave Days</th>
                </tr>
            </thead>
            <tbody id="attendanceHistoryBody">${renderAttendanceRows(history, 5)}</tbody>
        </table>
        </div>
        ${detailLimitBtns('attendanceHistory')}`;
            } else if (type === "partner") {
                const p = data.partner[idx];
                const projects = data.partnerProjects[p.id] || {
                    completed: [],
                    ongoing: []
                };
                title = `Projects — ${p.company}`;
                detailState.partnerCompleted = projects.completed;
                detailState.partnerOngoing = projects.ongoing;
                html = `
        <p class="mb-2 text-muted">
            <strong>Partner:</strong> ${p.company} &nbsp;|&nbsp;
            <strong>Total:</strong> ${p.total} &nbsp;|&nbsp;
            <strong>Completed:</strong> ${p.completed} &nbsp;|&nbsp;
            <strong>Ongoing:</strong> ${p.ongoing}
        </p>

        <h6 class="fw-bold text-success mt-3 mb-2">Completed Projects</h6>
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
            <thead class="table-success">
                <tr><th>#</th><th>Project ID</th><th>Customer</th><th>Location</th><th>Capacity</th><th>Completed Date</th></tr>
            </thead>
            <tbody id="partnerCompletedBody">${renderPartnerCompletedRows(projects.completed, 5)}</tbody>
        </table>
        </div>
        ${detailLimitBtns('partnerCompleted')}

        <h6 class="fw-bold text-primary mt-4 mb-2">Ongoing Projects</h6>
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm text-center align-middle mb-0">
            <thead class="table-primary">
                <tr><th>#</th><th>Project ID</th><th>Customer</th><th>Location</th><th>Capacity</th><th>Start Date</th></tr>
            </thead>
            <tbody id="partnerOngoingBody">${renderPartnerOngoingRows(projects.ongoing, 5)}</tbody>
        </table>
        </div>
        ${detailLimitBtns('partnerOngoing')}`;
            }

            document.getElementById('detailTitle').innerText = title;
            document.getElementById('detailContent').innerHTML = html;

            // Bind detail limit buttons after content is injected
            document.querySelectorAll('.detail-limit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const section = this.dataset.section;
                    const limit = this.dataset.limit;

                    document.querySelectorAll(`.detail-limit-btn[data-section="${section}"]`)
                        .forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const bodyMap = {
                        loginLog: {
                            el: 'loginLogBody',
                            fn: () => renderLoginRows(detailState.loginLogs, limit)
                        },
                        techCompleted: {
                            el: 'techCompletedBody',
                            fn: () => renderTechCompletedRows(detailState.techCompleted, limit)
                        },
                        techPending: {
                            el: 'techPendingBody',
                            fn: () => renderTechPendingRows(detailState.techPending, limit)
                        },
                        attendanceHistory: {
                            el: 'attendanceHistoryBody',
                            fn: () => renderAttendanceRows(detailState.attendanceHistory, limit)
                        },
                        partnerCompleted: {
                            el: 'partnerCompletedBody',
                            fn: () => renderPartnerCompletedRows(detailState.partnerCompleted, limit)
                        },
                        partnerOngoing: {
                            el: 'partnerOngoingBody',
                            fn: () => renderPartnerOngoingRows(detailState.partnerOngoing, limit)
                        },
                    };

                    if (bodyMap[section]) {
                        document.getElementById(bodyMap[section].el).innerHTML = bodyMap[section].fn();
                    }
                });
            });

            const reportModalEl = document.getElementById('reportModal');
            const detailModalEl = document.getElementById('detailModal');

            bootstrap.Modal.getInstance(reportModalEl)?.hide();
            reportModalEl.addEventListener('hidden.bs.modal', function openDetail() {
                new bootstrap.Modal(detailModalEl).show();
                reportModalEl.removeEventListener('hidden.bs.modal', openDetail);
            });
        }

        function printMainTable() {
            const title = document.getElementById('reportTitle').innerText;
            const table = document.getElementById('mainReportTable').outerHTML;
            openPrintWindow(title, table);
        }

        function printDetailTable() {
            const title = document.getElementById('detailTitle').innerText;
            const content = document.getElementById('detailContent').innerHTML;
            openPrintWindow(title, content);
        }


    </script>
@endsection
