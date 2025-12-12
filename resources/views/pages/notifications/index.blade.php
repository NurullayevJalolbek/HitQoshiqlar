@extends('layouts.app')

@push('customCss')
    <style>
        /* Jadval HEAD dizayni */
        thead.table-dark {
            background-color: #2c3e50 !important;
        }

        thead.table-dark th input[type="checkbox"] {
            accent-color: #ffffff; /* Oq checkbox */
        }

        /* O'qilmagan xabar */
        .row-unread {
            background-color: #eef6ff !important;
            font-weight: 600;
            color: #2c3e50;
        }

        /* O'qilgan xabar */
        .row-read {
            background-color: #ffffff !important;
            color: #6c757d;
        }

        /* Turlar uchun ranglar */
        .badge-type {
            font-size: 0.85rem;
            padding: 6px 10px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .bg-technical {
            background-color: #e7f1ff;
            color: #0d6efd;
            border: 1px solid #b6d4fe;
        }

        .bg-request {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .bg-error {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        /* Holat nishonlari */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-unread-badge {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .status-read-badge {
            background: #e9f7ef;
            color: #198754;
        }
    </style>
@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.notifications') }}</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#notificationFilterContent" aria-expanded="true"
                    aria-controls="notificationFilterContent">
                <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    @php
        $notifications = getNotifications();
        $unreadCount = $notifications->where('status', 'unread')->count();
    @endphp

    {{-- FILTER PANEL --}}
    @include('pages.notifications._filter')

    {{-- TABLE --}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th style="width: 40px;">
                    <input type="checkbox" class="form-check-input" id="checkAll">
                </th>
                <th>Vaqt</th>
                <th>Turi</th>
                <th>Xabar Matni</th>
                <th class="text-center">Holati</th>
            </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    @php
                        $rowClass = $notification['status'] === 'unread' ? 'row-unread' : 'row-read';
                        
                        // Turi uchun konfiguratsiya
                        $typeConfig = match($notification['type']) {
                            'technical' => ['class' => 'bg-technical', 'icon' => '<i class="fas fa-server"></i>', 'label' => 'Texnik'],
                            'request' => ['class' => 'bg-request', 'icon' => '<i class="fas fa-user-edit"></i>', 'label' => 'So\'rov'],
                            'error' => ['class' => 'bg-error', 'icon' => '<i class="fas fa-exclamation-triangle"></i>', 'label' => 'Xato'],
                            default => ['class' => 'bg-light', 'icon' => '<i class="fas fa-info-circle"></i>', 'label' => 'Info'],
                        };
                    @endphp
                    
                    <tr class="{{ $rowClass }}" data-id="{{ $notification['id'] }}" data-status="{{ $notification['status'] }}">
                        <td>
                            <input type="checkbox" 
                                   class="form-check-input notif-checkbox"
                                   data-id="{{ $notification['id'] }}"
                                   {{ $notification['status'] === 'read' ? 'checked' : '' }}>
                        </td>
                        
                        <td>
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>
                                {{ $notification['date'] }}
                            </small>
                        </td>
                        
                        <td>
                            <span class="badge-type {{ $typeConfig['class'] }}">
                                {!! $typeConfig['icon'] !!} {{ $typeConfig['label'] }}
                            </span>
                        </td>
                        
                        <td>{{ $notification['text'] }}</td>
                        
                        <td class="text-center">
                            @if($notification['status'] === 'unread')
                                <span class="status-badge status-unread-badge">
                                    <i class="bi bi-envelope-arrow-down-fill me-1"></i>
                                    O'qilmagan
                                </span>
                            @else
                                <span class="status-badge status-read-badge">
                                    <i class="bi bi-envelope-open me-1"></i>
                                    O'qilgan
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-bell-slash me-2"></i>
                            Hech qanday bildirishnoma mavjud emas
                        </td>
                    </tr>
                @endforelse
            </tbody>
<!--             
            @if($unreadCount > 0)
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end text-muted small">
                            <i class="fas fa-envelope me-1"></i>
                            Jami: {{ $notifications->count() }} ta | 
                            <i class="fas fa-envelope-open-text me-1"></i>
                            O'qilgan: {{ $notifications->count() - $unreadCount }} ta |
                            <i class="fas fa-envelope me-1 text-primary"></i>
                            O'qilmagan: <span class="fw-bold text-primary">{{ $unreadCount }}</span> ta
                        </td>
                    </tr>
                </tfoot>
            @endif -->
        </table>
    </div>

@endsection

@push('customJs')
<script>
    // JavaScript faqat checkboxlar bilan ishlash uchun
    
    document.addEventListener('DOMContentLoaded', function() {
        // "Barchasini tanlash" checkbox
        const checkAll = document.getElementById('checkAll');
        if (checkAll) {
            checkAll.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.notif-checkbox');
                const isChecked = this.checked;
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                    
                    // UI ni yangilash
                    const row = checkbox.closest('tr');
                    if (row) {
                        if (isChecked) {
                            row.classList.remove('row-unread');
                            row.classList.add('row-read');
                            row.dataset.status = 'read';
                            
                            // Status badge ni yangilash
                            const statusCell = row.querySelector('td.text-center');
                            if (statusCell) {
                                statusCell.innerHTML = `
                                    <span class="status-badge status-read-badge">
                                        <i class="bi bi-envelope-open me-1"></i>
                                        O'qilgan
                                    </span>
                                `;
                            }
                        } else {
                            row.classList.remove('row-read');
                            row.classList.add('row-unread');
                            row.dataset.status = 'unread';
                            
                            // Status badge ni yangilash
                            const statusCell = row.querySelector('td.text-center');
                            if (statusCell) {
                                statusCell.innerHTML = `
                                    <span class="status-badge status-unread-badge">
                                        <i class="bi bi-envelope-arrow-down-fill me-1"></i>
                                        O'qilmagan
                                    </span>
                                `;
                            }
                        }
                    }
                });
                
                // O'qilmaganlar sonini yangilash
                updateUnreadCount();
            });
        }
        
        // Har bir checkbox uchun event
        document.querySelectorAll('.notif-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                if (row) {
                    if (this.checked) {
                        row.classList.remove('row-unread');
                        row.classList.add('row-read');
                        row.dataset.status = 'read';
                        
                        // Status badge ni yangilash
                        const statusCell = row.querySelector('td.text-center');
                        if (statusCell) {
                            statusCell.innerHTML = `
                                <span class="status-badge status-read-badge">
                                    <i class="bi bi-envelope-open me-1"></i>
                                    O'qilgan
                                </span>
                            `;
                        }
                    } else {
                        row.classList.remove('row-read');
                        row.classList.add('row-unread');
                        row.dataset.status = 'unread';
                        
                        // Status badge ni yangilash
                        const statusCell = row.querySelector('td.text-center');
                        if (statusCell) {
                            statusCell.innerHTML = `
                                <span class="status-badge status-unread-badge">
                                    <i class="bi bi-envelope-arrow-down-fill me-1"></i>
                                    O'qilmagan
                                </span>
                            `;
                        }
                        
                        // Agar barchasi tanlangan bo'lsa, checkAll ni olib tashlash
                        checkAll.checked = false;
                    }
                }
                
                // O'qilmaganlar sonini yangilash
                updateUnreadCount();
            });
        });
        
        // O'qilmaganlar sonini yangilash funksiyasi
        function updateUnreadCount() {
            const unreadRows = document.querySelectorAll('tr[data-status="unread"]');
            const unreadCount = unreadRows.length;
            
            // Footer yoki boshqa joyda ko'rsatish
            const footer = document.querySelector('tfoot');
            if (footer) {
                const totalCount = document.querySelectorAll('tbody tr').length - 1; // Bo'sh qatorni hisoblamaslik
                const readCount = totalCount - unreadCount;
                
                footer.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-end text-muted small">
                            <i class="fas fa-envelope me-1"></i>
                            Jami: ${totalCount} ta | 
                            <i class="fas fa-envelope-open-text me-1"></i>
                            O'qilgan: ${readCount} ta |
                            <i class="fas fa-envelope me-1 text-primary"></i>
                            O'qilmagan: <span class="fw-bold text-primary">${unreadCount}</span> ta
                        </td>
                    </tr>
                `;
            }
        }
        
        // Dastlabki o'qilmaganlar sonini hisoblash
        updateUnreadCount();
    });
</script>
@endpush