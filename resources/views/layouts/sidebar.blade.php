<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse">
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <div class="sidebar-inner px-4 pt-3">
        <ul class="nav flex-column pt-3 pt-md-0" style="padding-top: 50px !important;">

            <!-- Logo -->
            <li class="nav-item" id="project-logo" style="list-style: none; margin-top: 20px;">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/img/envast_logo.svg') }}" height="40" width="40">
                    <img src="{{ asset('assets/img/envast_text.svg') }}" height="35" width="140">
                </a>
            </li>


            <!-- Divider -->
            <li role="separator" class="dropdown-divider border-gray-700 my-3"></li>

            <!-- Dashboard -->
            <li class="nav-item {{ isActiveRoute('admin.dashboard') }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-speedometer2"></i>
                    <span class="sidebar-text ms-2">{{__('admin.dashboard')}}</span>
                </a>
            </li>

            <!-- Foydalanuvchilar -->
            <li class="nav-item {{ isActiveRoute('admin.users.*') }}">
                <a href="{{ route('admin.users.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-people"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.users')}}</span>
                </a>
            </li>

            <!-- Investitsion loyihalar -->
            <li class="nav-item {{ isActiveRoute('admin.investment-projects.*') }}">
                <a href="{{ route('admin.investment-projects.index') }}"
                   class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-building"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.investment-projects')}}</span>
                </a>
            </li>

            <!-- Tushumlar -->
            <li class="nav-item {{ isActiveRoute('admin.revenues.*') }}">
                <a href="{{ route('admin.revenues.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-currency-dollar"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.revenues')}}</span>
                </a>
            </li>
            <!-- Projects -->
            <li class="nav-item {{ isActiveRoute('admin.projects.*') }}">
                <a href="{{ route('admin.projects.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-building"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.projects')}}</span>
                </a>
            </li>


            <!-- Daromadlar -->
            <li class="nav-item {{ isActiveRoute('admin.incomes.*') }}">
                <a href="{{ route('admin.incomes.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-wallet2"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.incomes')}}</span>
                </a>
            </li>

            <!-- Investorlar -->
            <li class="nav-item {{ isActiveRoute('admin.investors.*') }}">
                <a href="{{ route('admin.investors.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-person-badge"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.investors')}}</span>
                </a>
            </li>

            <!-- Xarajatlar -->
            <li class="nav-item {{ isActiveRoute('admin.expenses.*') }}">
                <a href="{{ route('admin.expenses.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-cash-stack"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.expenses')}}</span>
                </a>
            </li>

            <!-- Taqsimot -->
            <li class="nav-item {{ isActiveRoute('admin.distributions.*') }}">
                <a href="{{ route('admin.distributions.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.distributions')}}</span>
                </a>
            </li>

            <!-- Investitsiya shartnomalar -->
            <li class="nav-item {{ isActiveRoute('admin.investment-contracts.*') }}">
                <a href="{{ route('admin.investment-contracts.index') }}"
                   class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.investment-contracts')}}</span>
                </a>
            </li>

            <!-- Xisobotlar -->
            <li class="nav-item {{ isActiveRoute('admin.reports.*') }}">
                <a href="{{ route('admin.reports.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-line"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.reports')}}</span>
                </a>
            </li>

            <!-- Islom moliyasi nazorati -->
            <li class="nav-item {{ isActiveRoute('admin.islamic-finance.*') }}">
                <a href="{{ route('admin.islamic-finance.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-shield-check"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.islamic-finance')}}</span>
                </a>
            </li>

            <!-- Sozlamalar -->
            <li class="nav-item {{ isActiveRoute('admin.settings.*') }}">
                <a href="{{ route('admin.settings.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-gear"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.settings')}}</span>
                </a>
            </li>

            <!-- Mamuriyat bolimi -->
            <li class="nav-item {{ isActiveRoute('admin.administration.*') }}">
                <a href="{{ route('admin.administration.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-building"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.administration')}}</span>
                </a>
            </li>

            <!-- Bildirishnomalar -->
            <li class="nav-item {{ isActiveRoute('admin.notifications.*') }}">
                <a href="{{ route('admin.notifications.index') }}" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-bell"></i>
                    <span class="sidebar-text ms-2 text-break flex-fill">{{__('admin.notifications')}}</span>
                </a>
            </li>

        </ul>


        <figure id="sidebar-close-figure" class="sidebar-close-figure">
            <img class="sidebar-close-icon" src="{{ asset('svg/close.svg') }}" height="40" width="40" alt="Close icon">
        </figure>
    </div>
</nav>
