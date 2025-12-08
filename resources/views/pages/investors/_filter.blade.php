<div class="filter-card mb-3 mt-2 collapse show" id="investorFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            {{-- Qidiruv --}}
            <div class="col-md-6">
                <label for="searchInput" class="form-label">Qidiruv</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control"
                        placeholder="Ism, Login, Telefon, Pasport, JSHIR...">
                </div>
            </div>

            {{-- Status --}}
            <div class="col-md-3">
                <label for="statusFilter" class="form-label">Holati</label>
                <select id="statusFilter" class="form-select">
                    <option value="">Barchasi</option>
                    <option value="Faol">Faol</option>
                    <option value="Bloklangan">Bloklangan</option>
                    <option value="Kutilmoqda">Kutilmoqda</option>
                </select>
            </div>

            {{-- Tasdiqlanish holati --}}
            <div class="col-md-3">
                <label for="verificationFilter" class="form-label">Tasdiqlanish</label>
                <select id="verificationFilter" class="form-select">
                    <option value="">Barchasi</option>
                    <option value="Tasdiqlangan">Tasdiqlangan</option>
                    <option value="Tasdiqlanmagan">Tasdiqlanmagan</option>
                </select>
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

            {{-- Custom sana oralig'i (dastlab yashirin) --}}
            <div class="col-md-6 custom-date-range" style="display: none;">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label for="startDate" class="form-label">Boshlanish sanasi</label>
                        <input type="date" id="startDate" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="endDate" class="form-label">Tugash sanasi</label>
                        <input type="date" id="endDate" class="form-control">
                    </div>
                </div>
            </div>

            {{-- Harakatlar tugmalari --}}
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