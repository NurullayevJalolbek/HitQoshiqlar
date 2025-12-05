@extends('layouts.app')

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.projects.index') }}">
                            {{ __('admin.projects') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Loyihani Tahrirlash
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    @include('admin.projects._form', [
        'project' => $project,
        'action' => route('admin.projects.update', $project->id),
        '_method' => 'PUT',
        'submitText' => 'O\'zgarishlarni Saqlash',
        'pageTitle' => 'Loyihani Tahrirlash: ' . $project->name
    ])
@endsection