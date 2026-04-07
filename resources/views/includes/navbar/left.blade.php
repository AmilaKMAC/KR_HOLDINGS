<!-- ===================================================== Content Start ============================================================-->
<nav class="d-flex" id="layout">

    <!-- ================================================ Nav Left  Start ========================================================== -->
    <aside id="sidebar" class="bg-dark text-white vh-100 position-fixed"
        style="width:280px; transition:0.3s; z-index: 1000;">

        <div class="p-3 d-flex flex-column h-100">

            @php $role = Auth::user()->user_role_iduser_role; @endphp

            <a href="{{ 
                $role == 1 ? route('admin.dashboard') : 
                ($role == 2 ? route('executive.dashboard') : 
                ($role == 3 ? route('coordinator.dashboard') : 
                route('technician.dashboard'))) }}"
                class="text-white text-decoration-none mb-0 d-flex justify-content-center align-items-center px-0 py-1">
                <img src="{{ asset('assets/images/logo.png') }}" height="32" class="me-3" alt="Logo">
                <span class="fw-bold fs-5">KR HOLDINGS</span>
            </a>

            <hr>

            <ul class="nav nav-pills flex-column mb-auto mx-1">

                {{-- ================= ADMIN ================= --}}
                @if($role == 1)
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('userManagement.index') }}" class="nav-link text-white">
                            <i class="bi bi-person-gear me-3"></i> User Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('system_settings.index') }}" class="nav-link text-white">
                            <i class="bi bi-database-gear me-3"></i> System Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('system_monitoring.index') }}" class="nav-link text-white">
                            <i class="bi bi-pie-chart-fill me-3"></i> System Monitoring
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" class="nav-link text-white">
                            <i class="bi bi-clipboard-fill me-3"></i> Reports
                        </a>
                    </li>
                @endif

                {{-- ================= EXECUTIVE ================= --}}
                @if($role == 2)
                    <li>
                        <a href="{{ route('executive.dashboard') }}" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('technician_performance.index') }}" class="nav-link text-white">
                            <i class="bi bi-trophy me-3"></i> Technician Performance
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payment_and_salary.index') }}" class="nav-link text-white">
                            <i class="bi bi-cash-stack me-3"></i> Payment & Salary
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('review_photos.index') }}" class="nav-link text-white">
                            <i class="bi bi-images me-3"></i> Review Photos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" class="nav-link text-white">
                            <i class="bi bi-clipboard-fill me-3"></i> Reports
                        </a>
                    </li>
                @endif

                {{-- ================= PROJECT COORDINATOR ================= --}}
                @if($role == 3)
                    <li>
                        <a href="{{ route('coordinator.dashboard') }}" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('project_management.index') }}" class="nav-link text-white">
                            <i class="bi bi-archive me-3"></i> Project Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('attendance_approval.index') }}" class="nav-link text-white">
                            <i class="bi bi-check2-circle me-3"></i> Attendance Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('proof_of_work_approval.index') }}" class="nav-link text-white">
                            <i class="bi bi-file-earmark-check me-3"></i> Proof of Work Approval
                        </a>
                    </li>
                @endif

                {{-- ================= TECHNICIAN ================= --}}
                @if($role == 4)
                    <li>
                        <a href="{{ route('technician.dashboard') }}" class="nav-link text-white">
                            <i class="bi bi-speedometer2 me-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('assign_projects.index') }}" class="nav-link text-white">
                            <i class="bi bi-pin me-3"></i> Assigned Projects
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('attendance.index') }}" class="nav-link text-white">
                            <i class="bi bi-calendar-check me-3"></i> Attendance
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('proof_of_work.index') }}" class="nav-link text-white">
                            <i class="bi bi-camera me-3"></i> Proof of Work
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.index') }}" class="nav-link text-white">
                            <i class="bi bi-person-circle me-3"></i> Profile
                        </a>
                    </li>
                @endif

            </ul>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right me-3"></i> Logout
                </button>
            </form>

        </div>

    </aside>
    <!-- ================================================== Nav Left End ==============================================================-->

    <!-- Content wrapper Start -->
    <div id="content" style="margin-left:280px; width:100%;">