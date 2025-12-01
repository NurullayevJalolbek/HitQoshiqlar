<div class="filter-card">
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="searchInput">{{__('admin.search')}}</label>
            <input type="text" id="searchInput" class="form-control" placeholder="{{__('admin.project_name_or_id')}}">
        </div>
        <div class="col-md-2">
            <label for="categoryFilter">{{__('admin.category')}}</label>
            <select id="categoryFilter" class="form-select">
                <option value="all">{{__('admin.all')}}</option>
                <option value="yer">{{__('admin.land')}}</option>
                <option value="qurilish">{{__('admin.construction')}}</option>
                <option value="ijara">{{__('admin.rent')}}</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="statusFilter">{{__('admin.status')}}</label>
            <select id="statusFilter" class="form-select">
                <option value="all">{{__('admin.all')}}</option>
                <option value="nofaol">{{__('admin.inactive')}}</option>
                <option value="rejalashtirilgan">{{__('admin.planned')}}</option>
                <option value="faol">{{__('admin.active')}}</option>
                <option value="yakunlangan">{{__('admin.completed')}}</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="riskFilter">{{__('admin.risk_level')}}</label>
            <select id="riskFilter" class="form-select">
                <option value="all">{{__('admin.all')}}</option>
                <option value="past">{{__('admin.low')}}</option>
                <option value="orta">{{__('admin.medium')}}</option>
                <option value="yuqori">{{__('admin.high')}}</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button id="filterBtn" class="btn btn-primary w-50">
                <i class="fas fa-filter"></i> {{__('admin.filter')}}
            </button>
            <button id="clearBtn" class="btn btn-warning w-50">{{__('admin.clear')}}</button>
        </div>
    </div>
</div>