<style>
    .avatar {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 50%;
    }

    .currency-display {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        background: #f8fafc;
        border-radius: 8px;
        font-size: 0.875rem;
        min-width: 150px;
        height: 40px;
        position: relative;
        overflow: hidden;
    }

    .currency-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .currency-item.active {
        opacity: 1;
        transform: translateX(0);
    }

    .currency-item.entering {
        transform: translateX(100%);
    }

    .currency-item.exiting {
        transform: translateX(-100%);
    }

    .currency-label {
        font-weight: 600;
        color: #64748b;
    }

    .currency-value {
        font-weight: 700;
        color: #1e293b;
    }

    .navbar-search {
        margin: 0;
    }

    .search-bar {
        width: 300px;
    }

    .search-bar .input-group {
        display: flex;
        align-items: stretch;
    }

    .search-bar .input-group-text {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-right: none;
        padding: 0.5rem 0.75rem;
        display: flex;
        align-items: center;
        border-radius: 0.375rem 0 0 0.375rem;
    }

    .search-bar .form-control {
        border: 1px solid #e2e8f0;
        border-left: none;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        background: #fff;
        height: auto;
        border-radius: 0 0.375rem 0.375rem 0;
    }

    .search-bar .form-control:focus {
        border-color: #3b82f6;
        box-shadow: none;
        outline: none;
    }

    .search-bar .form-control:focus+.input-group-text,
    .search-bar .input-group-text:has(+ .form-control:focus) {
        border-color: #3b82f6;
    }

    .search-bar .icon-xs {
        width: 16px;
        height: 16px;
        color: #64748b;
    }

    .loading {
        color: #64748b;
        font-size: 0.875rem;
    }

    .nav-link.dropdown-toggle::after {
        margin-left: 0.5rem;
    }

    .user-profile-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        line-height: 1.1;
    }

    .user-name {
        font-size: 0.75rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0;
        white-space: nowrap;
    }

    .user-role {
        font-size: 0.65rem;
        font-weight: 400;
        color: #64748b;
        text-transform: lowercase;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .currency-display {
            display: none;
        }

        .search-bar {
            width: 200px;
        }
    }

    @media (max-width: 767px) {
        .navbar-search {
            display: none !important;
        }
    }
</style>

<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">

            <!-- Left side: Toggle button -->
            <div class="d-flex align-items-center">
                <button id="sidebar-toggle"
                    class="sidebar-toggle me-3 btn btn-icon-only d-none d-lg-inline-block align-items-center justify-content-center">
                    <svg class="toggle-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
            </div>

            <!-- Right side: Currency, Search and user menu -->
            <div class="d-flex align-items-center gap-3">
                <!-- Search form -->
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0"
                        placeholder="{{ __('admin.search') }}" aria-label="Search" aria-describedby="search-icon">
                </div>

                <!-- Currency rates with animation -->
                <div class="d-none d-lg-flex align-items-center">
                    <div class="currency-display" id="currencyRates">
                        <span class="loading">Yuklanmoqda...</span>
                    </div>
                </div>

                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link text-dark notification-bell unread" data-unread-notifications="true"
                            href="{{ route('admin.notifications.index') }}" role="button" aria-expanded="false">
                            <svg class="icon icon-sm text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            href="javascript:void(0)"
                            id="openPreviewsBtn"
                            onclick="openPreviewsModal()"
                            title="Previews"
                            style="
            width:40px;
            height:40px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:10px;
            transition:all .25s ease;
        "
                            onmouseenter="this.style.transform='translateY(-2px) scale(1.05)'"
                            onmouseleave="this.style.transform='none'">
                            <img src="{{ asset('assets/img/icons/videos.png') }}" alt="Previews" style="width:18px;height:18px;object-fit:contain;">
                        </a>
                    </li>




                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle pt-1 ps-2" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="padding-right: 0.75rem;">
                            <div class="user-profile-wrapper">
                                <img class="avatar rounded-circle" alt="User avatar"
                                    src="https://media.istockphoto.com/id/526947869/vector/man-silhouette-profile-picture.jpg?s=612x612&w=0&k=20&c=5I7Vgx_U6UPJe9U2sA2_8JFF4grkP7bNmDnsLXTYlSc=">
                                <div class="user-info d-none d-lg-flex" style="margin-right: 1.5rem;">
                                    <span class="user-name">
                                        {{ auth()->user()->username }}
                                    </span>
                                    <span class="user-role">
                                        {{ __('admin.' . (auth()->user()->role->code ?? 'no_role')) }}
                                    </span>
                                </div>
                            </div>
                        </a>

                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('admin.profile.index', ['user_id' => auth()->user()->id]) }}">
                                <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.Profile') }}
                            </a>

                            <div role="separator" class="dropdown-divider my-1"></div>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                {{ __('admin.Logout') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<x-media.preview-modal
    id="mediaPreviewModal"
    :endpoint="route('admin.messages.preview')" />


<script>
    // Currency rates with smooth animation
    let currencyData = [];
    let currentIndex = 0;
    let animationInterval = null;

    async function fetchCurrencyRates() {
        try {
            const response = await fetch('https://cbu.uz/uz/arkhiv-kursov-valyut/json/');
            const data = await response.json();

            // USD, EUR va RUB kurslarini topish
            const usd = data.find(item => item.Ccy === 'USD');
            const eur = data.find(item => item.Ccy === 'EUR');
            const rub = data.find(item => item.Ccy === 'RUB');

            currencyData = [];

            if (usd) {
                currencyData.push({
                    label: 'USD',
                    value: parseFloat(usd.Rate).toLocaleString('uz-UZ', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                });
            }

            if (eur) {
                currencyData.push({
                    label: 'EUR',
                    value: parseFloat(eur.Rate).toLocaleString('uz-UZ', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                });
            }

            if (rub) {
                currencyData.push({
                    label: 'RUB',
                    value: parseFloat(rub.Rate).toLocaleString('uz-UZ', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                });
            }

            if (currencyData.length > 0 && !animationInterval) {
                displayInitialCurrency();
                startCurrencyAnimation();
            }
        } catch (error) {
            console.error('Valyuta kurslarini yuklashda xatolik:', error);
            const container = document.getElementById('currencyRates');
            if (container) {
                container.innerHTML = '<span class="text-danger">Xatolik</span>';
            }
        }
    }

    function displayInitialCurrency() {
        const container = document.getElementById('currencyRates');
        if (!container || currencyData.length === 0) return;

        const currency = currencyData[0];
        container.innerHTML = `
        <div class="currency-item active">
            <span class="currency-label">${currency.label}:</span>
            <span class="currency-value">${currency.value}</span>
        </div>
    `;
        currentIndex = 1;
    }

    function displayCurrency() {
        const container = document.getElementById('currencyRates');
        if (!container || currencyData.length === 0) return;

        const currentCurrency = currencyData[(currentIndex - 1 + currencyData.length) % currencyData.length];
        const nextCurrency = currencyData[currentIndex];

        // Yangi elementni qo'shish (o'ng tomondan)
        const newItem = document.createElement('div');
        newItem.className = 'currency-item entering';
        newItem.innerHTML = `
        <span class="currency-label">${nextCurrency.label}:</span>
        <span class="currency-value">${nextCurrency.value}</span>
    `;
        container.appendChild(newItem);

        // Animatsiyani boshlash
        setTimeout(() => {
            const oldItem = container.querySelector('.currency-item.active');
            if (oldItem) {
                oldItem.classList.add('exiting');
                oldItem.classList.remove('active');
            }

            newItem.classList.add('active');
            newItem.classList.remove('entering');

            // Eski elementni olib tashlash
            setTimeout(() => {
                if (oldItem && oldItem.parentNode) {
                    oldItem.remove();
                }
            }, 600);
        }, 50);

        // Keyingi valyutaga o'tish
        currentIndex = (currentIndex + 1) % currencyData.length;
    }

    function startCurrencyAnimation() {
        // Har 3 soniyada valyutani almashtirish
        animationInterval = setInterval(displayCurrency, 3000);
    }

    if (document.getElementById('currencyRates')) {
        fetchCurrencyRates();

        setInterval(fetchCurrencyRates, 30000);
    }

    const searchInput2 = document.getElementById('searchInput');
    if (searchInput2) {
        searchInput2.addEventListener('input', function(e) {
            const searchTerm = e.target.value;
        });
    }

    function openPreviewsModal() {
        const modalEl = document.getElementById('previewsModal');
        const modal = new bootstrap.Modal(modalEl);

        const loadingEl = document.getElementById('previewsLoading');
        const emptyEl = document.getElementById('previewsEmpty');
        const listEl = document.getElementById('previewsList');

        // UI reset
        loadingEl.classList.remove('d-none');
        emptyEl.classList.add('d-none');
        listEl.classList.add('d-none');
        listEl.innerHTML = '';

        modal.show();

        axios.get("{{ route('admin.messages.previews.list') }}")
            .then((res) => {
                const files = res.data?.files || [];

                loadingEl.classList.add('d-none');

                if (!files.length) {
                    emptyEl.classList.remove('d-none');
                    return;
                }

                listEl.classList.remove('d-none');

                files.forEach((name) => {
                    const li = document.createElement('li');

                    li.style.cssText = `
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    gap:10px;
                    padding:10px 12px;
                    border:1px solid rgba(15,23,42,.08);
                    border-radius:10px;
                    margin-bottom:8px;
                    background:#fff;
                `;

                    const safeName = String(name).replace(/\\/g, '\\\\').replace(/'/g, "\\'");

                    li.innerHTML = `
<div style="
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
">

    <!-- 📄 Nomi -->
    <div style="
        min-width:0;
        font-size:14px;
        color:#0f172a;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        flex:1;
    ">
        ${name}
    </div>

    <!-- 🎬 Actions -->
    <div style="
        display:flex;
        align-items:center;
        gap:8px;
        flex-shrink:0;
    ">
        <!-- Preview -->
        <button type="button"
            class="preview-btn"
            title="Ko‘rish"
            data-bs-toggle="modal"
            data-bs-target="#mediaPreviewModal"
onclick="openMediaPreview('${safeName}', 'fileName')"
            style="
                width:34px;
                height:34px;
                border-radius:10px;
                border:1px solid rgba(59,130,246,.25);
                background:rgba(59,130,246,.08);
                color:#3b82f6;
                display:flex;
                align-items:center;
                justify-content:center;
                cursor:pointer;
            ">
            <i class="fa-solid fa-circle-play"></i>
        </button>

        <!-- Delete -->
        <button type="button"
            data-action="delete"
            data-name="${safeName}"
            title="O‘chirish"
onclick="deletePreview('${safeName}')"
            style="
                width:34px;
                height:34px;
                border-radius:10px;
                border:1px solid rgba(239,68,68,.25);
                background:rgba(239,68,68,.08);
                color:#ef4444;
                display:flex;
                align-items:center;
                justify-content:center;
                cursor:pointer;
            ">
            <i class="fa-regular fa-trash-can"></i>
        </button>
    </div>
</div>
`;



                    listEl.appendChild(li);
                });
            })
            .catch((err) => {
                console.error(err);
                loadingEl.classList.add('d-none');
                emptyEl.classList.remove('d-none');
                emptyEl.textContent = 'Xatolik: ro‘yxatni olib bo‘lmadi.';
            });
    }

    // hozircha delete bosilsa faqat console (keyin API qilamiz)
    document.getElementById('previewsList')?.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action="delete"]');
        if (!btn) return;

        console.log('Delete bosildi:', btn.dataset.name);
    });

    async function deletePreview(fileName) {
        const ok = confirm("Rostdan ham o‘chirasanmi?");
        if (!ok) return;

        try {
            const key = String(fileName).replace(/\.mp4$/i, ''); // "abc.mp4" -> "abc"

            const url = "{{ route('admin.messages.previews.delete', ['key' => '__KEY__']) }}"
                .replace('__KEY__', encodeURIComponent(key));

            const res = await axios.delete(url, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (res.data?.ok) {
                alert("✅ O‘chirildi");
                // Hozircha sahifani refresh qilamiz (keyin listni qayta yuklaymiz)
                location.reload();
            } else {
                alert("❌ O‘chmadi");
            }
        } catch (e) {
            console.error(e);
            alert("❌ Xatolik: delete ishlamadi");
        }
    }
</script>