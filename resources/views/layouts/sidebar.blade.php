<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" style="z-index: 1000" data-simplebar
     style="overflow-y: auto !important;">
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <div class="sidebar-inner px-4 pt-3">
        <ul class="nav flex-column pt-3 pt-md-0" style="padding-top: 50px !important;">

            <li class="nav-item" id="project-logo" style="list-style: none;">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/img/envast_logo.svg') }}" height="40" width="40">
                    <img src="{{ asset('assets/img/envast_text.svg') }}" height="35" width="140">
                </a>
            </li>


            <li role="separator" class="dropdown-divider border-gray-700"></li>

            <li class="nav-item {{ isActiveRoute('admin.dashboard') }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center">
                    <img src="{{ asset('svg/activity.svg') }}" alt="Activity">
                    <span class="sidebar-text ms-3">Dashboard</span>
                </a>
            </li>


        </ul>

        <figure id="sidebar-close-figure" class="sidebar-close-figure">
            <img class="sidebar-close-icon" src="{{ asset('svg/close.svg') }}" height="40" width="40" alt="Close icon">
        </figure>
    </div>
</nav>
