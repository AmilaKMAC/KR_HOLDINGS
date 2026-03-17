        <!-- Top Navbar -->
        <header class="navbar navbar-dark bg-dark border-bottom ">
            <div class="container-fluid ">



                <!-- Center Title -->
                <span class="navbar-brand mx-auto mb-2 mt-2 text-center">
                    {{ Request::route()->defaults['title']  }}
                </span>

                <!-- Toggle button -->
                <div class="mt-auto">
                    <button class="btn btn-outline-light d-xl-none" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                </div>

            </div>
        </header>
