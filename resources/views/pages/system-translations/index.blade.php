@extends('layouts.app')

@push('customCss')
<style>
    .system-translation-badge {
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
    .system-translation-badge {
        background: rgba(35, 97, 206, 0.08);
        color: #2361ce;
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
                    Tillarni boshqarish
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">

        <!-- Filter toggle -->
        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#systemTranslationFilterContent" aria-expanded="true"
            aria-controls="systemTranslationFilterContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')

@include('pages.system-translations._filter')
@php
$pagination = manualPaginate($baseKeys, 20);

$systemTranslations = $pagination['items'];

$currentPage = $pagination['currentPage'];
$pageCount = $pagination['pageCount'];

$start = $pagination['start'];
$total = $pagination['total'];
$end = $pagination['end'];
@endphp


<div class="card card-body shadow-sm mb-4 mt-3">
    <!-- Sarlavha va toggle tugma -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="section-title d-flex align-items-center">
            <i class="fas fa-globe me-1"></i> Interfeys matnlarini tarjima qilish
        </div>
    </div>


    <!-- Jadval collapse ichida -->


    <div class="collapse show" id="interfaceTextTableContent">
        <table class="table user-table table-bordered table-hover table-striped align-items-center"
            id="interfaceTable">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" width="5%">№</th>
                    <th>Kalit sozi</th>
                    <th class="text-center">UZ</th>
                    <th class="text-center">RU</th>
                    <th class="text-center">EN</th>
                    <th class="text-center">AR</th>
                    <th class="text-center">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($systemTranslations as $index => $key)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <span class="system-translation-badge">
                            {{ $key }}
                        </span>
                    </td>
                    <td class="text-center">{!! renderValue($data['uz'][$key] ?? '') !!}</td>
                    <td class="text-center">{!! renderValue($data['ru'][$key] ?? '') !!}</td>
                    <td class="text-center">{!! renderValue($data['en'][$key] ?? '') !!}</td>
                    <td class="text-center">{!! renderValue($data['ar'][$key] ?? '') !!}</td>

                    <td class="text-center  justify-content-center gap-1">

                        <a href="#"
                            class="btn btn-sm p-0 edit-translation"
                            data-key="{{ $key }}"
                            style="background:none; color: #f0bc74;">
                            <i class="fa-jelly-duo fa-solid fa-pencil"></i>
                        </a>


                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginatsa -->
        <div class="d-flex justify-content-between align-items-center mt-2">

            <div class="text-muted">
                {{ $start }} - {{ $end }} / Jami: {{ $total }}
            </div>

            <div>
                <x-pagination :pageCount="$pageCount" :currentPage="$currentPage" />
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="systemTranslationModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tizim tillari boshqarish </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="systemTranslationModalBody">
                <div class="text-center text-muted">
                    Yuklanmoqda...
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('customJs')
<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-translation');
        if (!btn) return;

        e.preventDefault();
        const key = btn.dataset.key;

        const url = "{{ route('admin.user-interface.system-translations.edit', ':id') }}"
            .replace(':id', key);


        // JSON olish
        axios.get(url, {
                params: {
                    key
                }
            })
            .then(res => {
                const data = res.data;
                const modalBody = document.getElementById('systemTranslationModalBody');

                // Modalni tozalash
                modalBody.innerHTML = '';

                // Form yaratish
                const form = document.createElement('form');
                form.id = 'translationEditForm';

                // CSRF input
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                // KEY input (readonly)
                const keyDiv = document.createElement('div');
                keyDiv.className = 'mb-3';
                const keyLabel = document.createElement('label');
                keyLabel.className = 'form-label fw-semibold';
                keyLabel.textContent = 'Kalit (o‘zgartirib bo‘lmaydi)';
                const keyInput = document.createElement('input');
                keyInput.type = 'text';
                keyInput.className = 'form-control';
                keyInput.name = 'key';
                keyInput.value = data.key;
                keyInput.readOnly = true;
                keyDiv.appendChild(keyLabel);
                keyDiv.appendChild(keyInput);
                form.appendChild(keyDiv);

                // Har bir til uchun oddiy input
                data.languages.forEach(lang => {
                    const langDiv = document.createElement('div');
                    langDiv.className = 'mb-3';

                    const langLabel = document.createElement('label');
                    langLabel.className = 'form-label fw-semibold';
                    langLabel.textContent = lang.name + ` (${lang.url.toUpperCase()})`;

                    const input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'form-control';
                    input.name = `translations[${lang.url}]`;
                    input.value = data.translations[lang.url] || '';

                    langDiv.appendChild(langLabel);
                    langDiv.appendChild(input);
                    form.appendChild(langDiv);
                });


                // Footer (buttons)
                const footerDiv = document.createElement('div');
                footerDiv.className = 'd-flex justify-content-end gap-2 mt-4';
                const closeBtn = document.createElement('button');
                closeBtn.type = 'button';
                closeBtn.className = 'btn btn-secondary';
                closeBtn.setAttribute('data-bs-dismiss', 'modal');
                closeBtn.textContent = 'Yopish';
                const saveBtn = document.createElement('button');
                saveBtn.type = 'submit';
                saveBtn.className = 'btn btn-primary';
                saveBtn.textContent = 'Saqlash';
                footerDiv.appendChild(closeBtn);
                footerDiv.appendChild(saveBtn);

                form.appendChild(footerDiv);
                modalBody.appendChild(form);

                // Modalni ko‘rsatish
                const modal = new bootstrap.Modal(document.getElementById('systemTranslationModal'));
                modal.show();
            })
            .catch(err => {
                console.error(err);
                alert('Xatolik yuz berdi!');
            });
    });
</script>

@endpush