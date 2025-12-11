@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
     style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.investors.index') }}">{{ __('admin.project_investors') }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $label }}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="card card-body border-0 shadow mb-4 mt-2">
    <form id="investor-form">

        <!-- Asosiy ma'lumotlar -->
        <h6 class="mb-3 fw-bold">Asosiy ma'lumotlar</h6>
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label>Korxona to'liq nomi <span class="text-danger">*</span></label>
                <input type="text" id="company_name" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label>INN <span class="text-danger">*</span></label>
                <input type="text" id="inn" class="form-control" required maxlength="9">
            </div>

            <div class="col-md-3 mb-3">
                <label>IFUT kodi <span class="text-danger">*</span></label>
                <input type="text" id="ifut" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Faoliyat turi <span class="text-danger">*</span></label>
                <select id="activity_type" class="form-control" required onchange="togglePersonalFields()">
                    <option value="">Tanlang</option>
                    <option value="MChJ">MChJ</option>
                    <option value="AJ">AJ</option>
                    <option value="YaTT">YaTT</option>
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label>Manzil <span class="text-danger">*</span></label>
                <input type="text" id="address" class="form-control" required>
            </div>
        </div>

        <!-- Direktor va kontakt -->
        <h6 class="mb-3 fw-bold">Direktor va kontakt ma'lumotlari</h6>
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label>Direktor F.I.O <span class="text-danger">*</span></label>
                <input type="text" id="director_fio" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Login <span class="text-danger">*</span></label>
                <input type="text" id="login" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Telefon <span class="text-danger">*</span></label>
                <input type="text" id="phone" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" id="email" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Akaunt holati</label>
                <select id="status" class="form-control">
                    <option value="active">Faol</option>
                    <option value="blocked">Bloklangan</option>
                </select>
            </div>
        </div>

        <!-- Shaxsiy ma'lumotlar (YaTT uchun) -->
        <div id="personal-fields" style="display: none;">
            <h6 class="mb-3 fw-bold">Shaxsiy ma'lumotlar (YaTT)</h6>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label id="passport-label">Pasport</label>
                    <input type="text" id="passport" class="form-control" maxlength="9">
                </div>

                <div class="col-md-6 mb-3">
                    <label id="jshshir-label">JSHSHIR</label>
                    <input type="text" id="jshshir" class="form-control" maxlength="14">
                </div>
            </div>
        </div>

        <!-- Ro'yxatdan o'tish -->
        <h6 class="mb-3 fw-bold">Ro'yxatdan o'tish ma'lumotlari</h6>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label>Ro'yxatdan o'tgan sana</label>
                <input type="date" id="registered_at" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Ro'yxatdan o'tkazish raqami</label>
                <input type="text" id="registration_number" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Investorlik holati sanasi</label>
                <input type="date" id="investor_status_date" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label>Ro'yxatdan o'tkazuvchi tashkilot</label>
                <input type="text" id="registration_org" class="form-control">
            </div>
        </div>

        <!-- Investitsiya -->
        <h6 class="mb-3 fw-bold">Investitsiya ma'lumotlari</h6>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label>Sertifikat fayli</label>
                <input type="file" id="certificate_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <div class="col-md-4 mb-3">
                <label>Ulush (summa) <span class="text-danger">*</span></label>
                <input type="number" id="share_amount" class="form-control" required min="0">
            </div>

            <div class="col-md-4 mb-3">
                <label>Ulush (foiz) <span class="text-danger">*</span></label>
                <input type="number" id="share_percent" class="form-control" required min="0" max="100" step="0.01">
            </div>
        </div>

        <!-- Tugmalar -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ $back_route }}" class="btn btn-gray-800">{{ __('admin.Back') }}</a>
            <button type="submit" class="btn btn-success text-white">{{ __('admin.save') }}</button>
        </div>

    </form>
</div>
@endsection

@push('customJs')
<script>
    function togglePersonalFields() {
        const activityType = document.getElementById('activity_type').value;
        const personalFields = document.getElementById('personal-fields');
        const passportInput = document.getElementById('passport');
        const jshshirInput = document.getElementById('jshshir');
        const passportLabel = document.getElementById('passport-label');
        const jshshirLabel = document.getElementById('jshshir-label');
        
        if (activityType === 'YaTT') {
            personalFields.style.display = 'block';
            passportInput.required = true;
            jshshirInput.required = true;
            passportLabel.innerHTML = 'Pasport <span class="text-danger">*</span>';
            jshshirLabel.innerHTML = 'JSHSHIR <span class="text-danger">*</span>';
        } else {
            personalFields.style.display = 'none';
            passportInput.required = false;
            jshshirInput.required = false;
            passportInput.value = '';
            jshshirInput.value = '';
            passportLabel.innerHTML = 'Pasport';
            jshshirLabel.innerHTML = 'JSHSHIR';
        }
    }

    document.getElementById('investor-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const pathParts = window.location.pathname.split('/');
        const editId = pathParts.includes('edit') ? pathParts[pathParts.length - 2] : null;

        const formData = {
            id: editId ? parseInt(editId) : Date.now(),
            company_name: document.getElementById('company_name').value.trim(),
            inn: document.getElementById('inn').value.trim(),
            ifut: document.getElementById('ifut').value.trim(),
            activity_type: document.getElementById('activity_type').value,
            address: document.getElementById('address').value.trim(),
            director_fio: document.getElementById('director_fio').value.trim(),
            login: document.getElementById('login').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            email: document.getElementById('email').value.trim(),
            passport: document.getElementById('passport').value.trim(),
            jshshir: document.getElementById('jshshir').value.trim(),
            status: document.getElementById('status').value,
            registered_at: document.getElementById('registered_at').value,
            registration_number: document.getElementById('registration_number').value.trim(),
            registration_org: document.getElementById('registration_org').value.trim(),
            investor_status_date: document.getElementById('investor_status_date').value,
            certificate_file: document.getElementById('certificate_file').files[0]?.name || '',
            share_amount: parseFloat(document.getElementById('share_amount').value) || 0,
            share_percent: parseFloat(document.getElementById('share_percent').value) || 0
        };

        let investors = JSON.parse(localStorage.getItem('project_investors') || '[]');
        
        if (editId) {
            const index = investors.findIndex(i => i.id == editId);
            if (index !== -1) {
                investors[index] = formData;
            }
        } else {
            investors.push(formData);
        }

        localStorage.setItem('project_investors', JSON.stringify(investors));
        alert('Ma\'lumotlar saqlandi!');
        window.location.href = "{{ route('admin.investors.index') }}";
    });

    window.addEventListener('DOMContentLoaded', function() {
        const pathParts = window.location.pathname.split('/');
        const editId = pathParts.includes('edit') ? pathParts[pathParts.length - 2] : null;
        
        if (editId) {
            const investors = JSON.parse(localStorage.getItem('project_investors') || '[]');
            const investor = investors.find(i => i.id == editId);
            
            if (investor) {
                document.getElementById('company_name').value = investor.company_name;
                document.getElementById('inn').value = investor.inn;
                document.getElementById('ifut').value = investor.ifut;
                document.getElementById('activity_type').value = investor.activity_type;
                document.getElementById('address').value = investor.address;
                document.getElementById('director_fio').value = investor.director_fio;
                document.getElementById('login').value = investor.login;
                document.getElementById('phone').value = investor.phone;
                document.getElementById('email').value = investor.email;
                document.getElementById('passport').value = investor.passport || '';
                document.getElementById('jshshir').value = investor.jshshir || '';
                document.getElementById('status').value = investor.status;
                document.getElementById('registered_at').value = investor.registered_at;
                document.getElementById('registration_number').value = investor.registration_number || '';
                document.getElementById('registration_org').value = investor.registration_org || '';
                document.getElementById('investor_status_date').value = investor.investor_status_date || '';
                document.getElementById('share_amount').value = investor.share_amount;
                document.getElementById('share_percent').value = investor.share_percent;
                
                togglePersonalFields();
            }
        }
    });
</script>
@endpush