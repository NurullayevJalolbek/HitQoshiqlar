<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse">
    <div class="sidebar-inner">
        <!-- Fixed Logo at Top -->
        <div id="project-logo" class="sidebar-logo-wrapper">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/img/envast_logo.svg') }}" height="35" width="35" alt="Logo">
                <img src="{{ asset('assets/img/envast_text.svg') }}" height="30" width="130" alt="Envast" class="logo-text">
            </a>
            <li role="separator" class="dropdown-divider border-gray-700 my-3"></li>
        </div>

        <!-- Scrollable Menu Content -->
        <div class="sidebar-menu-wrapper" id="sidebar-menu-wrapper">
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item {{ isActiveRoute('admin.dashboard') }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-speedometer2"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.dashboard') }}</span>
                    </a>
                </li>

                <!-- Investment Projects -->
                <li class="nav-item">
                    @php
                        $isOpen = isActiveCollapseArray([
                            'admin.projects.*',
                            'admin.project-investors.*',
                            'admin.project-buyers.*',
                            'admin.project-entry-requests.*',
                            'admin.project-exit-requests.*',
                            'admin.company-details.*',
                        ], 'show');
                    @endphp

                    <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#submenu-projects"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                        <span>
                            <i class="bi bi-building"></i>
                            <span class="sidebar-text ms-2">{{ __('admin.investment-projects') }}</span>
                        </span>
                        <span class="link-arrow">
                            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>

                    <div class="multi-level collapse {{ $isOpen }}" id="submenu-projects">
                        <ul class="flex-column nav">
                            <li class="nav-item {{ isActiveRoute('admin.projects.*') }}">
                                <a class="nav-link" href="{{ route('admin.projects.index') }}">
                                    <span class="sidebar-text">{{ __('admin.projects') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.project-investors.*') }}">
                                <a class="nav-link" href="{{ route('admin.project-investors.index') }}">
                                    <span class="sidebar-text">{{ __('admin.project_investors') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.project-buyers.*') }}">
                                <a class="nav-link" href="{{ route('admin.project-buyers.index') }}">
                                    <span class="sidebar-text">{{ __('admin.project_buyers') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.project-entry-requests.*') }}">
                                <a class="nav-link" href="{{ route('admin.project-entry-requests.index') }}">
                                    <span class="sidebar-text">{{ __('admin.share_join_requests') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.project-exit-requests.*') }}">
                                <a class="nav-link" href="{{ route('admin.project-exit-requests.index') }}">
                                    <span class="sidebar-text">{{ __('admin.share_exit_requests') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.company-details.*') }}">
                                <a class="nav-link" href="{{ route('admin.company-details.index') }}">
                                    <span class="sidebar-text">{{ __('admin.company_details') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Tushumlar -->
                <li class="nav-item {{ isActiveRoute('admin.revenues.*') }}">
                    <a href="{{ route('admin.revenues.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-currency-dollar"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.revenues') }}</span>
                    </a>
                </li>

                <!-- Daromadlar -->
                <li class="nav-item {{ isActiveRoute('admin.incomes.*') }}">
                    <a href="{{ route('admin.incomes.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-wallet2"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.incomes') }}</span>
                    </a>
                </li>

                <!-- Xarajatlar -->
                <li class="nav-item {{ isActiveRoute('admin.expenses.*') }}">
                    <a href="{{ route('admin.expenses.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-cash-stack"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.expenses') }}</span>
                    </a>
                </li>

                <!-- Taqsimot -->
                <li class="nav-item {{ isActiveRoute('admin.distributions.*') }}">
                    <a href="{{ route('admin.distributions.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-diagram-3"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.distributions') }}</span>
                    </a>
                </li>

                <!-- Investitsiya shartnomalar -->
                <li class="nav-item {{ isActiveRoute('admin.investment-contracts.*') }}">
                    <a href="{{ route('admin.investment-contracts.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.investment-contracts') }}</span>
                    </a>
                </li>

                <!-- Xisobotlar -->
                <li class="nav-item {{ isActiveRoute('admin.reports.*') }}">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-bar-chart-line"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.reports') }}</span>
                    </a>
                </li>

                <!-- Islom moliyasi -->
                <li class="nav-item {{ isActiveRoute('admin.islamic-finance.*') }}">
                    <a href="{{ route('admin.islamic-finance.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.islamic-finance') }}</span>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    @php
                        $isOpen = isActiveCollapseArray([
                            'admin.references.*',
                            'admin.general-settings.*',
                            'admin.integration-settings.*',
                            'admin.user-interface.*',
                            'admin.seo-settings.*',
                            'admin.localization.*'
                        ], 'show');
                    @endphp

                    <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#submenu-settings"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                        <span>
                            <i class="bi bi-gear"></i>
                            <span class="sidebar-text ms-2">{{ __('admin.settings') }}</span>
                        </span>
                        <span class="link-arrow">
                            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>

                    <div class="multi-level collapse {{ $isOpen }}" id="submenu-settings">
                        <ul class="flex-column nav">
                            <li class="nav-item {{ isActiveRoute('admin.references.*') }}">
                                <a class="nav-link" href="{{ route('admin.references.index') }}">
                                    <span class="sidebar-text">{{ __('admin.documents') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute(['admin.general-settings.*', 'admin.seo-settings.*', 'admin.localization.*']) }}">
                                <a class="nav-link" href="{{ route('admin.general-settings.index') }}">
                                    <span class="sidebar-text">{{ __('admin.general_settings') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.integration-settings.*') }}">
                                <a class="nav-link" href="{{ route('admin.integration-settings.index') }}">
                                    <span class="sidebar-text">{{ __('admin.integration_settings') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.user-interface.*') }}">
                                <a class="nav-link" href="{{ route('admin.user-interface.index') }}">
                                    <span class="sidebar-text">{{ __('admin.user_interface') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Administration -->
                <li class="nav-item">
                    @php
                        $isOpen = isActiveCollapseArray([
                            'admin.users.*',
                            'admin.investors.*',
                            'admin.roles.*',
                            'admin.permissions.*',
                            'admin.login-histories.*',
                            'admin.system-logs.*',
                        ], 'show');
                    @endphp

                    <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#submenu-administration"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                        <span>
                            <i class="bi bi-grid-3x3-gap"></i>
                            <span class="sidebar-text ms-2">{{ __('admin.administration') }}</span>
                        </span>
                        <span class="link-arrow">
                            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>

                    <div class="multi-level collapse {{ $isOpen }}" id="submenu-administration">
                        <ul class="flex-column nav">
                            <li class="nav-item {{ isActiveRoute('admin.users.*') }}">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">
                                    <span class="sidebar-text">{{ __('admin.users') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.investors.*') }}">
                                <a class="nav-link" href="{{ route('admin.investors.index') }}">
                                    <span class="sidebar-text">{{ __('admin.investors') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.roles.*') }}">
                                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                                    <span class="sidebar-text">{{ __('admin.roles') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.login-histories.*') }}">
                                <a class="nav-link" href="{{ route('admin.login-histories.index') }}">
                                    <span class="sidebar-text">{{ __('admin.login_history') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ isActiveRoute('admin.system-logs.*') }}">
                                <a class="nav-link" href="{{ route('admin.system-logs.index') }}">
                                    <span class="sidebar-text">{{ __('admin.system_logs') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Bildirishnomalar -->
                <li class="nav-item {{ isActiveRoute('admin.notifications.*') }}">
                    <a href="{{ route('admin.notifications.index') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="bi bi-bell"></i>
                        <span class="sidebar-text ms-2">{{ __('admin.notifications') }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Fixed Close Button at Bottom -->
        <figure id="sidebar-close-figure" class="sidebar-close-figure">
            <img class="sidebar-close-icon" src="{{ asset('svg/close.svg') }}" height="40" width="40" alt="Close">
        </figure>
    </div>
</nav>