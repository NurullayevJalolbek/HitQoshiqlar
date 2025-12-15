@php
$types = ['technical' => 'Texnik', 'request' => 'So‘rov', 'error' => 'Xato'];
$statuses = ['unread' => 'O‘qilmagan', 'read' => 'O‘qilgan'];
@endphp


<div class="filter-card mb-3 mt-2 collapse show" id="notificationFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-muted small">Qidiruv</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Xabar matni...">
                </div>
            </div>


            <x-select-with-search
                name="typeFilter"
                label="Turi"
                :datas="$types"
                colMd="2"
                placeholder="Barchasi"
                :selected="request()->get('typeFilter', '')"
                :selectSearch=false />
            <x-select-with-search
                name="statusFilter"
                label="Holati"
                :datas="$statuses"
                colMd="2"
                placeholder="Barchasi"
                :selected="request()->get('statusFilter', '')"
                :selectSearch=false />




            <x-from-to-date-picker
                colMd="3"
                fromName="notificationFilterFromDate"
                toName="notificationFilterToDate"
                label="Tanlangan Sana Oralig'i" />


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