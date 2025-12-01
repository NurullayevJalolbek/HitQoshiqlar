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
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control" placeholder="Ism, Login...">
                    </div>
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

        <table class="table user-table table-hover table-bordered table-striped align-items-center">
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

            <tbody id="loginHistoryBody"></tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-start p-2">
            <nav>
                <ul class="pagination pagination-sm mb-0" id="loginPagination"></ul>
            </nav>
        </div>
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
                        <tr><th>Foydalanuvchi</th><td id="d_user"></td></tr>
                        <tr><th>Login</th><td id="d_login"></td></tr>
                        <tr><th>Sana</th><td id="d_date"></td></tr>
                        <tr><th>IP manzil</th><td id="d_ip"></td></tr>
                        <tr><th>Natija</th><td id="d_result"></td></tr>
                        <tr><th>GEO</th><td id="d_geo"></td></tr>
                        <tr><th>User-Agent</th><td id="d_agent"></td></tr>
                        <tr><th>Session ID</th><td id="d_session"></td></tr>
                        <tr><th>Kirish davomiyligi</th><td id="d_duration"></td></tr>
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
        document.addEventListener('DOMContentLoaded', function () {
            const users = [
                ['Olim Jo‘rayev','olim_admin','+998901112233','192.168.1.10','Toshkent'],
                ['Javohir Tursunov','javohir_mod1','+998932223344','192.168.1.11','Toshkent'],
                ['Rustam Abdurahmonov','rustam_mod2','+998953334455','192.168.1.12','Samarqand'],
                ['Zoir Bekmurodov','zoir_mod3','+998974445566','192.168.1.13','Buxoro'],
                ['Nodir Qodirov','nodir_aud1','+998905556677','192.168.1.14','Toshkent'],
                ['Umid Abdullayev','umid_aud2','+99893667788','192.168.1.15','Samarqand'],
                ['Sirojiddin Madrahimov','siroj_islam1','+998977778899','192.168.1.16','Toshkent'],
                ['Husan Sharipov','husan_islam2','+998958889900','192.168.1.17','Buxoro'],
                ['Sherzod Mamatov','sherzod_admin2','+998901124567','192.168.1.18','Samarqand'],
                ['Jasur Rahmonov','jasur_mod4','+998932214455','192.168.1.19','Toshkent'],
                ['Dilshod Yusupov','dilshod_aud3','+998913345566','192.168.1.20','Samarqand'],
                ['Farrux Karimov','farrux_islam3','+99894456677','192.168.1.21','Buxoro'],
                ['Bekzod Soliyev','bekzod_mod5','+998995567788','192.168.1.22','Toshkent'],
                ['Bobur Xolmatov','bobur_aud4','+998906678899','192.168.1.23','Samarqand'],
                ['Akmal Ortiqov','akmal_islam4','+998937789911','192.168.1.24','Buxoro']
            ];

            // Generate login history with Xato->Ogohlantirish rules
            let history = [];
            let idCounter = 1;

            users.forEach(u => {
                let errors = 0;
                let loginsCount = Math.floor(Math.random()*3)+1; // 1-3 login
                let baseDate = new Date('2025-01-02T08:00:00');

                for(let i=0;i<loginsCount;i++){
                    let result;
                    if(errors===2){
                        result='Ogohlantirish';
                        errors=0;
                    } else {
                        result = Math.random()<0.5?'Muvaffaqiyatli':'Xato';
                        if(result==='Xato') errors++; else errors=0;
                    }

                    baseDate.setMinutes(baseDate.getMinutes()+i*2);
                    history.push({
                        id: idCounter++,
                        user:u[0],
                        login:u[1],
                        date:baseDate.toISOString().slice(0,16).replace('T',' '),
                        ip:u[3],
                        geo:u[4],
                        result:result,
                        agent:'Chrome / Windows 10',
                        session:`SID-${idCounter}`,
                        duration:`${Math.floor(Math.random()*10)+3} soniya`
                    });
                }
            });

            // Pagination
            const perPage=10;
            let currentPage=1;

            function renderTable(){
                const tbody=document.getElementById('loginHistoryBody');
                tbody.innerHTML='';

                const start=(currentPage-1)*perPage;
                const end=start+perPage;
                const pageData=history.slice(start,end);

                pageData.forEach(h=>{
                    let cls='';
                    if(h.result==='Muvaffaqiyatli') cls='log-level-success';
                    else if(h.result==='Xato') cls='log-level-error';
                    else cls='log-level-warning';

                    tbody.innerHTML+=`
                <tr>
                    <td>${h.id}</td>
                    <td>${h.user}</td>
                    <td>${h.login}</td>
                    <td>${h.date}</td>
                    <td>${h.ip}</td>
                    <td><span class="${cls}"><i class="fas ${h.result==='Muvaffaqiyatli'?'fa-check-circle':h.result==='Xato'?'fa-times-circle':'fa-exclamation-triangle'} status-icon"></i> ${h.result}</span></td>
                    <td>
                        <i class="fas fa-eye text-primary me-2 showDetail"
                           data-user="${h.user}"
                           data-login="${h.login}"
                           data-date="${h.date}"
                           data-ip="${h.ip}"
                           data-result="${h.result}"
                           data-geo="${h.geo}"
                           data-agent="${h.agent}"
                           data-session="${h.session}"
                           data-duration="${h.duration}"
                           title="Ko‘rish"></i>
                    </td>
                </tr>
            `;
                });

                renderPagination();
                initDetailModal();
            }

            function renderPagination(){
                const pagination=document.getElementById('loginPagination');
                pagination.innerHTML='';
                const totalPages=Math.ceil(history.length/perPage);

                pagination.innerHTML+=`<li class="page-item ${currentPage===1?'disabled':''}"><a class="page-link" onclick="goPage(${currentPage-1})">«</a></li>`;
                for(let i=1;i<=totalPages;i++){
                    pagination.innerHTML+=`<li class="page-item ${currentPage===i?'active':''}"><a class="page-link" onclick="goPage(${i})">${i}</a></li>`;
                }
                pagination.innerHTML+=`<li class="page-item ${currentPage===totalPages?'disabled':''}"><a class="page-link" onclick="goPage(${currentPage+1})">»</a></li>`;
            }

            window.goPage=function(page){
                const totalPages=Math.ceil(history.length/perPage);
                if(page<1 || page>totalPages) return;
                currentPage=page;
                renderTable();
            }

            function initDetailModal(){
                document.querySelectorAll(".showDetail").forEach(item=>{
                    item.addEventListener("click",function(){
                        document.getElementById("d_user").innerText=this.dataset.user;
                        document.getElementById("d_login").innerText=this.dataset.login;
                        document.getElementById("d_date").innerText=this.dataset.date;
                        document.getElementById("d_ip").innerText=this.dataset.ip;
                        document.getElementById("d_result").innerText=this.dataset.result;
                        document.getElementById("d_geo").innerText=this.dataset.geo;
                        document.getElementById("d_agent").innerText=this.dataset.agent;
                        document.getElementById("d_session").innerText=this.dataset.session;
                        document.getElementById("d_duration").innerText=this.dataset.duration;

                        let modal=new bootstrap.Modal(document.getElementById('loginDetailModal'));
                        modal.show();
                    });
                });
            }

            renderTable();

        });
    </script>
@endpush
