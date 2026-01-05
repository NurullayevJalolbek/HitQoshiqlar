@extends('layouts.app')

@push('customCss')
<style>

</style>
@endpush


@section('breadcrumb')
@php
$model = getSEOSettings();
@endphp
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
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
                    <a href="{{ route('admin.general-settings.index') }}">
                        Umumiy sozlamalar
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Xavfsizlik va xizmat ko'rsatish
                </li>




            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">

       <x-go-back url="{{ route('admin.general-settings.index') }}" />


        <!-- <a href="{{ route('admin.seo-settings.edit', 1) }}" class="btn btn-primary btn-sm px-3 py-1"
                style="min-width: 90px;">
                <i class="fa-jelly-duo fa-solid fa-pencil" style="font-size: 0.85rem;"></i> Tahrirlash
            </a> -->
    </div>



</div>
@endsection

@section('content')

@endsection

@push('customJs')
<script>
    //
</script>
@endpush