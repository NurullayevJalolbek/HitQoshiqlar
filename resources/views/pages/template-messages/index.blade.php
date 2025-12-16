@extends('layouts.app')

@push('customCss')
<style>
    .nav-tabs .nav-link {
        border: 1px solid #dee2e6;
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: 0.2s;
    }

    .nav-tabs .nav-link:hover {
        background-color: #e9f2ff;
    }

    .nav-tabs .nav-link.active {
        background-color: #1F2937;
        /* active tab rangi */
        color: #ffffff !important;
        /* matn va icon oq rangda bo'lishi uchun */
        font-weight: 600;
        /* qalin yozuv */
    }

    /* icon rangini ham oq qilish (agar font-awesome ishlatilsa) */
    .nav-tabs .nav-link.active i {
        color: #ffffff;
    }


    .tab-content {
        border: 1px solid #dee2e6;
        border-radius: 0 0 0.5rem 0.5rem;
        padding: 1rem;
        background-color: #fff;
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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.user-interface.index') }}">
                        {{ __('admin.user_interface') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Shablon Xabarlar
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection



@section('content')

@php
$datas = getNotificationsData();


@endphp
<div class="card card-body shadow-sm mb-4 mt-3">


    <!-- Tabs -->
    <div class="collapse show" id="messageTabsContent">
        <ul class="nav nav-tabs mb-3" id="messageTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-primary fw-semibold" id="sms-tab" data-bs-toggle="tab"
                    data-bs-target="#sms"
                    type="button" role="tab">
                    <i class="fas fa-sms me-1"></i> SMS
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-primary fw-semibold" id="email-tab" data-bs-toggle="tab"
                    data-bs-target="#email" type="button"
                    role="tab">
                    <i class="fas fa-envelope me-1"></i> Email
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-primary fw-semibold" id="push-tab" data-bs-toggle="tab"
                    data-bs-target="#push" type="button"
                    role="tab">
                    <i class="fas fa-bell me-1"></i> Push
                </button>
            </li>

        </ul>


        <!-- Tab Content -->
        <div class="tab-content">

            <!-- SMS Tab -->
            <div class="tab-pane fade show active" id="sms" role="tabpanel">

                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-sm text-white" style="background-color: #1F2937; border: none;">
                        <i class="fas fa-plus me-1"></i> Yaratish
                    </button>
                </div>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>SMS turi</th>
                            <th>SMS shablon</th>
                            <th>Yuborilishi sharti</th>
                            <th>Izoh</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($datas->where('category', 'sms') as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td style="white-space: normal; max-width: 350px;">
                                {{ $item['template'] }}
                            </td>
                            <td>{{ $item['condition'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td class="text-center  justify-content-center gap-1">
                                <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($datas->where('category','sms')->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">SMS shablonlar yo‘q</td>
                        </tr>
                        @endif
                    </tbody>

                </table>
            </div>

            <!-- Email Tab -->
            <div class="tab-pane fade" id="email" role="tabpanel">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-sm text-white" style="background-color: #1F2937; border: none;">
                        <i class="fas fa-plus me-1"></i> Yaratish
                    </button>
                </div>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Email turi</th>
                            <th>Email shablon</th>
                            <th>Yuborilishi sharti</th>
                            <th>Izoh</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($datas->where('category', 'email') as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td style="white-space: normal; max-width: 350px;">
                                {!! nl2br(e($item['template'])) !!}
                            </td>
                            <td>{{ $item['condition'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td class="text-center  justify-content-center gap-1">
                                <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($datas->where('category','email')->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">Email shablonlar yo‘q</td>
                        </tr>
                        @endif
                    </tbody>

                </table>

            </div>

            <!-- Push Tab -->
            <div class="tab-pane fade" id="push" role="tabpanel">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-sm text-white" style="background-color: #1F2937; border: none;">
                        <i class="fas fa-plus me-1"></i> Yaratish
                    </button>
                </div>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Push turi</th>
                            <th>Push shablon</th>
                            <th>Yuborilishi sharti</th>
                            <th>Izoh</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($datas->where('category', 'push') as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td style="white-space: normal; max-width: 350px;">
                                {{ $item['template'] }}
                            </td>
                            <td>{{ $item['condition'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td class="text-center  justify-content-center gap-1">
                                <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($datas->where('category','push')->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">Push shablonlar yo‘q</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    // JS Ko'dlar'
</script>
@endpush