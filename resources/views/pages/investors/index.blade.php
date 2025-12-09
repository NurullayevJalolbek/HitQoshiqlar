@extends('layouts.app')

@push('customCss')
<style>
    .status-active {
        color: #1e7e34;
        font-weight: bold;
    }

    .status-blocked {
        color: #bd2130;
        font-weight: bold;
    }

    .status-pending {
        color: #d39e00;
        font-weight: bold;
    }

    .label-verified {
        background-color: #1e7e34;
        color: #fff;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        margin-left: 5px;
    }

    .label-unverified {
        background-color: #d39e00;
        color: #fff;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        margin-left: 5px;
    }

    /*shield icon*/

    .status-pending-icon {
        width: 20px;
        height: 20px;
        object-fit: contain;
    }

    .action-btn i {
        font-size: 18px;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <!-- Breadcrumb -->
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('admin.investors') }}</li>
            </ol>
        </nav>
    </div>

    <!-- Tugmalar guruhi -->
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <button class="btn btn-success btn-sm px-2 py-1" id="exportExcelBtn">
            <i class="fas fa-file-excel me-1" style="font-size: 0.85rem;"></i> Excel
        </button>

        <!-- Export CSV -->
        <button class="btn btn-info btn-sm text-white px-2 py-1" id="exportCsvBtn">
            <i class="fas fa-file-csv me-1" style="font-size: 0.85rem;"></i> CSV
        </button>

        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#investorFilterContent" aria-expanded="true"
            aria-controls="investorFilterContent">
            <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')
@php
$datas = getInvestorsData();


$pagination = manualPaginate($datas, 10);


$investors = $pagination['items'];


$currentPage = $pagination['currentPage'];
$pageCount = $pagination['pageCount'];

$start = $pagination['start'];
$total = $pagination['total'];
$end = $pagination['end'];
@endphp



<!-- Filter card -->
@include('pages.investors._filter')

                <div class="col-md-3">
                    <label for="activityTypeFilter">{{ __('admin.activity_type') }}</label>
                    <select id="activityTypeFilter" class="form-select">
                        <option value="">{{ __('admin.all') }}</option>
                        <option value="МЧЖ">{{ __('admin.mchj') }}</option>
                        <option value="АЖ">{{ __('admin.aj') }}</option>
                        <option value="ЯТТ">{{ __('admin.yatt') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="statusFilter">{{ __('admin.status') }}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{ __('admin.all') }}</option>
                        <option value="Faol">{{ __('admin.active') }}</option>
                        <option value="Bloklangan">{{ __('admin.blocked') }}</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{ __('admin.search') }}
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{ __('admin.clear') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th>№</th>
                <th>F.I.O</th>
                <th>Login</th>
                <th>Telefon</th>
                <th>Seriya/Raqam</th>
                <th>JSHIR</th>
                <th>Holati</th>
                <th>Oxirgi kirish</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody id="investorTableBody">
            @forelse($investors as $investor)
            @php
            // Status ikonkalari
            $verificationIcon = '';
            if (strtolower(trim($investor['status'])) === 'bloklangan') {
            $verificationIcon = '<i class="fas fa-ban text-danger" title="Bloklangan"></i>';
            } elseif (strtolower(trim($investor['verification_status'])) === 'tasdiqlangan') {
            $verificationIcon = '<i class="bi bi-patch-check-fill status-active" title="Tasdiqlangan"></i>';
            } else {
            $verificationIcon = '<i class="bi bi-patch-exclamation-fill status-pending" title="Tasdiqlanmagan"></i>';
            }
            @endphp

            <tr>
                <td>{{ $investor['id'] }}</td>
                <td>
                    {{ $investor['name'] }}
                    {!! $verificationIcon !!}
                </td>
                <td>{{ $investor['username'] }}</td>
                <td>{{ $investor['phone'] }}</td>
                <td>
                    @if($investor['verification_status'] === 'Tasdiqlangan')
                    {{ $investor['passport'] ?: '-' }}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($investor['verification_status'] === 'Tasdiqlangan')
                    {{ $investor['inn'] ?: '-' }}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($investor['status'] === 'Faol')
                    <span class="status-active">Faol</span>
                    @elseif($investor['status'] === 'Bloklangan')
                    <span class="status-blocked">Bloklangan</span>
                    @else
                    <span class="status-pending">Kutilmoqda</span>
                    @endif
                </td>
                <td>{{ $investor['created_at'] }}</td>
                <td class="text-center">
                    {{-- Show --}}
                    <x-show-button href="{{ route('admin.investors.show', $investor['id']) }}" />

                    {{-- Edit --}}
                    <x-edit-button href="{{ route('admin.investors.edit', $investor['id']) }}" />

                    {{-- STATUSLAR --}}
                    @if($investor['status'] === 'Faol')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="modal" data-bs-target="#blockModal"
                        data-investor-name="{{ $investor['name'] }}" data-form-action="#" title="Blo'klash">
                        <i class="fas fa-lock-open" style="font-size:18px; color:#007bff;"></i>
                    </button>

                    @elseif($investor['status'] === 'Kutilmoqda')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="tooltip" data-id="{{ $investor['id'] }}"
                        title="Kutulmoqda">
                        <i class="fas fa-lock-open disabled" style="font-size:18px; color: dimgrey"></i>
                    </button>

                    @elseif($investor['status'] === 'Bloklangan')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="modal" data-bs-target="#unblockModal"
                        data-investor-name="{{ $investor['name'] }}" data-form-action="#" title="Bloklangan">
                        <i class="fas fa-lock" style="font-size:18px; color:#bd2130;"></i>
                    </button>
                    @endif
                </td>


            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-4">
                    <div class="empty-state">
                        <i class="bi bi-person-x fs-1 text-muted"></i>
                        <p class="mt-2">Investorlar topilmadi</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>



    <div class="d-flex justify-content-between align-items-center mt-2">

        <div class="text-muted">
            {{ $start }} - {{ $end }} / Jami: {{ $total }}
        </div>

        <div>
            <x-pagination :pageCount="$pageCount" :currentPage="$currentPage" />
        </div>
    </div>

</div>
<!-- Bloklash modal -->
<div class="modal fade" id="blockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Investorni bloklash</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong id="blockInvestorName"></strong> investorini bloklashni istaysizmi?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Diqqat! Bloklangan investor tizimga kirishi va barcha huquqlardan mahrum bo‘ladi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <form id="blockForm" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Bloklash</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Blokdan chiqarish modal -->
<div class="modal fade" id="unblockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Investorni blokdan chiqarish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong id="unblockInvestorName"></strong> investorini blokdan chiqarishni istaysizmi?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Blokdan chiqarilgandan so'ng investor tizimga kirishi va huquqlari tiklanadi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <form id="unblockForm" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Blokdan chiqarish</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('customJs')
<script>
    // Block modal uchun
    var blockModal = document.getElementById('blockModal')
    blockModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var investorName = button.getAttribute('data-investor-name')
        var formAction = button.getAttribute('data-form-action')

        blockModal.querySelector('#blockInvestorName').textContent = investorName
        blockModal.querySelector('#blockForm').action = formAction
    })

    // Unblock modal uchun
    var unblockModal = document.getElementById('unblockModal')
    unblockModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var investorName = button.getAttribute('data-investor-name')
        var formAction = button.getAttribute('data-form-action')

        unblockModal.querySelector('#unblockInvestorName').textContent = investorName
        unblockModal.querySelector('#unblockForm').action = formAction
    })
</script>
@endpush