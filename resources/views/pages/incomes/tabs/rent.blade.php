<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th width="50">#</th>
                <th>{{ __('Объект номи') }}</th>
                <th>{{ __('Ижарачи') }}</th>
                <th>{{ __('Телефон') }}</th>
                <th>{{ __('Ойлик тўлов') }}</th>
                <th>{{ __('Шартнома санаси') }}</th>
                <th>{{ __('Шартнома рақами') }}</th>
                <th>{{ __('Ҳолат') }}</th>
                <th>{{ __('Амаллар') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    <strong>Офис №12</strong><br>
                    <small class="text-muted">3-қават, 45м²</small>
                </td>
                <td>ООО "TechSoft"</td>
                <td><a href="tel:+998901234567">+998 90 123 45 67</a></td>
                <td class="fw-bold text-success">5,000,000 {{ __('сўм') }}</td>
                <td>15.01.2024</td>
                <td><code>№ 2024/45</code></td>
                <td>
                    <span class="badge bg-success">
                        <i class="fas fa-check"></i> {{ __('Тўланди') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info" title="{{ __('Ҳисобот') }}">
                        <i class="fas fa-file-invoice"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>
                    <strong>Савдо майдони №8</strong><br>
                    <small class="text-muted">1-қават, 120м²</small>
                </td>
                <td>ИП Karimov A.</td>
                <td><a href="tel:+998912345678">+998 91 234 56 78</a></td>
                <td class="fw-bold text-success">3,500,000 {{ __('сўм') }}</td>
                <td>22.02.2024</td>
                <td><code>№ 2024/67</code></td>
                <td>
                    <span class="badge bg-success">
                        <i class="fas fa-check"></i> {{ __('Тўланди') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info" title="{{ __('Ҳисобот') }}">
                        <i class="fas fa-file-invoice"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>
                    <strong>Офис №25</strong><br>
                    <small class="text-muted">5-қават, 65м²</small>
                </td>
                <td>ООО "Digital Agency"</td>
                <td><a href="tel:+998933456789">+998 93 345 67 89</a></td>
                <td class="fw-bold text-warning">4,000,000 {{ __('сўм') }}</td>
                <td>10.03.2024</td>
                <td><code>№ 2024/89</code></td>
                <td>
                    <span class="badge bg-warning">
                        <i class="fas fa-clock"></i> {{ __('Кутилмоқда') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info" title="{{ __('Ҳисобот') }}">
                        <i class="fas fa-file-invoice"></i>
                    </button>
                </td>
            </tr>
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th colspan="4" class="text-end">{{ __('Жами ижара даромади:') }}</th>
                <th class="text-primary fs-5">12,500,000 {{ __('сўм') }}</th>
                <th colspan="4"></th>
            </tr>
        </tfoot>
    </table>
</div>

{{-- Summary Cards --}}
<div class="row mt-3">
    <div class="col-md-4">
        <div class="card border-start border-success border-3">
            <div class="card-body">
                <div class="small text-muted">{{ __('Тўланган') }}</div>
                <div class="h5 mb-0">2 {{ __('та объект') }}</div>
                <div class="small text-success">8,500,000 {{ __('сўм') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-start border-warning border-3">
            <div class="card-body">
                <div class="small text-muted">{{ __('Кутилмоқда') }}</div>
                <div class="h5 mb-0">1 {{ __('та объект') }}</div>
                <div class="small text-warning">4,000,000 {{ __('сўм') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-start border-primary border-3">
            <div class="card-body">
                <div class="small text-muted">{{ __('Ўртача тўлов') }}</div>
                <div class="h5 mb-0">4,167,000 {{ __('сўм') }}</div>
                <div class="small text-muted">{{ __('объект учун') }}</div>
            </div>
        </div>
    </div>
</div>