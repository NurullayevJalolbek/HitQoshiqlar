<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">

            <div class="d-flex align-items-center">
                <button id="sidebar-toggle" class="sidebar-toggle me-3 btn btn-icon-only d-none d-lg-inline-block align-items-center justify-content-center">
                    <svg class="toggle-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
            </div>

            <ul class="navbar-nav align-items-center ms-auto me-3">
                <li class="nav-item">
                    <a href="{{ asset('files/guide-admin.pdf') }}" target="_blank" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                        <img src="{{ asset('svg/pdf.svg') }}" height="20" width="20" alt="PDF" class="flex-shrink-0">
                        <span class="ms-2">{{ __('admin.Guide') }}</span>
                    </a>
                </li>
            </ul>

            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center">
{{--                @include('layouts.languages')--}}

                <li class="nav-item dropdown">
                    {{-- <a class="nav-link text-dark notification-bell unread dropdown-toggle"
                        data-unread-notifications="true" href="#" role="button" data-bs-toggle="dropdown"
                        data-bs-display="static" aria-expanded="false">
                        <svg class="icon icon-sm text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                    </a> --}}

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0">
                        <div class="list-group list-group-flush">
                            <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">
                                Bildirishnomalar
                            </a>
                            @foreach ([1, 2, 3, 4, 5] as $notif)
                            <a href="#" class="list-group-item list-group-item-action border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="{{ asset('assets/img/team/profile-picture-5.jpg') }}" class="avatar-md rounded">
                                    </div>
                                    <div class="col ps-0 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="h6 mb-0 text-small">Bonnie Green</h4>
                                            </div>
                                            <div class="text-end">
                                                <small>2 hrs ago</small>
                                            </div>
                                        </div>
                                        <p class="font-small mt-1 mb-0">New message: "We need to improve the
                                            UI/UX for the landing page."</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            <a href="#" class="dropdown-item text-center fw-bold rounded-bottom py-3">
                                <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                View all
                            </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle py-0 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
{{--                        <div class="media d-flex align-items-center" style="height: 43.9px">--}}
{{--                            <img class="avatar rounded-circle " alt="Image placeholder " style="object-fit: cover; height:100%; width: auto; aspect-ratio: 1/1" src={{ auth()->user()?->getAvatar('image') }}>--}}
{{--                            <div class="medemployeeia-body ms-2 text-dark d-none d-lg-flex" style="flex-direction: column; align-items: flex-start; justify-content: flex-start;">--}}
{{--                                <div class="mb-0 font-small fw-bold text-gray-900">--}}
{{--                                    {{ auth()->user()->username }}--}}
{{--                                </div>--}}
{{--                                <span class="badge bg-light text-muted text-lowercase p-0" style="font-weight: 400">--}}
{{--                                    {{ __('admin.' . (auth()->user()->role->code ?? 'no_role')) }}--}}
{{--                                </span>--}}
{{--                            </div>--}}

{{--                        </div>--}}
                    </a>

                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
{{--                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile.index') }}">--}}
{{--                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>--}}
{{--                            </svg>--}}
{{--                            {{ __('locale.My profile') }}--}}
{{--                        </a>--}}

                        <div role="separator" class="dropdown-divider my-1"></div>
{{--                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">--}}
{{--                            <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">--}}
{{--                                </path>--}}
{{--                            </svg>--}}
{{--                            {{ __('admin.Logout') }}--}}
{{--                        </a>--}}
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
