@extends('layouts.app')

@push('customCss')
<style>
    .label-verified {
        background-color: #1e7e34;
        color: #fff;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        margin-left: 5px;
    }

    .label-unverified {
        background-color: #f0bc74;
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

    /* Table cell padding */
    .table-cell {
        vertical-align: middle;
    }

    /* // */
    .btn-waiting {
        border: 1px solid #f0bc74;
        color: #f0bc74;
        background-color: transparent;
        transition: 0.3s;
    }

    .btn-waiting:hover {
        background-color: #f0bc74;
        color: #fff;
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
        <x-export-dropdown :items="['excel','csv']" :urls="[
                'excel' => '#',
                'csv'   => '#',
            ]" />

        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#investorFilterContent" aria-expanded="true"
            aria-controls="investorFilterContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
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


<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
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
            // Status ikonkalari (faqat 2 ta)
            $verificationIcon = '';
            if (strtolower(trim($investor['verification_status'])) === 'tasdiqlangan') {
            $verificationIcon = '<i class="bi bi-patch-check-fill status-active" title="Tasdiqlangan"></i>';
            } else {
            $verificationIcon = '<i class="bi bi-patch-exclamation-fill status-pending" title="Tasdiqlanmagan"></i>';
            }
            @endphp


            <tr>
                <td class="table-cell">{{ $investor['id'] }}</td>
                <td class="table-cell">
                    {{ $investor['name'] }}
                    {!! $verificationIcon !!}
                </td>
                <td class="table-cell">
                    {{ $investor['username'] }}
                </td>
                <td class="table-cell">
                    <i class="fas fa-phone me-2" style="color:#6c757d;"></i>
                    {{ $investor['phone'] }}
                </td>
                <td class="table-cell">
                    @if($investor['verification_status'] === 'Tasdiqlangan' && $investor['passport'])
                    <i class="fas fa-id-card me-2" style="color:#6c757d;"></i>
                    {{ $investor['passport'] }}
                    @else
                    -
                    @endif
                </td>

                <td class="table-cell">
                    @if($investor['verification_status'] === 'Tasdiqlangan' && $investor['inn'])
                    <i class="fas fa-fingerprint me-2" style="color:#6c757d;"></i>

                    <span id="innValue-{{ $investor['id'] }}">
                        {{ $investor['inn'] }}
                    </span>

                    <button class="btn btn-sm btn-link p-0 ms-2 copy-inn-btn"
                        data-inn="{{ $investor['inn'] }}"
                        title="Copy">
                        <i class="fa-regular fa-copy" style="font-size:16px;"></i>
                    </button>
                    @else
                    -
                    @endif
                </td>


                <td class="table-cell">
                    @if($investor['status'] === 'Faol')
                    <span class="btn btn-outline-success">
                        <i class="fas fa-check-circle me-1"></i> Faol
                    </span>
                    @elseif($investor['status'] === 'Bloklangan')
                    <span class="btn btn-outline-danger">
                        <i class="fas fa-ban me-1"></i> Bloklangan
                    </span>
                    @else
                    <span class="btn btn-waiting">
                        <i class="fas fa-clock me-1"></i> Kutilmoqda
                    </span>

                    @endif
                </td>
                <td>
                    <i class="fa-solid fa-calendar-days me-1" style="color:#6c757d;"></i>
                    {{ \Carbon\Carbon::parse($investor['created_at'])->format('H:i d.m.y') }}
                </td>
                <td class="text-center d-flex justify-content-center gap-1">
                    {{-- Show --}}
                    <x-show-button href="{{ route('admin.investors.show', $investor['id']) }}" />

                    {{-- Edit --}}
                    <x-edit-button href="{{ route('admin.investors.edit', $investor['id']) }}" />

                    {{-- STATUSLAR --}}
                    @if($investor['status'] === 'Faol')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="modal" data-bs-target="#blockModal"
                        data-investor-name="{{ $investor['name'] }}" data-form-action="#" title="Blo'klash">
                        <i class="fas fa-lock-open status-info" style="font-size:18px;"></i>
                    </button>

                    @elseif($investor['status'] === 'Kutilmoqda')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="tooltip" data-id="{{ $investor['id'] }}"
                        title="Kutulmoqda">
                        <i class="fas fa-lock-open disabled" style="font-size:18px; color: dimgrey"></i>
                    </button>

                    @elseif($investor['status'] === 'Bloklangan')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="modal" data-bs-target="#unblockModal"
                        data-investor-name="{{ $investor['name'] }}" data-form-action="#" title="Bloklangan">
                        <i class="fas fa-lock status-blocked" style="font-size:18px;"></i>
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
                    Diqqat! Bloklangan investor tizimga kirishi va barcha huquqlardan mahrum bo'ladi.
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
                    Blokdan chiqarilgandan song investor tizimga kirishi va huquqlari tiklanadi.
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
<script
    src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js"
    type="module"></script>

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


    // INN ni clipboard ga nusxalash
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.copy-inn-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const inn = this.getAttribute('data-inn');
                const icon = this.querySelector('i');

                // Clipboard ga nusxalash
                navigator.clipboard.writeText(inn).then(() => {

                    // Lottie elementini yaratish
                    const lottieEl = document.createElement('dotlottie-wc');
                    lottieEl.src = "https://lottie.host/4e693ea5-2094-4f50-85c4-c6f186fc997f/lPwg3ALEob.lottie";
                    lottieEl.style.width = "24px";
                    lottieEl.style.height = "24px";
                    lottieEl.style.color = "#10B981"; // Yashil rang
                    lottieEl.autoplay = true;

                    // Iconni Lottie bilan almashtirish
                    icon.replaceWith(lottieEl);

                    // 1.5 soniyadan keyin asl iconni qaytarish
                    setTimeout(() => {
                        lottieEl.replaceWith(icon);
                    }, 1700);
                });
            });
        });
    });
</script>
@endpush