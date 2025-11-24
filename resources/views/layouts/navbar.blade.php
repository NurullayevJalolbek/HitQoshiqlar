<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">

            <div class="d-flex align-items-center">
                <button id="sidebar-toggle"
                        class="sidebar-toggle me-3 btn btn-icon-only d-none d-lg-inline-block align-items-center justify-content-center">
                    <svg class="toggle-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
                <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
            </div>

            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark notification-bell unread"
                       data-unread-notifications="true"
                       href="{{ route('admin.notifications.index') }}"
                       role="button"
                       aria-expanded="false">
                        <svg class="icon icon-sm text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                    </a>
                </li>


                @include('layouts.language')


                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle py-0 px-0" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <div class="media d-flex align-items-center" style="height: 43.9px">
                            <img class="avatar rounded-circle " alt="Image placeholder "
                                 style="object-fit: cover; height:100%; width: auto; aspect-ratio: 1/1"
                                 src="https://media.istockphoto.com/id/526947869/vector/man-silhouette-profile-picture.jpg?s=612x612&w=0&k=20&c=5I7Vgx_U6UPJe9U2sA2_8JFF4grkP7bNmDnsLXTYlSc="
                                 }>
                            <div class="medemployeeia-body ms-2 text-dark d-none d-lg-flex"
                                 style="flex-direction: column; align-items: flex-start; justify-content: flex-start;">
                                <div class="mb-0 font-small fw-bold text-gray-900">
                                    {{ auth()->user()->username }}
                                </div>
                                <span class="badge bg-light text-muted text-lowercase p-0" style="font-weight: 400">
                                    {{ __('admin.' . (auth()->user()->role->code ?? 'no_role')) }}
                                </span>
                            </div>

                        </div>
                    </a>

                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                        <a class="dropdown-item d-flex align-items-center"
                           href="{{ route('admin.profile.index', ['user_id'=>auth()->user()->id]) }}">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            {{ __('admin.Profile') }}
                        </a>

                        <div role="separator" class="dropdown-divider my-1"></div>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            {{ __('admin.Logout') }}
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
