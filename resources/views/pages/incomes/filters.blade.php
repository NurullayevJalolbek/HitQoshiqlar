<div class="card mb-4">
    <div class="card-body">
        <form id="incomeFilterForm" class="row g-3">

            {{-- QIDIRUV (F.I.O / Login / Telefon) --}}
            <div class="col-md-3">
                <label class="form-label">Qidiruv (F.I.O / Login / Telefon)</label>
                <input type="text" class="form-control" id="searchInput" placeholder="Masalan: Asror, munisa_s">
            </div>

            {{-- Kategoriya --}}
            <div class="col-md-3">
                <label class="form-label">Kategoriya</label>
                <select id="categoryFilter" class="form-select">
                    <option value="">Hammasi</option>
                    <option value="Ijaradan daromad">Ijaradan daromad</option>
                    <option value="Qurilish sotuvlari">Qurilish sotuvlari</option>
                    <option value="Er daromadi">Er daromadi</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select id="statusFilter" class="form-select">
                    <option value="">Hammasi</option>
                    <option value="paid">To‘landi</option>
                    <option value="pending">Kutilmoqda</option>
                    <option value="rejected">Rad etilgan</option>
                </select>
            </div>

            {{-- Sana boshi --}}
            <div class="col-md-3">
                <label class="form-label">Sana (dan)</label>
                <input type="date" id="dateFrom" class="form-control">
            </div>

            {{-- Sana oxiri --}}
            <div class="col-md-3">
                <label class="form-label">Sana (gacha)</label>
                <input type="date" id="dateTo" class="form-control">
            </div>

            {{-- TUGMALAR --}}
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="applyFilters" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Qidirish
                </button>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="resetFilters" class="btn btn-light w-100">
                    <i class="fas fa-undo"></i> Tozalash
                </button>
            </div>

        </form>
    </div>
</div>
