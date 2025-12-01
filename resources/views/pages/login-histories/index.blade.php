@extends('layouts.app')

@push('customCss')
    <style>
        .status-icon {
            font-size: 18px;
            margin-right: 5px;
        }

        .table td, .table th {
            vertical-align: middle;
        }


        .log-level-success {
            color: #1e7e34; /* yashil */
            font-weight: 600;
        }
        .log-level-warning {
            color: #d39e00; /* sariq */
            font-weight: 600;
        }
        .log-level-error {
            color: #bd2130; /* qizil */
            font-weight: 600;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('admin.login_histories')}}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')

    {{-- FILTER --}}
    <div class="filter-card mb-3 border rounded"
         style="border-color: rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff;">

        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Filterlar</span>
            </div>

            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#loginHistoryFilterContent"
                    aria-controls="loginHistoryFilterContent"
                    id="loginHistoryToggleFilterBtn"
                    style="background-color:#1F2937;color:#fff;">
                <i class="bi bi-caret-down-fill me-2" id="loginHistoryFilterIcon"></i>
                <span id="loginHistoryFilterText">Yopish</span>
            </button>
        </div>

        <div class="collapse show" id="loginHistoryFilterContent">
            <div class="row g-3 align-items-end p-3">
                <div class="col-md-4">
                    <label>{{__('admin.search')}}</label>
                    <input type="text" class="form-control" placeholder="Ism, Login...">
                </div>

                <div class="col-md-2">
                    <label>{{__('admin.start_date')}}</label>
                    <input type="date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>{{__('admin.end_date')}}</label>
                    <input type="date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>{{__('admin.result_type')}}</label>
                    <select class="form-select">
                        <option>Barchasi</option>
                        <option>Muvaffaqiyatli</option>
                        <option>Muvaffaqiyatsiz</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> Izlash
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        Tozalash
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- LOGIN HISTORIES TABLE --}}
    <div class="card card-body py-1 px-2 shadow border-0 table-wrapper table-responsive">

        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">
                <i class="fas fa-arrow-right-to-bracket"></i>
                {{ __('admin.login_histories') }}
            </h5>

            <button class="btn btn-info text-white">
                <i class="fas fa-file-csv"></i> CSV
            </button>
        </div>


        <table class="table user-table table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>{{__('admin.user')}}</th>
                <th>{{__('admin.login')}}</th>
                <th>{{__('admin.date')}}</th>
                <th>{{__('admin.ip')}}</th>
                <th>{{__('admin.result')}}</th>
                <th>{{__('admin.actions')}}</th>
            </tr>
            </thead>

            <tbody>

            {{-- 10 ta malumot --}}
            <tr>
                <td>1</td>
                <td>Ali Valiyev</td>
                <td>ali</td>
                <td>2025-01-02 08:20</td>
                <td>192.168.1.10</td>
                <td><span class="log-level-success"><i class="fas fa-check-circle status-icon" style="color: #1e7e34;"></i> Muvaffaqiyatli</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Ali Valiyev"
                       data-login="ali"
                       data-date="2025-01-02 08:20"
                       data-ip="192.168.1.10"
                       data-result="Muvaffaqiyatli"
                       data-geo="Toshkent, Uzbekistan"
                       data-agent="Chrome 120 / Windows 10"
                       data-session="SID-001"
                       data-duration="5 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Ali Valiyev</td>
                <td>ali</td>
                <td>2025-01-02 08:19</td>
                <td>192.168.1.10</td>
                <td><span class="log-level-warning"><i class="fas fa-exclamation-triangle  status-icon" style="color: #d39e00;"></i> Ogohlantirish</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Ali Valiyev"
                       data-login="ali"
                       data-date="2025-01-02 08:19"
                       data-ip="192.168.1.10"
                       data-result="Ogohlantirish"
                       data-geo="Toshkent, Uzbekistan"
                       data-agent="Chrome 120 / Windows 10"
                       data-session="SID-002"
                       data-duration="4 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>Ali Valiyev</td>
                <td>ali</td>
                <td>2025-01-02 08:18</td>
                <td>192.168.1.10</td>
                <td><span class="log-level-error"><i class="fas fa-times-circle status-icon" style="color: #bd2130;"></i> Xato</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Ali Valiyev"
                       data-login="ali"
                       data-date="2025-01-02 08:18"
                       data-ip="192.168.1.10"
                       data-result="Xato"
                       data-geo="Toshkent, Uzbekistan"
                       data-agent="Chrome 120 / Windows 10"
                       data-session="SID-003"
                       data-duration="3 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>4</td>
                <td>Ali Valiyev</td>
                <td>ali</td>
                <td>2025-01-02 08:17</td>
                <td>192.168.1.10</td>
                <td><span class="log-level-error"><i class="fas fa-times-circle status-icon" style="color: #bd2130;"></i> Xato</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Ali Valiyev"
                       data-login="ali"
                       data-date="2025-01-02 08:17"
                       data-ip="192.168.1.10"
                       data-result="Xato"
                       data-geo="Toshkent, Uzbekistan"
                       data-agent="Chrome 120 / Windows 10"
                       data-session="SID-004"
                       data-duration="6 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>5</td>
                <td>Dilshod Karimov</td>
                <td>dilshod</td>
                <td>2025-01-02 08:15</td>
                <td>192.168.1.20</td>
                <td><span class="log-level-success"><i class="fas fa-check-circle status-icon" style="color: #1e7e34;"></i> Muvaffaqiyatli</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Dilshod Karimov"
                       data-login="dilshod"
                       data-date="2025-01-02 08:15"
                       data-ip="192.168.1.20"
                       data-result="Muvaffaqiyatli"
                       data-geo="Samarqand, Uzbekistan"
                       data-agent="Firefox 110 / Windows 11"
                       data-session="SID-005"
                       data-duration="7 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>6</td>
                <td>Sardor Olimov</td>
                <td>sardor</td>
                <td>2025-01-02 08:12</td>
                <td>192.168.1.15</td>
                <td><span class="log-level-error"><i class="fas fa-times-circle status-icon" style="color: #bd2130;"></i> Xato</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Sardor Olimov"
                       data-login="sardor"
                       data-date="2025-01-02 08:12"
                       data-ip="192.168.1.15"
                       data-result="Xato"
                       data-geo="Buxoro, Uzbekistan"
                       data-agent="Edge 101 / Windows 10"
                       data-session="SID-006"
                       data-duration="5 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>7</td>
                <td>Sardor Olimov</td>
                <td>sardor</td>
                <td>2025-01-02 08:10</td>
                <td>192.168.1.15</td>
                <td><span class="log-level-success"><i class="fas fa-check-circle status-icon" style="color: #1e7e34;"></i> Muvaffaqiyatli</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Sardor Olimov"
                       data-login="sardor"
                       data-date="2025-01-02 08:10"
                       data-ip="192.168.1.15"
                       data-result="Muvaffaqiyatli"
                       data-geo="Buxoro, Uzbekistan"
                       data-agent="Edge 101 / Windows 10"
                       data-session="SID-007"
                       data-duration="6 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>8</td>
                <td>Anna Petrova</td>
                <td>anna</td>
                <td>2025-01-01 09:50</td>
                <td>192.168.1.18</td>
                <td><span class="log-level-success"><i class="fas fa-check-circle status-icon" style="color: #1e7e34;"></i> Muvaffaqiyatli</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Anna Petrova"
                       data-login="anna"
                       data-date="2025-01-01 09:50"
                       data-ip="192.168.1.18"
                       data-result="Muvaffaqiyatli"
                       data-geo="Moskva, Rossiya"
                       data-agent="Safari 15 / macOS"
                       data-session="SID-008"
                       data-duration="8 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>9</td>
                <td>Bobur Qodirov</td>
                <td>bobur</td>
                <td>2025-01-01 09:45</td>
                <td>192.168.1.14</td>
                <td><span class="log-level-error"><i class="fas fa-times-circle status-icon" style="color: #bd2130;"></i> Xato</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Bobur Qodirov"
                       data-login="bobur"
                       data-date="2025-01-01 09:45"
                       data-ip="192.168.1.14"
                       data-result="Xato"
                       data-geo="Toshkent, Uzbekistan"
                       data-agent="Firefox 112 / Windows 11"
                       data-session="SID-009"
                       data-duration="4 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            <tr>
                <td>10</td>
                <td>Bobur Qodirov</td>
                <td>bobur</td>
                <td>2025-01-01 09:40</td>
                <td>192.168.1.14</td>
                <td><span class="log-level-warning"><i class="fas fa-exclamation-triangle  status-icon" style="color: #d39e00;"></i> Ogohlantirish</span></td>
                <td>
                    <i class="fas fa-eye text-primary me-2 showDetail"
                       data-user="Bobur Qodirov"
                       data-login="bobur"
                       data-date="2025-01-01 09:40"
                       data-ip="192.168.1.14"
                       data-result="Ogohlantirish"
                       data-geo="Toshkent, Uzbekistan"
                       data-agent="Firefox 112 / Windows 11"
                       data-session="SID-010"
                       data-duration="5 soniya"
                       title="Ko‘rish"></i>
                </td>
            </tr>

            </tbody>
        </table>
    </div>

    {{-- DETAIL MODAL --}}
    <div class="modal fade" id="loginDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirish tafsilotlari</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Foydalanuvchi</th>
                            <td id="d_user"></td>
                        </tr>
                        <tr>
                            <th>Login</th>
                            <td id="d_login"></td>
                        </tr>
                        <tr>
                            <th>Sana</th>
                            <td id="d_date"></td>
                        </tr>
                        <tr>
                            <th>IP manzil</th>
                            <td id="d_ip"></td>
                        </tr>
                        <tr>
                            <th>Natija</th>
                            <td id="d_result"></td>
                        </tr>
                        <tr>
                            <th>GEO (Taxminiy manzil)</th>
                            <td id="d_geo"></td>
                        </tr>
                        <tr>
                            <th>User-Agent</th>
                            <td id="d_agent"></td>
                        </tr>
                        <tr>
                            <th>Session ID</th>
                            <td id="d_session"></td>
                        </tr>
                        <tr>
                            <th>Kirish davomiyligi</th>
                            <td id="d_duration"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customJs')
    <script>
        function initFilterToggle(buttonId, contentId, iconId, textId) {
            const collapseEl = document.getElementById(contentId);
            const button = document.getElementById(buttonId);
            const icon = document.getElementById(iconId);
            const text = document.getElementById(textId);

            collapseEl.addEventListener('shown.bs.collapse', () => {

                icon.classList.remove('bi-caret-up-fill');
                icon.classList.add('bi-caret-down-fill');
                text.textContent = 'Yopish';
            });

            collapseEl.addEventListener('hidden.bs.collapse', () => {
                icon.classList.remove('bi-caret-down-fill');
                icon.classList.add('bi-caret-up-fill');
                text.textContent = 'Ochish';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initFilterToggle('loginHistoryToggleFilterBtn', 'loginHistoryFilterContent', 'loginHistoryFilterIcon', 'loginHistoryFilterText');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".showDetail").forEach(item => {
                item.addEventListener("click", function () {
                    document.getElementById("d_user").innerText = this.dataset.user;
                    document.getElementById("d_login").innerText = this.dataset.login;
                    document.getElementById("d_date").innerText = this.dataset.date;
                    document.getElementById("d_ip").innerText = this.dataset.ip;
                    document.getElementById("d_result").innerText = this.dataset.result;
                    document.getElementById("d_geo").innerText = this.dataset.geo;
                    document.getElementById("d_agent").innerText = this.dataset.agent;
                    document.getElementById("d_session").innerText = this.dataset.session;
                    document.getElementById("d_duration").innerText = this.dataset.duration;

                    let modal = new bootstrap.Modal(document.getElementById('loginDetailModal'));
                    modal.show();
                });
            });
        });
    </script>
@endpush
