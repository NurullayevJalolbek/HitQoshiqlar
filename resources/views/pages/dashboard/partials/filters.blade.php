<div class="filter-card mb-3 border rounded"
         style="border-color: rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff;">


        <!-- Filter header -->
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Filterlar</span>
            </div>

            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#userFilterContent" aria-expanded="true"
                    aria-controls="userFilterContent" id="userToggleFilterBtn"
                    style="background-color: #1F2937; color: #ffffff;">
                <i class="bi bi-caret-down-fill me-2" id="userFilterIcon" style="color: #ffffff;"> </i>
                <span id="userFilterText">Yopish</span>
            </button>
        </div>

        <!-- Filter content -->
        <div class="collapse show" id="userFilterContent">
            <div class="row g-3 align-items-end p-3">
                {{-- Qidiruv --}}
                <div class="col-md-4">
                    <label for="searchInput">{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="{{__('admin.full_name')}}, {{__('admin.login')}}, {{__('admin.email')}}...">
                    </div>
                </div>

                {{-- Rol bo‘yicha filter --}}
                <div class="col-md-3">
                    <label for="roleFilter">{{__('admin.by_role')}}</label>
                    <select id="roleFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Admin">Admin</option>
                        <option value="Moliyaviy auditor">Moliyaviy auditor</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Islom moliyasi nazorati">Islom moliyasi nazorati</option>
                    </select>
                </div>

                {{-- Holat bo‘yicha filter --}}
                <div class="col-md-3">
                    <label for="statusFilter">{{__('admin.by_status')}}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Faol">Faol</option>
                        <option value="Bloklangan">Bloklangan</option>
                    </select>
                </div>

                {{-- Tugmalar --}}
                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{__('admin.search')}}
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{__('admin.clear')}}
                    </button>
                </div>
            </div>
        </div>
    </div>