
<div class="filter-card mb-3 mt-2 collapse show" id="projectBuyerFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">
            <!-- Qidiruv -->
            <div class="col-md-4">
                <label for="searchInput">{{__('admin.search')}}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control"
                           placeholder="{{__('admin.full_name')}}, {{__('admin.login')}}, {{__('admin.email')}}...">
                </div>
            </div>

            <!-- Holat bo‘yicha filter -->
            <div class="col-md-3">
                <select id="filter_category" class="form-control">
                    <option value="">Barchasi</option>
                    <option value="yer">Yer</option>
                    <option value="qurilish">Qurilish</option>
                    <option value="ijara">Ijara</option>
                </select>
            </div>

            <!-- Filter tugmalari -->
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
