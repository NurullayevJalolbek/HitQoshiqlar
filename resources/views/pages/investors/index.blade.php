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
                            <x-show-button href="{{ route('admin.investors.show', $investor['id']) }}" />

                            <x-edit-button href="{{ route('admin.investors.edit', $investor['id']) }}" />

                            <button class="btn btn-link p-0 verify-btn" data-id="{{ $investor['id'] }}" title="Tasdiqlash"
                                @if($investor['verification_status'] === 'Tasdiqlangan') disabled @endif>
                                <img src="{{ asset('assets/img/icons/shield_icon.png') }}" class="status-pending-icon"
                                    style="filter: brightness(0) saturate(100%) invert(39%) sepia(94%) saturate(3390%) hue-rotate(199deg) brightness(93%) contrast(101%);">
                            </button>
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

@endsection




@push('customJs')
    <script>
        //
    </script>
@endpush