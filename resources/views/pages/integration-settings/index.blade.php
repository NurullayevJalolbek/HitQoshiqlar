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
                    <li class="breadcrumb-item active" aria-current="page">Integratsiya sozlamalari</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    @php
        $integrations = [
            [
                'name'  => 'SMS Xizmati (PlayMobile)',
                'status' => true,
            ],
            [
                'name'  => 'Payme To‘lov Tizimi',
                'status' => false,
            ],
            [
                'name'  => 'Click To‘lov Tizimi',
                'status' => true,
            ],
            [
                'name'  => 'Visa Online Payments',
                'status' => false,
            ],
            [
                'name'  => 'Mastercard Online Payments',
                'status' => false,
            ],
            [
                'name'  => 'Email SMTP (Gmail)',
                'status' => true,
            ],
            [
                'name'  => 'Firebase Push Notification',
                'status' => false,
            ],
            [
                'name'  => 'Google Maps API',
                'status' => true,
            ],
            [
                'name'  => 'Google Analytics',
                'status' => true,
            ],
        ];
    @endphp

    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">

        {{--        <h5 class="mb-3"><i class="fas fa-plug me-2"></i> Integratsiya sozlamalari</h5>--}}

        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th style="width: 60px;">№</th>
                <th class="text-center">Nomi</th>
                <th>Holati</th>
                <th class="text-center" style="width: 150px;">Amallar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($integrations as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>

                    <td class="text-center">{{ $item['name'] }}</td>

                    <td>
                        @if($item['status'])
                            <span class="status-active">Faol</span>
                        @else
                            <span class="status-blocked">Nofaol</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;"><i
                                class="bi bi-pencil-fill"></i></a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@push('customJs')
    <script>
        // JS Ko'dlar'
    </script>
@endpush
