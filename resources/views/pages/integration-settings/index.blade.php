@extends('layouts.app')

@push('customCss')
<style>
    .integration-status-active,
    .integration-status-blocked,
    .integration-status-pending {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Yashil – Faol */
    .integration-status-active {
        background: rgba(0, 200, 83, 0.15);
        color: #0f9d58;
    }

    /* Qizil – Block */
    .integration-status-blocked {
        background: rgba(255, 0, 0, 0.15);
        color: #d93025;
    }

    /* Sariq – Pending */
    .integration-status-pending {
        background: rgba(255, 193, 7, 0.15);
        color: #c99a00;
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
$datas = getIntegrationSettings();

@endphp

<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">

    {{-- <h5 class="mb-3"><i class="fas fa-plug me-2"></i> Integratsiya sozlamalari</h5>--}}

    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th class="text-center" style="width: 5%;">№</th>
                <th class="text-center">Nomi</th>
                <th class="text-center">Holati</th>
                <th class="text-center" style="width: 150px;">Amallar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $key => $item)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>

                <td class="text-center">{{ $item['name'] }}</td>

                <!-- <td class="text-center">
                    @if($item['status'])
                    <span class="status-active">Faol</span>
                    @else
                    <span class="status-blocked">Nofaol</span>
                    @endif
                </td> -->

                <td>
                    @php
                    $cls = $item['status'] ? 'integration-status-active' : 'integration-status-blocked';
                    $icon = $item['status'] ? 'fas fa-check-circle me-1' : 'fas fa-ban me-1';
                    $text = $item['status'] ? 'Faol' : 'Nofaol';
                    @endphp

                    <span class="{{ $cls }}">
                        <i class="{{ $icon }}"></i>
                        {{ $text }}
                    </span>


                </td>

                <td class="text-center">
                    <a href="{{ route('admin.integration-settings.edit', [$item['id'],  'go_back' => url()->full()]) }}" class="btn btn-sm p-1" style="background:none;color:#f0bc74;"><i
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