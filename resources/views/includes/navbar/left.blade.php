<!-- ===================================================== Content Start ============================================================-->
<nav class="d-flex" id="layout">

    <!-- ================================================ Nav Left  Start ========================================================== -->
    <aside id="sidebar" class="bg-dark text-white vh-100 position-fixed"
        style="width:280px; transition:0.3s; z-index: 1000;">

        <div class="p-3 d-flex flex-column h-100">

            <a href="dashboard"
                class="text-white text-decoration-none mb-0 d-flex justify-content-center align-items-center px-0 py-1">

                <img src="{{ asset('assets/images/logo.png') }}" height="32" class="me-3" alt="Logo">

                <span class="fw-bold fs-5 ">KR HOLDINGS</span>
            </a>

            <hr>

            <ul class="nav nav-pills flex-column mb-auto mx-1 ">

                <!-- Admin -->
                <li>
                    <a href="dashboard" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-3"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="user" class="nav-link text-white">
                        <i class="bi bi-person-gear me-3"></i> User Management
                    </a>
                </li>

                <li>
                    <a href="system_settings" class="nav-link text-white">
                        <i class="bi bi-database-gear me-3"></i> System Settings
                    </a>
                </li>

                <li>
                    <a href="system_monitoring" class="nav-link text-white">
                        <i class="bi bi-pie-chart-fill me-3"></i> System Monitoring
                    </a>
                </li>



                <!-- Executive -->
                <li>
                    <a href="tech" class="nav-link text-white">
                        <i class="bi bi-trophy me-3"></i> Technician Performance
                    </a>
                </li>

                <li>
                    <a href="payment" class="nav-link text-white">
                        <i class="bi bi-cash-stack me-3"></i> Payment & Salary
                    </a>
                </li>

                <li>
                    <a href="review" class="nav-link text-white">
                        <i class="bi bi-images me-3"></i> Review Photos
                    </a>
                </li>

                <li>
                    <a href="reports" class="nav-link text-white">
                        <i class="bi bi-clipboard-fill me-3"></i> Reports
                    </a>
                </li>

                <li>
                    <a href="demo" class="nav-link text-white">
                        <i class="bi bi-clipboard-fill me-3"></i> demo
                    </a>
                </li>


                <!-- Project Coordinator -->
                <li>
                    <a href="project_management" class="nav-link text-white">
                        <i class="bi bi-archive me-3"></i> Project Management
                    </a>
                </li>

                <li>
                    <a href="attendance_approval" class="nav-link text-white">
                        <i class="bi bi-check2-circle me-3"></i> Attendance Approval
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-file-earmark-check me-3"></i> Proof of Work Review
                    </a>
                </li>

                <!-- Technician -->

                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-pin me-3"></i> Assigned Projects
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-calendar-check me-3"></i> Attendance
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-camera me-3"></i> Proof of Work
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-person-circle me-3"></i> Profile
                    </a>
                </li>

            </ul>

            <!-- Logout -->
            <div class="mt-auto">
                <button class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right me-3"></i> Logout
                </button>
            </div>

        </div>

    </aside>
    <!-- ================================================== Nav Left End ==============================================================-->

    <!-- Content wrapper Start -->
    <div id="content" style="margin-left:280px; width:100%;">
