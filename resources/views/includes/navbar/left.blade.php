<nav class="d-flex" id="layout">

    <!-- Nav Left  Start -->
    <aside id="sidebar" class="bg-dark text-white vh-100 position-fixed" style="width:280px; transition:0.3s;">

        <div class="p-3 d-flex flex-column h-100">

            <a href="#"
                class="text-white text-decoration-none mb-3 d-flex 
          justify-content-center align-items-center px-3 py-1">

                <img src="{{ asset('assets/images/logo.png') }}" height="20" class="me-2" alt="Logo" >

                <span class="fw-bold fs-5">KR HOLDINGS</span>

            </a>


            <ul class="nav nav-pills flex-column mb-auto">

                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-house-door me-2"></i> Home
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

            </ul>

            <!-- Logout -->
            <div class="mt-auto">
                <button class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </div>

        </div>

    </aside>

    <!-- Content wrapper Start -->
    <div id="content" style="margin-left:280px; width:100%;">
