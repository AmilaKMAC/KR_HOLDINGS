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

    <!-- ============================ MODAL =============================== -->

    <!-- SYSTEM ACTIVITY LOG  -->
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
                                    <th>ID</th><th>Event</th><th>Module</th>
                                    <th>Severity</th><th>Status</th><th>Triggered By</th><th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="systemTableBody"></tbody>
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


    <!-- USER ACTIVITY REPORT  -->
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
                                    <th>User ID</th><th>Name</th><th>Role</th>
                                    <th>Email</th><th>Status</th><th>Created At</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody"></tbody>
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


    <!--  TECHNICIAN PERFORMANCE  -->
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
                                    <th>Tech ID</th><th>Technician Name</th><th>Total Projects</th>
                                    <th>Completed</th><th>Pending</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="technicianTableBody"></tbody>
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


    <!-- PROJECT PROGRESS  -->
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
                                    <th>Project ID</th><th>Customer Name</th><th>Location</th>
                                    <th>Capacity</th><th>Status</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="projectTableBody"></tbody>
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


    <!-- ATTENDANCE SUMMARY  -->
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
                                    <th>Emp ID</th><th>Employee</th><th>Present</th>
                                    <th>Absent</th><th>Leave</th><th>Month</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceTableBody"></tbody>
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


    <!-- PARTNER COMPANIES  -->
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
                                    <th>Partner ID</th><th>Company Name</th><th>Total Projects</th>
                                    <th>Completed</th><th>Ongoing</th><th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="partnerTableBody"></tbody>
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

        // ── Sample Data ───────────────────────────────────────────────────────────────
        const data = {

            system: [
                [1, "User Login", "Auth", "Info", "Success", "Kasun Perera", "2026-02-20"],
                [2, "Config Changed", "Config", "Medium", "Success", "Ayesha Hussain", "2026-02-20"],
                [3, "Backup Done", "Backup", "Low", "Success", "System", "2026-02-19"],
                [4, "Access Denied", "Access", "High", "Failed", "Unknown", "2026-02-19"],
                [5, "Report Generated", "Reports", "Info", "Success", "Nimali Fernando", "2026-02-18"],
                [6, "User Logout", "Auth", "Info", "Success", "Kasun Perera", "2026-02-18"],
                [7, "Alert Triggered", "Monitor", "High", "Warning", "System", "2026-02-17"],
                [8, "Module Updated", "Update", "Medium", "Success", "Ayesha Hussain", "2026-02-17"],
                [9, "Data Export", "Export", "Low", "Success", "Nimali Fernando", "2026-02-16"],
                [10, "System Restart", "Core", "Critical", "Resolved", "System", "2026-02-15"],
            ],

            user: [
                { id: 1,  name: "Kasun Perera",        role: "Admin",      email: "kasun@solar.lk",      status: "Active",    created: "2024-01-10" },
                { id: 2,  name: "Nimali Fernando",      role: "Manager",    email: "nimali@solar.lk",     status: "Active",    created: "2024-02-15" },
                { id: 3,  name: "Ruwan Jayasinghe",     role: "Technician", email: "ruwan@solar.lk",      status: "Active",    created: "2024-03-01" },
                { id: 4,  name: "Thilini Madushani",    role: "HR",         email: "thilini@solar.lk",    status: "Active",    created: "2024-04-20" },
                { id: 5,  name: "Chamara Silva",        role: "Technician", email: "chamara@solar.lk",    status: "Inactive",  created: "2024-05-12" },
                { id: 6,  name: "Sanduni Wickrama",     role: "Manager",    email: "sanduni@solar.lk",    status: "Active",    created: "2024-06-30" },
                { id: 7,  name: "Pradeep Kumara",       role: "Technician", email: "pradeep@solar.lk",    status: "Active",    created: "2024-07-15" },
                { id: 8,  name: "Ayesha Hussain",       role: "Admin",      email: "ayesha@solar.lk",     status: "Active",    created: "2024-08-01" },
                { id: 9,  name: "Lahiru Bandara",       role: "Technician", email: "lahiru@solar.lk",     status: "Suspended", created: "2024-09-10" },
                { id: 10, name: "Dilrukshi Rathnayake", role: "HR",         email: "dilrukshi@solar.lk",  status: "Active",    created: "2024-10-05" },
            ],

            userLogs: {
                1:  [{ ip: "192.168.1.10",  device: "Windows 11 / Chrome",  login: "2026-02-20 08:14", logout: "2026-02-20 17:32" }, { ip: "192.168.1.10",  device: "Windows 11 / Chrome",  login: "2026-02-19 08:05", logout: "2026-02-19 17:10" }, { ip: "192.168.1.10",  device: "Android / Chrome",     login: "2026-02-18 09:00", logout: "2026-02-18 16:50" }],
                2:  [{ ip: "192.168.1.22",  device: "MacOS / Safari",       login: "2026-02-20 08:55", logout: "2026-02-20 18:10" }, { ip: "192.168.1.22",  device: "MacOS / Safari",       login: "2026-02-19 09:10", logout: "2026-02-19 17:45" }],
                3:  [{ ip: "192.168.1.35",  device: "Android / Mobile",     login: "2026-02-20 07:30", logout: "2026-02-20 16:00" }, { ip: "192.168.1.35",  device: "Android / Mobile",     login: "2026-02-19 07:25", logout: "2026-02-19 15:55" }, { ip: "192.168.1.35",  device: "Windows 10 / Chrome",  login: "2026-02-18 07:40", logout: "2026-02-18 16:10" }],
                4:  [{ ip: "192.168.1.41",  device: "Windows 10 / Edge",    login: "2026-02-20 09:00", logout: "2026-02-20 17:00" }],
                5:  [{ ip: "192.168.1.55",  device: "iPhone / Safari",      login: "2026-02-18 10:00", logout: "2026-02-18 10:45" }],
                6:  [{ ip: "192.168.1.60",  device: "Windows 11 / Firefox", login: "2026-02-20 08:20", logout: "2026-02-20 17:50" }, { ip: "192.168.1.60",  device: "Windows 11 / Firefox", login: "2026-02-19 08:15", logout: "2026-02-19 17:30" }],
                7:  [{ ip: "192.168.1.72",  device: "Android / Chrome",     login: "2026-02-20 07:00", logout: "2026-02-20 15:30" }, { ip: "192.168.1.72",  device: "Android / Chrome",     login: "2026-02-19 06:55", logout: "2026-02-19 15:20" }, { ip: "192.168.1.72",  device: "Android / Chrome",     login: "2026-02-18 07:10", logout: "2026-02-18 15:40" }],
                8:  [{ ip: "192.168.1.80",  device: "Windows 11 / Chrome",  login: "2026-02-20 08:00", logout: "2026-02-20 18:30" }, { ip: "192.168.1.80",  device: "Windows 11 / Chrome",  login: "2026-02-19 08:00", logout: "2026-02-19 18:00" }],
                9:  [{ ip: "192.168.1.91",  device: "Windows 10 / Chrome",  login: "2026-02-15 09:00", logout: "2026-02-15 09:30" }],
                10: [{ ip: "192.168.1.100", device: "MacOS / Chrome",       login: "2026-02-20 08:45", logout: "2026-02-20 17:15" }, { ip: "192.168.1.100", device: "MacOS / Chrome",       login: "2026-02-19 08:50", logout: "2026-02-19 17:00" }],
            },

            technician: [
                { id: "T001", name: "Ruwan Jayasinghe",   total: 18, completed: 15, pending: 3 },
                { id: "T002", name: "Chamara Silva",       total: 12, completed: 12, pending: 0 },
                { id: "T003", name: "Pradeep Kumara",      total: 20, completed: 14, pending: 6 },
                { id: "T004", name: "Lahiru Bandara",      total: 8,  completed: 5,  pending: 3 },
                { id: "T005", name: "Saman Dissanayake",   total: 22, completed: 20, pending: 2 },
                { id: "T006", name: "Nimal Rajapaksha",    total: 15, completed: 10, pending: 5 },
                { id: "T007", name: "Ishara Perera",       total: 11, completed: 9,  pending: 2 },
                { id: "T008", name: "Buddhika Fernando",   total: 17, completed: 13, pending: 4 },
                { id: "T009", name: "Nuwan Bandara",       total: 9,  completed: 7,  pending: 2 },
                { id: "T010", name: "Hasitha Madusanka",   total: 14, completed: 11, pending: 3 },
            ],

            techProjects: {
                "T001": { completed: [{ id:"PRJ001", name:"Grid Setup – Negombo", date:"2025-10-28" },{ id:"PRJ003", name:"Panel Mount – Ratnapura", date:"2025-11-15" },{ id:"PRJ005", name:"Wiring – Kurunegala", date:"2025-12-01" },{ id:"PRJ007", name:"Battery Bank – Anuradhapura", date:"2026-01-10" },{ id:"PRJ009", name:"Commissioning – Matara", date:"2026-01-28" }], pending: [{ id:"PRJ012", name:"Solar Install – Colombo South", dueDate:"2026-03-15" },{ id:"PRJ015", name:"Hybrid System – Kandy", dueDate:"2026-03-30" },{ id:"PRJ018", name:"Inverter Replacement – Galle", dueDate:"2026-04-10" }] },
                "T002": { completed: [{ id:"PRJ002", name:"Panel Install – Jaffna", date:"2025-09-20" },{ id:"PRJ004", name:"Grid Tie – Vavuniya", date:"2025-10-10" },{ id:"PRJ006", name:"Inverter – Trincomalee", date:"2025-11-05" },{ id:"PRJ008", name:"Solar Farm – Batticaloa", date:"2025-12-20" },{ id:"PRJ010", name:"Wiring – Ampara", date:"2026-01-18" }], pending: [] },
                "T003": { completed: [{ id:"PRJ011", name:"Install – Kegalle", date:"2025-10-05" },{ id:"PRJ013", name:"Commissioning – Hambantota", date:"2025-11-22" },{ id:"PRJ016", name:"Wiring – Kalutara", date:"2025-12-14" },{ id:"PRJ019", name:"Panel – Gampaha", date:"2026-01-30" }], pending: [{ id:"PRJ020", name:"Roof Mount – Nuwara Eliya", dueDate:"2026-03-05" },{ id:"PRJ022", name:"Battery – Badulla", dueDate:"2026-03-20" },{ id:"PRJ024", name:"PV Array – Monaragala", dueDate:"2026-04-01" },{ id:"PRJ026", name:"Grid Upgrade – Polonnaruwa", dueDate:"2026-04-15" },{ id:"PRJ028", name:"Cabling – Puttalam", dueDate:"2026-04-25" },{ id:"PRJ030", name:"Testing – Mannar", dueDate:"2026-05-01" }] },
                "T004": { completed: [{ id:"PRJ014", name:"Install – Kurunegala", date:"2025-11-10" },{ id:"PRJ017", name:"Panel – Kandy", date:"2025-12-08" },{ id:"PRJ021", name:"Grid – Peradeniya", date:"2026-01-05" },{ id:"PRJ023", name:"Solar – Matale", date:"2026-01-25" },{ id:"PRJ025", name:"Wiring – Dambulla", date:"2026-02-10" }], pending: [{ id:"PRJ031", name:"Solar Kit – Matale Ph.2", dueDate:"2026-03-10" },{ id:"PRJ033", name:"Upgrade – Dambulla", dueDate:"2026-03-25" },{ id:"PRJ035", name:"Inspection – Sigiriya", dueDate:"2026-04-05" }] },
                "T005": { completed: [{ id:"PRJ027", name:"Install – Nugegoda", date:"2025-09-15" },{ id:"PRJ029", name:"Grid – Maharagama", date:"2025-10-20" },{ id:"PRJ032", name:"Panel – Boralesgamuwa", date:"2025-11-28" },{ id:"PRJ034", name:"Wiring – Kottawa", date:"2026-01-12" },{ id:"PRJ036", name:"Commission – Piliyandala", date:"2026-02-05" }], pending: [{ id:"PRJ038", name:"Extension – Dehiwala", dueDate:"2026-03-15" },{ id:"PRJ040", name:"Final Test – Moratuwa", dueDate:"2026-04-01" }] },
                "T006": { completed: [{ id:"PRJ037", name:"Install – Tangalle", date:"2025-10-01" },{ id:"PRJ039", name:"Grid – Hambantota", date:"2025-11-14" },{ id:"PRJ041", name:"Panel – Tissamaharama", date:"2025-12-20" },{ id:"PRJ043", name:"Solar – Kataragama", date:"2026-01-08" }], pending: [{ id:"PRJ042", name:"Mount – Embilipitiya", dueDate:"2026-03-10" },{ id:"PRJ044", name:"Cabling – Ratnapura", dueDate:"2026-03-25" },{ id:"PRJ046", name:"Test – Balangoda", dueDate:"2026-04-05" },{ id:"PRJ048", name:"Setup – Belihuloya", dueDate:"2026-04-20" },{ id:"PRJ050", name:"Inspect – Haputale", dueDate:"2026-05-01" }] },
                "T007": { completed: [{ id:"PRJ045", name:"Grid – Avissawella", date:"2025-11-05" },{ id:"PRJ047", name:"Panel – Horana", date:"2025-12-10" },{ id:"PRJ049", name:"Install – Panadura", date:"2026-01-15" },{ id:"PRJ051", name:"Solar – Kalutara", date:"2026-02-01" }], pending: [{ id:"PRJ052", name:"Wiring – Beruwala", dueDate:"2026-03-20" },{ id:"PRJ054", name:"Inverter – Aluthgama", dueDate:"2026-04-05" }] },
                "T008": { completed: [{ id:"PRJ053", name:"Install – Gampola", date:"2025-10-15" },{ id:"PRJ055", name:"Grid – Nawalapitiya", date:"2025-11-25" },{ id:"PRJ057", name:"Panel – Hatton", date:"2026-01-08" },{ id:"PRJ059", name:"Solar – Talawakele", date:"2026-01-30" }], pending: [{ id:"PRJ056", name:"Mount – Maskeliya", dueDate:"2026-03-15" },{ id:"PRJ058", name:"Cabling – Norwood", dueDate:"2026-03-30" },{ id:"PRJ060", name:"Test – Bogawantalawa", dueDate:"2026-04-15" },{ id:"PRJ062", name:"Inspect – Belihul Oya", dueDate:"2026-05-01" }] },
                "T009": { completed: [{ id:"PRJ061", name:"Grid – Chilaw", date:"2025-12-05" },{ id:"PRJ063", name:"Panel – Marawila", date:"2026-01-18" },{ id:"PRJ065", name:"Install – Wennappuwa", date:"2026-02-08" }], pending: [{ id:"PRJ064", name:"Solar – Negombo Ext.", dueDate:"2026-03-25" },{ id:"PRJ066", name:"Wiring – Katunayake", dueDate:"2026-04-10" }] },
                "T010": { completed: [{ id:"PRJ067", name:"Install – Kadawatha", date:"2025-11-20" },{ id:"PRJ069", name:"Grid – Kelaniya", date:"2025-12-15" },{ id:"PRJ071", name:"Panel – Biyagama", date:"2026-01-22" },{ id:"PRJ073", name:"Solar – Dompe", date:"2026-02-12" }], pending: [{ id:"PRJ068", name:"Mount – Ja-Ela", dueDate:"2026-03-10" },{ id:"PRJ070", name:"Cabling – Wattala", dueDate:"2026-03-28" },{ id:"PRJ072", name:"Inspect – Peliyagoda", dueDate:"2026-04-12" }] },
            },

            project: [
                { id:"PRJ001", customer:"Nalaka Enterprises",    location:"Colombo",      capacity:"10 kW", status:"Completed", start:"2025-10-01", end:"2025-10-28", tech:"Ruwan Jayasinghe",  partner:"SolarTech Solutions", addWork:"Roof Reinforcement" },
                { id:"PRJ002", customer:"Green Farm Ltd",        location:"Kandy",        capacity:"25 kW", status:"Ongoing",   start:"2026-01-15", end:"2026-03-10", tech:"Chamara Silva",     partner:"EcoPower Lanka",      addWork:"Tree Trimming" },
                { id:"PRJ003", customer:"Sunil Residence",       location:"Galle",        capacity:"5 kW",  status:"Ongoing",   start:"2026-02-01", end:"2026-03-01", tech:"Ruwan Jayasinghe",  partner:"SunRay Pvt Ltd",      addWork:"None" },
                { id:"PRJ004", customer:"Mega Mart",             location:"Negombo",      capacity:"50 kW", status:"Pending",   start:"2026-03-01", end:"2026-05-30", tech:"Pradeep Kumara",    partner:"SolarTech Solutions", addWork:"Structural Survey" },
                { id:"PRJ005", customer:"Blue Horizon Hotel",    location:"Bentota",      capacity:"75 kW", status:"Ongoing",   start:"2026-01-05", end:"2026-04-20", tech:"Saman Dissanayake", partner:"Volta Energy",        addWork:"Generator Integration" },
                { id:"PRJ006", customer:"Sunrise School",        location:"Kurunegala",   capacity:"15 kW", status:"Completed", start:"2025-09-10", end:"2025-11-05", tech:"Lahiru Bandara",    partner:"EcoPower Lanka",      addWork:"Panel Cleaning System" },
                { id:"PRJ007", customer:"Lanka Ceramics",        location:"Ratnapura",    capacity:"30 kW", status:"Completed", start:"2025-08-01", end:"2025-10-15", tech:"Nimal Rajapaksha",  partner:"SunRay Pvt Ltd",      addWork:"None" },
                { id:"PRJ008", customer:"Ocean View Apartments", location:"Dehiwala",     capacity:"20 kW", status:"Pending",   start:"2026-04-01", end:"2026-06-30", tech:"Saman Dissanayake", partner:"Volta Energy",        addWork:"Roof Assessment" },
                { id:"PRJ009", customer:"Star Garments",         location:"Nuwara Eliya", capacity:"40 kW", status:"Ongoing",   start:"2026-02-10", end:"2026-04-15", tech:"Ruwan Jayasinghe",  partner:"SolarTech Solutions", addWork:"Weatherproofing" },
                { id:"PRJ010", customer:"Dambulla Depot",        location:"Dambulla",     capacity:"12 kW", status:"Completed", start:"2025-07-01", end:"2025-08-20", tech:"Chamara Silva",     partner:"EcoPower Lanka",      addWork:"None" },
            ],

            attendance: [
                { id:"T001", name:"Ruwan Jayasinghe",   present:20, absent:1, leave:1 },
                { id:"T002", name:"Chamara Silva",       present:22, absent:0, leave:0 },
                { id:"T003", name:"Pradeep Kumara",      present:18, absent:2, leave:2 },
                { id:"T004", name:"Lahiru Bandara",      present:17, absent:3, leave:2 },
                { id:"T005", name:"Saman Dissanayake",   present:21, absent:1, leave:0 },
                { id:"T006", name:"Nimal Rajapaksha",    present:19, absent:2, leave:1 },
                { id:"T007", name:"Ishara Perera",       present:22, absent:0, leave:0 },
                { id:"T008", name:"Buddhika Fernando",   present:16, absent:4, leave:2 },
                { id:"T009", name:"Nuwan Bandara",       present:20, absent:1, leave:1 },
                { id:"T010", name:"Hasitha Madusanka",   present:18, absent:2, leave:2 },
            ],

            attendanceHistory: {
                "T001": [{ month:"January 2026", present:21, absent:1, leave:1 },{ month:"December 2025", present:20, absent:2, leave:1 },{ month:"November 2025", present:22, absent:0, leave:0 },{ month:"October 2025", present:19, absent:2, leave:2 }],
                "T002": [{ month:"January 2026", present:23, absent:0, leave:0 },{ month:"December 2025", present:22, absent:1, leave:0 },{ month:"November 2025", present:22, absent:0, leave:0 },{ month:"October 2025", present:21, absent:1, leave:1 }],
                "T003": [{ month:"January 2026", present:18, absent:3, leave:2 },{ month:"December 2025", present:17, absent:4, leave:2 },{ month:"November 2025", present:19, absent:2, leave:1 },{ month:"October 2025", present:20, absent:1, leave:2 }],
                "T004": [{ month:"January 2026", present:16, absent:4, leave:3 },{ month:"December 2025", present:18, absent:3, leave:2 },{ month:"November 2025", present:19, absent:2, leave:1 },{ month:"October 2025", present:20, absent:2, leave:1 }],
                "T005": [{ month:"January 2026", present:22, absent:1, leave:0 },{ month:"December 2025", present:21, absent:1, leave:1 },{ month:"November 2025", present:22, absent:0, leave:0 },{ month:"October 2025", present:21, absent:2, leave:0 }],
                "T006": [{ month:"January 2026", present:19, absent:3, leave:1 },{ month:"December 2025", present:20, absent:2, leave:1 },{ month:"November 2025", present:21, absent:1, leave:0 },{ month:"October 2025", present:18, absent:3, leave:2 }],
                "T007": [{ month:"January 2026", present:22, absent:1, leave:0 },{ month:"December 2025", present:23, absent:0, leave:0 },{ month:"November 2025", present:21, absent:1, leave:0 },{ month:"October 2025", present:22, absent:0, leave:1 }],
                "T008": [{ month:"January 2026", present:15, absent:5, leave:3 },{ month:"December 2025", present:17, absent:4, leave:2 },{ month:"November 2025", present:18, absent:3, leave:1 },{ month:"October 2025", present:19, absent:3, leave:1 }],
                "T009": [{ month:"January 2026", present:20, absent:2, leave:1 },{ month:"December 2025", present:21, absent:1, leave:1 },{ month:"November 2025", present:22, absent:0, leave:0 },{ month:"October 2025", present:20, absent:2, leave:1 }],
                "T010": [{ month:"January 2026", present:18, absent:3, leave:2 },{ month:"December 2025", present:19, absent:2, leave:2 },{ month:"November 2025", present:20, absent:2, leave:0 },{ month:"October 2025", present:21, absent:2, leave:0 }],
            },

            partner: [
                { id:"P001", company:"SolarTech Solutions",    total:15, completed:10, ongoing:5 },
                { id:"P002", company:"EcoPower Lanka",         total:12, completed:8,  ongoing:4 },
                { id:"P003", company:"SunRay Pvt Ltd",         total:9,  completed:7,  ongoing:2 },
                { id:"P004", company:"Volta Energy",           total:11, completed:6,  ongoing:5 },
                { id:"P005", company:"Island Solar Co.",       total:7,  completed:5,  ongoing:2 },
                { id:"P006", company:"GreenWatt Technologies", total:8,  completed:4,  ongoing:4 },
                { id:"P007", company:"BrightSun Lanka",        total:10, completed:8,  ongoing:2 },
                { id:"P008", company:"PowerGrid Associates",   total:6,  completed:3,  ongoing:3 },
                { id:"P009", company:"Apex Renewables",        total:14, completed:11, ongoing:3 },
                { id:"P010", company:"Helios Energy Pvt Ltd",  total:9,  completed:6,  ongoing:3 },
            ],

            partnerProjects: {
                "P001": { completed:[{ id:"PRJ001", customer:"Nalaka Enterprises", location:"Colombo", capacity:"10 kW", date:"2025-10-28" },{ id:"PRJ006", customer:"Sunrise School", location:"Kurunegala", capacity:"15 kW", date:"2025-11-05" },{ id:"PRJ009", customer:"Star Garments Ph.1", location:"Nuwara Eliya", capacity:"40 kW", date:"2025-12-01" },{ id:"PRJ011", customer:"Tech Hub Alpha", location:"Colombo 3", capacity:"20 kW", date:"2026-01-15" },{ id:"PRJ013", customer:"Nova Homes", location:"Nugegoda", capacity:"8 kW", date:"2026-02-10" }], ongoing:[{ id:"PRJ004", customer:"Mega Mart", location:"Negombo", capacity:"50 kW", startDate:"2026-03-01" },{ id:"PRJ009", customer:"Star Garments Ph.2", location:"Nuwara Eliya", capacity:"40 kW", startDate:"2026-02-10" },{ id:"PRJ015", customer:"Hilton Hotel", location:"Colombo", capacity:"100 kW", startDate:"2026-02-20" },{ id:"PRJ017", customer:"Metro Park", location:"Battaramulla", capacity:"25 kW", startDate:"2026-03-05" },{ id:"PRJ019", customer:"City Plaza", location:"Kaduwela", capacity:"30 kW", startDate:"2026-03-10" }] },
                "P002": { completed:[{ id:"PRJ006", customer:"Sunrise School", location:"Kurunegala", capacity:"15 kW", date:"2025-11-05" },{ id:"PRJ010", customer:"Dambulla Depot", location:"Dambulla", capacity:"12 kW", date:"2025-08-20" },{ id:"PRJ012", customer:"Blue Wave", location:"Gampaha", capacity:"18 kW", date:"2025-09-30" },{ id:"PRJ014", customer:"Amber Court", location:"Kadawatha", capacity:"10 kW", date:"2025-12-10" }], ongoing:[{ id:"PRJ002", customer:"Green Farm Ltd", location:"Kandy", capacity:"25 kW", startDate:"2026-01-15" },{ id:"PRJ016", customer:"Sunrise Farms", location:"Matale", capacity:"35 kW", startDate:"2026-02-01" },{ id:"PRJ018", customer:"Eco Tower", location:"Rajagiriya", capacity:"60 kW", startDate:"2026-02-15" },{ id:"PRJ020", customer:"Blue Horizon", location:"Dehiwala", capacity:"20 kW", startDate:"2026-03-01" }] },
                "P003": { completed:[{ id:"PRJ001", customer:"Sunil Residence", location:"Galle", capacity:"5 kW", date:"2026-02-28" },{ id:"PRJ007", customer:"Lanka Ceramics", location:"Ratnapura", capacity:"30 kW", date:"2025-10-15" },{ id:"PRJ021", customer:"Horizon Mall", location:"Kalutara", capacity:"45 kW", date:"2025-11-30" },{ id:"PRJ023", customer:"Pine Lodge", location:"Ella", capacity:"8 kW", date:"2025-12-25" },{ id:"PRJ025", customer:"Maple Court", location:"Bandarawela", capacity:"10 kW", date:"2026-01-20" },{ id:"PRJ027", customer:"Cedar Villa", location:"Badulla", capacity:"6 kW", date:"2026-02-05" },{ id:"PRJ029", customer:"Ridge Park", location:"Haputale", capacity:"12 kW", date:"2026-02-18" }], ongoing:[{ id:"PRJ003", customer:"Sunil Residence Ph.2", location:"Galle", capacity:"5 kW", startDate:"2026-03-01" },{ id:"PRJ031", customer:"Amber Residencies", location:"Kandy", capacity:"15 kW", startDate:"2026-03-10" }] },
                "P004": { completed:[{ id:"PRJ005", customer:"Blue Horizon Hotel Ph.1", location:"Bentota", capacity:"75 kW", date:"2025-12-31" },{ id:"PRJ033", customer:"Ocean View", location:"Dehiwala", capacity:"20 kW", date:"2025-11-10" },{ id:"PRJ035", customer:"Sunset Villas", location:"Wadduwa", capacity:"15 kW", date:"2025-10-05" },{ id:"PRJ037", customer:"Coral Reef", location:"Hikkaduwa", capacity:"12 kW", date:"2025-09-20" },{ id:"PRJ039", customer:"Marina Bay", location:"Beruwala", capacity:"18 kW", date:"2026-01-08" },{ id:"PRJ041", customer:"Island Breeze", location:"Bentota", capacity:"10 kW", date:"2026-02-01" }], ongoing:[{ id:"PRJ005", customer:"Blue Horizon Hotel Ph.2", location:"Bentota", capacity:"75 kW", startDate:"2026-01-05" },{ id:"PRJ008", customer:"Ocean View Apartments", location:"Dehiwala", capacity:"20 kW", startDate:"2026-04-01" },{ id:"PRJ043", customer:"Wave Park", location:"Moratuwa", capacity:"30 kW", startDate:"2026-02-20" },{ id:"PRJ045", customer:"Sea Breeze", location:"Panadura", capacity:"25 kW", startDate:"2026-03-05" },{ id:"PRJ047", customer:"Harbor View", location:"Galle", capacity:"40 kW", startDate:"2026-03-15" }] },
                "P005": { completed:[{ id:"PRJ051", customer:"Palm Beach", location:"Kalutara", capacity:"8 kW", date:"2025-10-01" },{ id:"PRJ053", customer:"Coconut Grove", location:"Bentota", capacity:"5 kW", date:"2025-11-15" },{ id:"PRJ055", customer:"Tropic Sun", location:"Ambalangoda", capacity:"10 kW", date:"2025-12-20" },{ id:"PRJ057", customer:"Mango Farm", location:"Elpitiya", capacity:"12 kW", date:"2026-01-10" },{ id:"PRJ059", customer:"Banana Plantation", location:"Baddegama", capacity:"15 kW", date:"2026-02-15" }], ongoing:[{ id:"PRJ061", customer:"Spice Garden", location:"Matara", capacity:"20 kW", startDate:"2026-03-01" },{ id:"PRJ063", customer:"Tea Estate", location:"Deniyaya", capacity:"25 kW", startDate:"2026-03-15" }] },
                "P006": { completed:[{ id:"PRJ065", customer:"Tech Hub Alpha", location:"Colombo 3", capacity:"20 kW", date:"2025-11-01" },{ id:"PRJ067", customer:"Digital Park", location:"Malabe", capacity:"35 kW", date:"2025-12-10" },{ id:"PRJ069", customer:"Innovate Center", location:"Rajagiriya", capacity:"25 kW", date:"2026-01-20" },{ id:"PRJ071", customer:"Smart Office", location:"Battaramulla", capacity:"15 kW", date:"2026-02-10" }], ongoing:[{ id:"PRJ073", customer:"Cyber Valley", location:"Malabe", capacity:"50 kW", startDate:"2026-02-20" },{ id:"PRJ075", customer:"Data Farm", location:"Homagama", capacity:"60 kW", startDate:"2026-03-01" },{ id:"PRJ077", customer:"Cloud Campus", location:"Kaduwela", capacity:"40 kW", startDate:"2026-03-10" },{ id:"PRJ079", customer:"AI Center", location:"Sri Jayawardenepura", capacity:"30 kW", startDate:"2026-03-20" }] },
                "P007": { completed:[{ id:"PRJ081", customer:"Bright Homes", location:"Nugegoda", capacity:"8 kW", date:"2025-10-15" },{ id:"PRJ083", customer:"Star Villas", location:"Maharagama", capacity:"10 kW", date:"2025-11-30" },{ id:"PRJ085", customer:"Sun Garden", location:"Piliyandala", capacity:"12 kW", date:"2025-12-25" },{ id:"PRJ087", customer:"Glow Residencies", location:"Kottawa", capacity:"15 kW", date:"2026-01-20" },{ id:"PRJ089", customer:"Shine Towers", location:"Boralesgamuwa", capacity:"20 kW", date:"2026-02-12" },{ id:"PRJ091", customer:"Ray Apartments", location:"Dehiwala", capacity:"18 kW", date:"2026-02-20" },{ id:"PRJ093", customer:"Lux Court", location:"Ratmalana", capacity:"14 kW", date:"2026-02-25" },{ id:"PRJ095", customer:"Prime Estate", location:"Moratuwa", capacity:"22 kW", date:"2026-02-27" }], ongoing:[{ id:"PRJ097", customer:"Elite Park", location:"Panadura", capacity:"25 kW", startDate:"2026-03-01" },{ id:"PRJ099", customer:"Grand View", location:"Kalutara", capacity:"30 kW", startDate:"2026-03-15" }] },
                "P008": { completed:[{ id:"PRJ101", customer:"Green Build", location:"Gampaha", capacity:"18 kW", date:"2025-12-01" },{ id:"PRJ103", customer:"Eco Home", location:"Negombo", capacity:"10 kW", date:"2026-01-15" },{ id:"PRJ105", customer:"Nature Villa", location:"Chilaw", capacity:"12 kW", date:"2026-02-20" }], ongoing:[{ id:"PRJ107", customer:"Blue Lagoon", location:"Marawila", capacity:"15 kW", startDate:"2026-03-01" },{ id:"PRJ109", customer:"Palm Resort", location:"Wennappuwa", capacity:"20 kW", startDate:"2026-03-10" },{ id:"PRJ111", customer:"Sunrise Villas", location:"Katunayake", capacity:"25 kW", startDate:"2026-03-20" }] },
                "P009": { completed:[{ id:"PRJ113", customer:"Apex Tower", location:"Colombo 7", capacity:"50 kW", date:"2025-09-10" },{ id:"PRJ115", customer:"Crown Plaza", location:"Colombo 3", capacity:"40 kW", date:"2025-10-20" },{ id:"PRJ117", customer:"Metro Hub", location:"Maradana", capacity:"30 kW", date:"2025-11-15" },{ id:"PRJ119", customer:"City Square", location:"Pettah", capacity:"35 kW", date:"2025-12-05" },{ id:"PRJ121", customer:"Urban Park", location:"Wellawatte", capacity:"20 kW", date:"2026-01-10" },{ id:"PRJ123", customer:"The Boulevard", location:"Bambalapitiya", capacity:"25 kW", date:"2026-01-28" },{ id:"PRJ125", customer:"Grand Central", location:"Borella", capacity:"45 kW", date:"2026-02-10" },{ id:"PRJ127", customer:"Diamond Square", location:"Rajagiriya", capacity:"28 kW", date:"2026-02-20" },{ id:"PRJ129", customer:"Pearl Towers", location:"Battaramulla", capacity:"32 kW", date:"2026-02-25" },{ id:"PRJ131", customer:"Sapphire Mall", location:"Malabe", capacity:"55 kW", date:"2026-02-27" },{ id:"PRJ133", customer:"Ruby Residencies", location:"Sri Jayawardenepura", capacity:"18 kW", date:"2026-02-28" }], ongoing:[{ id:"PRJ135", customer:"Emerald City", location:"Kaduwela", capacity:"60 kW", startDate:"2026-03-01" },{ id:"PRJ137", customer:"Topaz Plaza", location:"Athurugiriya", capacity:"35 kW", startDate:"2026-03-15" },{ id:"PRJ139", customer:"Quartz Tower", location:"Homagama", capacity:"40 kW", startDate:"2026-03-25" }] },
                "P010": { completed:[{ id:"PRJ141", customer:"Helios Mall", location:"Kandy", capacity:"45 kW", date:"2025-10-01" },{ id:"PRJ143", customer:"Sun Plaza", location:"Peradeniya", capacity:"30 kW", date:"2025-11-20" },{ id:"PRJ145", customer:"Star Center", location:"Gampola", capacity:"20 kW", date:"2025-12-15" },{ id:"PRJ147", customer:"Moon Villas", location:"Nawalapitiya", capacity:"15 kW", date:"2026-01-25" },{ id:"PRJ149", customer:"Cloud Nine", location:"Hatton", capacity:"12 kW", date:"2026-02-15" },{ id:"PRJ151", customer:"Zenith Park", location:"Talawakele", capacity:"18 kW", date:"2026-02-25" }], ongoing:[{ id:"PRJ153", customer:"Apex Residencies", location:"Nuwara Eliya", capacity:"22 kW", startDate:"2026-03-05" },{ id:"PRJ155", customer:"Summit View", location:"Bandarawela", capacity:"28 kW", startDate:"2026-03-20" },{ id:"PRJ157", customer:"Peak Estate", location:"Ella", capacity:"16 kW", startDate:"2026-04-01" }] },
            },
        };

        // ── Populate each modal table on first open ───────────────────────────────────
        document.getElementById('systemModal').addEventListener('show.bs.modal', function () {
            const body = document.getElementById('systemTableBody');
            if (body.innerHTML.trim()) return;
            body.innerHTML = data.system.map(r =>
                `<tr>${r.map(c => `<td>${c}</td>`).join('')}</tr>`
            ).join('');
        });

        document.getElementById('userModal').addEventListener('show.bs.modal', function () {
            const body = document.getElementById('userTableBody');
            if (body.innerHTML.trim()) return;
            body.innerHTML = data.user.map((u, idx) =>
                `<tr>
                    <td>${u.id}</td><td>${u.name}</td><td>${u.role}</td>
                    <td>${u.email}</td><td>${u.status}</td><td>${u.created}</td>
                    <td><button class="btn btn-sm btn-outline-primary" onclick="showDetail('user',${idx},'userModal')">View</button></td>
                </tr>`
            ).join('');
        });

        document.getElementById('technicianModal').addEventListener('show.bs.modal', function () {
            const body = document.getElementById('technicianTableBody');
            if (body.innerHTML.trim()) return;
            body.innerHTML = data.technician.map((t, idx) =>
                `<tr>
                    <td>${t.id}</td><td>${t.name}</td><td>${t.total}</td>
                    <td>${t.completed}</td><td>${t.pending}</td>
                    <td><button class="btn btn-sm btn-outline-primary" onclick="showDetail('technician',${idx},'technicianModal')">View</button></td>
                </tr>`
            ).join('');
        });

        document.getElementById('projectModal').addEventListener('show.bs.modal', function () {
            const body = document.getElementById('projectTableBody');
            if (body.innerHTML.trim()) return;
            body.innerHTML = data.project.map((p, idx) =>
                `<tr>
                    <td>${p.id}</td><td>${p.customer}</td><td>${p.location}</td>
                    <td>${p.capacity}</td><td>${p.status}</td>
                    <td><button class="btn btn-sm btn-outline-primary" onclick="showDetail('project',${idx},'projectModal')">View</button></td>
                </tr>`
            ).join('');
        });

        document.getElementById('attendanceModal').addEventListener('show.bs.modal', function () {
            const body = document.getElementById('attendanceTableBody');
            if (body.innerHTML.trim()) return;
            body.innerHTML = data.attendance.map((a, idx) =>
                `<tr>
                    <td>${a.id}</td><td>${a.name}</td><td>${a.present}</td>
                    <td>${a.absent}</td><td>${a.leave}</td><td>February 2026</td>
                    <td><button class="btn btn-sm btn-outline-primary" onclick="showDetail('attendance',${idx},'attendanceModal')">View</button></td>
                </tr>`
            ).join('');
        });

        document.getElementById('partnerModal').addEventListener('show.bs.modal', function () {
            const body = document.getElementById('partnerTableBody');
            if (body.innerHTML.trim()) return;
            body.innerHTML = data.partner.map((p, idx) =>
                `<tr>
                    <td>${p.id}</td><td>${p.company}</td><td>${p.total}</td>
                    <td>${p.completed}</td><td>${p.ongoing}</td>
                    <td><button class="btn btn-sm btn-outline-primary" onclick="showDetail('partner',${idx},'partnerModal')">View</button></td>
                </tr>`
            ).join('');
        });


        // ── Detail modal ──────────────────────────────────────────────────────────────
        let detailState   = {};
        let sourceModalId = null;

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
                    <p class="mb-2 text-muted">
                        <strong>User:</strong> ${u.name} &nbsp;|&nbsp;
                        <strong>Role:</strong> ${u.role} &nbsp;|&nbsp;
                        <strong>Email:</strong> ${u.email}
                    </p>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="table-dark">
                            <tr><th>#</th><th>IP Address</th><th>Device / Browser</th><th>Login Date & Time</th><th>Logout Date & Time</th></tr>
                        </thead>
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
                    <p class="mb-2 text-muted">
                        <strong>Technician:</strong> ${t.name} &nbsp;|&nbsp;
                        <strong>Total:</strong> ${t.total} &nbsp;|&nbsp;
                        <strong>Completed:</strong> ${t.completed} &nbsp;|&nbsp;
                        <strong>Pending:</strong> ${t.pending}
                    </p>
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
                            <tr><th>#</th><th>Month</th><th>Present Days</th><th>Absent Days</th><th>Leave Days</th></tr>
                        </thead>
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
                    <p class="mb-2 text-muted">
                        <strong>Partner:</strong> ${p.company} &nbsp;|&nbsp;
                        <strong>Total:</strong> ${p.total} &nbsp;|&nbsp;
                        <strong>Completed:</strong> ${p.completed} &nbsp;|&nbsp;
                        <strong>Ongoing:</strong> ${p.ongoing}
                    </p>
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

        // ── Render helpers ────────────────────────────────────────────────────────────
        function detailLimitBtns(sectionId) {
            return `
            <div class="btn-group btn-group-sm mt-2 mb-1" role="group">
                <button type="button" class="btn btn-outline-secondary detail-limit-btn active" data-section="${sectionId}" data-limit="5">5</button>
                <button type="button" class="btn btn-outline-secondary detail-limit-btn" data-section="${sectionId}" data-limit="10">10</button>
                <button type="button" class="btn btn-outline-secondary detail-limit-btn" data-section="${sectionId}" data-limit="20">20</button>
                <button type="button" class="btn btn-outline-secondary detail-limit-btn" data-section="${sectionId}" data-limit="all">All</button>
            </div>`;
        }

        function sliceLimit(arr, limit) {
            return limit === 'all' ? arr : arr.slice(0, parseInt(limit));
        }

        function renderLoginRows(logs, limit) {
            const rows = sliceLimit(logs, limit);
            return rows.length > 0
                ? rows.map((l, i) => `<tr><td>${i+1}</td><td>${l.ip}</td><td>${l.device}</td><td>${l.login}</td><td>${l.logout}</td></tr>`).join('')
                : `<tr><td colspan="5" class="text-muted">No login records found.</td></tr>`;
        }

        function renderTechCompletedRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0
                ? rows.map((p, i) => `<tr><td>${i+1}</td><td>${p.id}</td><td class="text-start">${p.name}</td><td>${p.date}</td></tr>`).join('')
                : `<tr><td colspan="4" class="text-muted">No completed projects.</td></tr>`;
        }

        function renderTechPendingRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0
                ? rows.map((p, i) => `<tr><td>${i+1}</td><td>${p.id}</td><td class="text-start">${p.name}</td><td>${p.dueDate}</td></tr>`).join('')
                : `<tr><td colspan="4" class="text-success fw-semibold">No pending projects — all done!</td></tr>`;
        }

        function renderAttendanceRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0
                ? rows.map((h, i) => `<tr><td>${i+1}</td><td>${h.month}</td><td class="text-success fw-bold">${h.present}</td><td class="text-danger fw-bold">${h.absent}</td><td class="text-warning fw-bold">${h.leave}</td></tr>`).join('')
                : `<tr><td colspan="5" class="text-muted">No previous records found.</td></tr>`;
        }

        function renderPartnerCompletedRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0
                ? rows.map((pr, i) => `<tr><td>${i+1}</td><td>${pr.id}</td><td class="text-start">${pr.customer}</td><td>${pr.location}</td><td>${pr.capacity}</td><td>${pr.date}</td></tr>`).join('')
                : `<tr><td colspan="6" class="text-muted">No completed projects.</td></tr>`;
        }

        function renderPartnerOngoingRows(arr, limit) {
            const rows = sliceLimit(arr, limit);
            return rows.length > 0
                ? rows.map((pr, i) => `<tr><td>${i+1}</td><td>${pr.id}</td><td class="text-start">${pr.customer}</td><td>${pr.location}</td><td>${pr.capacity}</td><td>${pr.startDate}</td></tr>`).join('')
                : `<tr><td colspan="6" class="text-muted">No ongoing projects.</td></tr>`;
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