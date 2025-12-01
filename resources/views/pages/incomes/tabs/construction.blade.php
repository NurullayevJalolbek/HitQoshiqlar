<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th width="50">#</th>
                <th>{{ __('Квартира маълумоти') }}</th>
                <th>{{ __('Харидор') }}</th>
                <th>{{ __('Телефон') }}</th>
                <th>{{ __('Сотув суммаси') }}</th>
                <th>{{ __('Тўлов режаси') }}</th>
                <th>{{ __('Шартнома') }}</th>
                <th>{{ __('Ҳолат') }}</th>
                <th>{{ __('Амаллар') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    <strong>2-хонали квартира</strong><br>
                    <small class="text-muted">
                        <i class="fas fa-home"></i> 65м² • 12-қават • А-блок
                    </small>
                </td>
                <td>Rahimov Bekzod</td>
                <td><a href="tel:+998901112233">+998 90 111 22 33</a></td>
                <td class="fw-bold text-success">45,000,000 {{ __('сўм') }}</td>
                <td>
                    <span class="badge bg-info">
                        <i class="fas fa-money-bill"></i> {{ __('Бир марталик') }}
                    </span>
                </td>
                <td><code>№ QB-2024/101</code></td>
                <td>
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> {{ __('Тўланди') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success" title="{{ __('Шартнома') }}">
                        <i class="fas fa-file-contract"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>
                    <strong>1-хонали квартира</strong><br>
                    <small class="text-muted">
                        <i class="fas fa-home"></i> 42м² • 8-қават • Б-блок
                    </small>
                </td>
                <td>Toshmatova Malika</td>
                <td><a href="tel:+998912223344">+998 91 222 33 44</a></td>
                <td class="fw-bold text-warning">28,000,000 {{ __('сўм') }}</td>
                <td>
                    <span class="badge bg-warning">
                        <i class="fas fa-calendar-alt"></i> {{ __('12 ой') }}
                    </span>
                </td>
                <td><code>№ QB-2024/125</code></td>
                <td>
                    <span class="badge bg-warning">
                        <i class="fas fa-hourglass-half"></i> {{ __('Кутилмоқда') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success" title="{{ __('Шартнома') }}">
                        <i class="fas fa-file-contract"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>
                    <strong>3-хонали квартира</strong><br>
                    <small class="text-muted">
                        <i class="fas fa-home"></i> 95м² • 15-қават • А-блок
                    </small>
                </td>
                <td>Ergashev Aziz</td>
                <td><a href="tel:+998933445566">+998 93 344 55 66</a></td>
                <td class="fw-bold text-success">62,000,000 {{ __('сўм') }}</td>
                <td>
                    <span class="badge bg-primary">
                        <i class="fas fa-calendar-alt"></i> {{ __('24 ой') }}
                    </span>
                </td>
                <td><code>№ QB-2024/145</code></td>
                <td>
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> {{ __('Тўланди') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success" title="{{ __('Шартнома') }}">
                        <i class="fas fa-file-contract"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td>
                    <strong>2-хонали квартира</strong><br>
                    <small class="text-muted">
                        <i class="fas fa-home"></i> 58м² • 6-қават • В-блок
                    </small>
                </td>
                <td>Xolmatov Sardor</td>
                <td><a href="tel:+998945556677">+998 94 555 66 77</a></td>
                <td class="fw-bold text-danger">35,000,000 {{ __('сўм') }}</td>
                <td>
                    <span class="badge bg-warning">
                        <i class="fas fa-calendar-alt"></i> {{ __('18 ой') }}
                    </span>
                </td>
                <td><code>№ QB-2024/167</code></td>
                <td>
                    <span class="badge bg-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ __('Муддати ўтган') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" title="{{ __('Эслатма') }}">
                        <i class="fas fa-bell"></i>
                    </button>
                </td>
            </tr>
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th colspan="4" class="text-end">{{ __('Жами қурилиш сотувлари:') }}</th>
                <th class="text-primary fs-5">170,000,000 {{ __('сўм') }}</th>
                <th colspan="4"></th>
            </tr>
        </tfoot>
    </table>
</div>

{{-- Progress Cards --}}
<div class="row mt-3">
    <div class="col-md-3">
        <div class="card border-start border-success border-3">
            <div class="card-body">
                <div class="small text-muted">{{ __('Тўланган') }}</div>
                <div class="h5 mb-0">2 {{ __('та квартира') }}</div>
                <div class="small text-success">107,000,000 {{ __('сўм') }}</div>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar bg-success" style="width: 63%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-warning border-3">
            <div class="card-body">
                <div class="small text-muted">{{ __('Кутилмоқда') }}</div>
                <div class="h5 mb-0">1 {{ __('та квартира') }}</div>
                <div class="small text-warning">28,000,000 {{ __('сўм') }}</div>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar bg-warning" style="width: 16%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-danger border-3">
            <div class="card-body">
                <div class="small text-muted">{{ __('Муддати ўтган') }}</div>
                <div class="h5 mb-0">1 {{ __('та квартира') }}</div>
                <div class="small text-danger">35,000,000 {{ __('сўм') }}</div>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar bg-danger" style="width: 21%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-primary border-3">
            <div class="card-body">
                <div class="small text-muted">{{ __('Ўртача нарх') }}</div>
                <div class="h5 mb-0">42,500,000</div>
                <div class="small text-muted">{{ __('сўм / квартира') }}</div>
            </div>
        </div>
    </div>
</div>