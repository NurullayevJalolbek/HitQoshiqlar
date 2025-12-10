@push('customCss')
<style>
    .input-group-text {
        border-right: none;
    }

    .input-group .form-control,
    .input-group .form-select {
        border-left: none;
    }
</style>
@endpush

<div class="filter-card mb-3 mt-2 collapse show" id="systemHistoryFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <!-- F.I.O -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="fioInput">F.I.O</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                    <input type="text" id="fioInput" class="form-control" placeholder="F.I.O">
                </div>
            </div>

            <!-- Log holati -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="logStateFilter">Log holati</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-exclamation-circle text-muted"></i>
                    </span>
                    <select id="logStateFilter" class="form-select">
                        <option value="all">{{__('admin.all')}}</option>
                        <option value="INFO">INFO</option>
                        <option value="WARNING">WARNING</option>
                        <option value="ERROR">ERROR</option>
                    </select>
                </div>
            </div>

            <!-- Log turi -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="logActionFilter">Log turi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-layer-group text-muted"></i>
                    </span>
                    <select id="logActionFilter" class="form-select">
                        <option value="all">{{__('admin.all')}}</option>
                        <option value="CREATE">CREATE</option>
                        <option value="UPDATE">UPDATE</option>
                        <option value="DELETE">DELETE</option>
                        <option value="EXPORT">EXPORT</option>
                    </select>
                </div>
            </div>

            <!-- Modul -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="moduleFilter">{{__('admin.module')}}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-boxes text-muted"></i>
                    </span>
                    <select id="moduleFilter" class="form-select">
                        <option value="all">{{__('admin.all')}}</option>
                        <option value="Loyihalar">Loyihalar</option>
                        <option value="Investorlar">Investorlar</option>
                        <option value="Ma'muriyat bo'limi">Ma'muriyat bo'limi</option>
                        <option value="Hisobotlar">Hisobotlar</option>
                        <option value="Foydalanuvchilar">Foydalanuvchilar</option>
                    </select>
                </div>
            </div>

            <!-- Sana from -->
            <div class="col-md-4 col-sm-6 col-12">
                <label for="dateFrom">{{ __('admin.date_from') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-calendar-day text-muted"></i>
                    </span>
                    <input type="date" id="dateFrom" class="form-control">
                </div>
            </div>

            <!-- Sana to -->
            <div class="col-md-4 col-sm-6 col-12">
                <label for="dateTo">{{ __('admin.date_to') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-calendar-check text-muted"></i>
                    </span>
                    <input type="date" id="dateTo" class="form-control">
                </div>
            </div>

            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />

        </div>
    </div>
</div>