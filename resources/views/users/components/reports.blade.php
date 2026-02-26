@extends('layout.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <!-- ================= PAGE HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Activity Center</h4>
    </div>


    <!-- ========================================================= -->
    <!-- ================= USER ACTIVITY LOGS ==================== -->
    <!-- ========================================================= -->

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white fw-bold">
            User Activity Logs
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Last Action</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Amila</td>
                        <td>Login</td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>2026-02-26 09:30 AM</td>
                        <td>
                            <button 
                                class="btn btn-sm btn-info userViewBtn"
                                data-bs-toggle="modal"
                                data-bs-target="#userHistoryModal"
                                data-user="Amila">
                                View
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <!-- ========================================================= -->
    <!-- ================= SYSTEM ACTIVITY LOGS ================== -->
    <!-- ========================================================= -->

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white fw-bold">
            System Activity Logs
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Event</th>
                        <th>Module</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>101</td>
                        <td>Database Backup</td>
                        <td>System</td>
                        <td>
                            <span class="badge bg-warning text-dark">Medium</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Completed</span>
                        </td>
                        <td>2026-02-26 08:00 AM</td>
                        <td>
                            <button 
                                class="btn btn-sm btn-info systemViewBtn"
                                data-bs-toggle="modal"
                                data-bs-target="#systemHistoryModal"
                                data-event="Database Backup">
                                View
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>



<!-- ========================================================= -->
<!-- ================= USER HISTORY MODAL ===================== -->
<!-- ========================================================= -->

<div class="modal fade" id="userHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    Login History - <span id="modalUserName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>IP Address</th>
                                <th>Device</th>
                                <th>Browser</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="userHistoryBody"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- ========================================================= -->
<!-- ================= SYSTEM HISTORY MODAL =================== -->
<!-- ========================================================= -->

<div class="modal fade" id="systemHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">
                    System Event History - <span id="modalEventName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Event Type</th>
                                <th>Module</th>
                                <th>Severity</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody id="systemHistoryBody"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- ========================================================= -->
<!-- ========================== JS ============================ -->
<!-- ========================================================= -->

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ================= USER HISTORY =================
    const userButtons = document.querySelectorAll(".userViewBtn");
    const userBody = document.getElementById("userHistoryBody");

    userButtons.forEach(btn => {
        btn.addEventListener("click", function () {

            const userName = this.dataset.user;
            document.getElementById("modalUserName").innerText = userName;
            userBody.innerHTML = "";

            const sampleUserHistory = [
                {login:"2026-02-26 09:30 AM", logout:"10:00 AM", ip:"192.168.1.12", device:"Windows 10", browser:"Chrome", status:"Success"},
                {login:"2026-02-25 03:10 PM", logout:"04:00 PM", ip:"192.168.1.15", device:"Android", browser:"Edge", status:"Success"},
                {login:"2026-02-24 08:45 AM", logout:"-", ip:"192.168.1.18", device:"Windows 11", browser:"Chrome", status:"Failed"}
            ];

            sampleUserHistory.forEach((row,index)=>{
                let badge = row.status === "Success" 
                    ? '<span class="badge bg-success">Success</span>'
                    : '<span class="badge bg-danger">Failed</span>';

                userBody.innerHTML += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${row.login}</td>
                        <td>${row.logout}</td>
                        <td>${row.ip}</td>
                        <td>${row.device}</td>
                        <td>${row.browser}</td>
                        <td>${badge}</td>
                    </tr>`;
            });

        });
    });


    // ================= SYSTEM HISTORY =================
    const systemButtons = document.querySelectorAll(".systemViewBtn");
    const systemBody = document.getElementById("systemHistoryBody");

    systemButtons.forEach(btn => {
        btn.addEventListener("click", function () {

            const eventName = this.dataset.event;
            document.getElementById("modalEventName").innerText = eventName;
            systemBody.innerHTML = "";

            const sampleSystemHistory = [
                {type:"Backup", module:"System", severity:"Medium", desc:"Daily DB Backup", status:"Completed", time:"2026-02-26 08:00 AM"},
                {type:"Update", module:"Security", severity:"High", desc:"Firewall Updated", status:"Completed", time:"2026-02-25 11:30 PM"},
                {type:"Error", module:"Server", severity:"Critical", desc:"Server Timeout", status:"Failed", time:"2026-02-24 02:10 AM"}
            ];

            sampleSystemHistory.forEach((row,index)=>{

                let severityBadge = row.severity === "Critical"
                    ? '<span class="badge bg-danger">Critical</span>'
                    : row.severity === "High"
                    ? '<span class="badge bg-warning text-dark">High</span>'
                    : '<span class="badge bg-info text-dark">Medium</span>';

                let statusBadge = row.status === "Completed"
                    ? '<span class="badge bg-success">Completed</span>'
                    : '<span class="badge bg-danger">Failed</span>';

                systemBody.innerHTML += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${row.type}</td>
                        <td>${row.module}</td>
                        <td>${severityBadge}</td>
                        <td>${row.desc}</td>
                        <td>${statusBadge}</td>
                        <td>${row.time}</td>
                    </tr>`;
            });

        });
    });

});
</script>

@endsection