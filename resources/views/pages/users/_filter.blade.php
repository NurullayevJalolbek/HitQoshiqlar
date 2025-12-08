<div class="filter-card mb-3 mt-2 collapse show" id="userFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">

                <!-- Qidiruv -->
                <div class="col-md-4 col-sm-6 col-12">
                    <label for="searchInput">{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="{{__('admin.full_name')}}, {{__('admin.login')}}, {{__('admin.email')}}...">
                    </div>
                </div>

                <!-- Rol bo‘yicha filter -->
                <div class="col-md-3 col-sm-6 col-12">
                    <label for="roleFilter">{{__('admin.by_role')}}</label>
                    <select id="roleFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Admin">Admin</option>
                        <option value="Moliyaviy auditor">Moliyaviy auditor</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Islom moliyasi nazorati">Islom moliyasi nazorati</option>
                    </select>
                </div>

                <!-- Holat bo‘yicha filter -->
                <div class="col-md-2 col-sm-6 col-12">
                    <label for="statusFilter">{{__('admin.by_status')}}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Faol">Faol</option>
                        <option value="Bloklangan">Bloklangan</option>
                    </select>
                </div>

                <!-- Telefon bo‘yicha filter -->
                <div class="col-md-3 col-sm-6 col-12">
                    <label for="phoneFilter">Telefon bo'yicha</label>
                    <input type="text" id="phoneFilter" class="form-control" placeholder="+998 ...">
                </div>

                <!-- Sana oraligi filter -->
                <div class="col-md-4 col-sm-6 col-12">
                    <label for="dateFrom">{{ __('admin.date_from') }}</label>
                    <input type="date" id="dateFrom" class="form-control">
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <label for="dateTo">{{ __('admin.date_to') }}</label>
                    <input type="date" id="dateTo" class="form-control">
                </div>

                <!-- Filter tugmalari -->
                <div class="col-md-4">
                    <button id="filterBtn" class="btn btn-primary">
                        <i class="fas fa-filter"></i> {{__('admin.search')}}
                    </button>
                    <button id="clearBtn" class="btn btn-warning">
                        {{__('admin.clear')}}
                </div>
            </div>
        </div>
    </div>