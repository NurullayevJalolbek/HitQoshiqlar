const EDIT_ROUTE_BASE = "{{ url('admin/project-investors') }}";

    // TZ bo'yicha to'liq static ma'lumotlar
    const DEFAULT_INVESTORS = [{
        id: 1,
        company_name: "\"Tech Solutions\" MChJ",
        inn: "123456789",
        ifut: "00001",
        activity_type: "MChJ",
        address: "Toshkent sh., Chilonzor t., Bunyodkor ko'chasi 12-uy",
        director_fio: "Islomov Sardor Akramovich",
        login: "techsolutions",
        phone: "+998901112233",
        email: "info@techsolutions.uz",
        registered_at: "2024-01-15",
        registration_number: "REG-2024-0001",
        registration_org: "Toshkent shahar adliya boshqarmasi",
        passport: "",
        jshshir: "",
        status: "active",
        investor_status_date: "2024-01-20",
        certificate_file: "sertifikat_001.pdf",
        share_amount: 500000000,
        share_percent: 25.0
    },
    {
        id: 2,
        company_name: "\"Green Energy\" AJ",
        inn: "987654321",
        ifut: "00002",
        activity_type: "AJ",
        address: "Toshkent sh., Yashnobod t., Amir Temur ko'chasi 45-bino",
        director_fio: "Karimova Dilnoza Rustamovna",
        login: "greenenergy",
        phone: "+998909998877",
        email: "contact@greenenergy.uz",
        registered_at: "2024-02-10",
        registration_number: "REG-2024-0002",
        registration_org: "Toshkent shahar adliya boshqarmasi",
        passport: "",
        jshshir: "",
        status: "active",
        investor_status_date: "2024-02-15",
        certificate_file: "sertifikat_002.pdf",
        share_amount: 300000000,
        share_percent: 15.0
    },
    {
        id: 3,
        company_name: "Tursunov Aziz Mahmudovich",
        inn: "321654987",
        ifut: "00003",
        activity_type: "YaTT",
        address: "Samarqand sh., Siob t., Mustaqillik ko'chasi 23-uy",
        director_fio: "Tursunov Aziz Mahmudovich",
        login: "aziz_investor",
        phone: "+998903334455",
        email: "aziz.t@mail.uz",
        registered_at: "2024-03-05",
        registration_number: "REG-2024-0003",
        registration_org: "Samarqand viloyat soliq boshqarmasi",
        passport: "AA1234567",
        jshshir: "12345678901234",
        status: "active",
        investor_status_date: "2024-03-08",
        certificate_file: "sertifikat_003.pdf",
        share_amount: 200000000,
        share_percent: 10.0
    },
    {
        id: 4,
        company_name: "\"Innovate Plus\" MChJ",
        inn: "456789123",
        ifut: "00004",
        activity_type: "MChJ",
        address: "Andijon sh., Marhamat t., Navoi ko'chasi 78-bino",
        director_fio: "Hamroyev Bekzod Shuxratovich",
        login: "innovateplus",
        phone: "+998935551122",
        email: "info@innovateplus.uz",
        registered_at: "2024-01-25",
        registration_number: "REG-2024-0004",
        registration_org: "Andijon viloyat adliya boshqarmasi",
        passport: "",
        jshshir: "",
        status: "blocked",
        investor_status_date: "2024-01-30",
        certificate_file: "sertifikat_004.pdf",
        share_amount: 150000000,
        share_percent: 7.5
    },
    {
        id: 5,
        company_name: "Rustamova Malika Azimovna",
        inn: "789456123",
        ifut: "00005",
        activity_type: "YaTT",
        address: "Buxoro sh., Kogon t., Mustaqillik shoh ko'chasi 15-uy",
        director_fio: "Rustamova Malika Azimovna",
        login: "malika_invest",
        phone: "+998933210987",
        email: "malika.r@inbox.uz",
        registered_at: "2024-04-12",
        registration_number: "REG-2024-0005",
        registration_org: "Buxoro viloyat soliq boshqarmasi",
        passport: "AB9876543",
        jshshir: "98765432109876",
        status: "active",
        investor_status_date: "2024-04-15",
        certificate_file: "sertifikat_005.pdf",
        share_amount: 420000000,
        share_percent: 21.0
    },
    {
        id: 6,
        company_name: "\"Capital Invest\" AJ",
        inn: "654987321",
        ifut: "00006",
        activity_type: "AJ",
        address: "Toshkent sh., Mirobod t., Buyuk Ipak Yo'li 90-bino",
        director_fio: "Abdullayev Otabek Farxodovich",
        login: "capitalinvest",
        phone: "+998977654321",
        email: "office@capitalinvest.uz",
        registered_at: "2024-05-20",
        registration_number: "REG-2024-0006",
        registration_org: "Toshkent shahar adliya boshqarmasi",
        passport: "",
        jshshir: "",
        status: "active",
        investor_status_date: "2024-05-25",
        certificate_file: "sertifikat_006.pdf",
        share_amount: 430000000,
        share_percent: 21.5
    },
    {
        id: 7,
        company_name: "\"Digital Innovations\" MChJ",
        inn: "852963741",
        ifut: "00007",
        activity_type: "MChJ",
        address: "Namangan sh., Pop t., Taraqqiyot ko'chasi 34-uy",
        director_fio: "Yuldashev Jamshid Olimovich",
        login: "digital_inn",
        phone: "+998913456789",
        email: "info@digitalinn.uz",
        registered_at: "2024-06-08",
        registration_number: "REG-2024-0007",
        registration_org: "Namangan viloyat adliya boshqarmasi",
        passport: "",
        jshshir: "",
        status: "active",
        investor_status_date: "2024-06-12",
        certificate_file: "sertifikat_007.pdf",
        share_amount: 280000000,
        share_percent: 14.0
    },
    {
        id: 8,
        company_name: "Nematova Sevara Toxirovna",
        inn: "741852963",
        ifut: "00008",
        activity_type: "YaTT",
        address: "Farg'ona sh., Quvasoy t., O'zbekiston ko'chasi 56-uy",
        director_fio: "Nematova Sevara Toxirovna",
        login: "sevara_n",
        phone: "+998945678912",
        email: "sevara.n@gmail.com",
        registered_at: "2024-07-03",
        registration_number: "REG-2024-0008",
        registration_org: "Farg'ona viloyat soliq boshqarmasi",
        passport: "AC5544332",
        jshshir: "67890123456789",
        status: "active",
        investor_status_date: "2024-07-05",
        certificate_file: "sertifikat_008.pdf",
        share_amount: 175000000,
        share_percent: 8.75
    }
    ];

    // LocalStorage'dan yuklash yoki boshlang'ich ma'lumotlarni saqlash
    let investors = JSON.parse(localStorage.getItem('project_investors') || '[]');
    let defaultInvestors = [];

    if (investors.length === 0) {
        investors = DEFAULT_INVESTORS;
        localStorage.setItem('project_investors', JSON.stringify(investors));
    }

    defaultInvestors = [...investors];

    const investorTableBody = document.getElementById('investorTableBody');
    const searchInput = document.getElementById('searchInput');
    const activityTypeFilter = document.getElementById('activityTypeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const filterBtn = document.getElementById('filterBtn');
    const clearBtn = document.getElementById('clearBtn');

    function saveToStorage() {
        localStorage.setItem('project_investors', JSON.stringify(investors));
    }

    // Pul formatini o'zgartirish - projects sahifasiga o'xshash
    function formatCurrency(num) {
        if (num === null || num === undefined) return '-';
        if (num >= 1000000000) {
            return (num / 1000000000).toFixed(1) + ' mlrd';
        } else if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + ' mln';
        }
        return new Intl.NumberFormat('uz-UZ').format(num);
    }

    // Qisqa format
    function formatCurrencyShort(num) {
        if (num === null || num === undefined) return '-';
        if (num >= 1000000000) {
            return (num / 1000000000).toFixed(2) + ' mlrd';
        } else if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + ' mln';
        }
        return new Intl.NumberFormat('uz-UZ').format(num) + ' so\'m';
    }

    function formatPercent(p) {
        if (p === null || p === undefined || p === '') return '-';
        const n = Number(p);
        if (Number.isNaN(n)) return '-';
        return n.toFixed(2) + '%';
    }

    // Activity type badge
    function getActivityTypeBadge(activityType) {
        const badgeClass = activityType === 'MChJ' ? 'badge-activity-mchj' :
            activityType === 'AJ' ? 'badge-activity-aj' :
                'badge-activity-yatt';
        return `<span class="badge badge-custom ${badgeClass}">${activityType}</span>`;
    }

    // Status badge - projects sahifasiga o'xshash
    function getStatusBadge(status) {
        if (status === 'active') {
            return '<span class="badge badge-custom badge-status-active">Faol</span>';
        } else if (status === 'blocked') {
            return '<span class="badge badge-custom badge-status-blocked">Bloklangan</span>';
        }
        return '<span class="badge badge-custom">Noma\'lum</span>';
    }

    // Sertifikat fayli ko'rinishi
    function getCertificateDisplay(filename) {
        if (!filename) return '<span class="text-muted">-</span>';
        return `<a href="#" class="certificate-link" title="${filename}">
                    <i class="fas fa-file-pdf me-1"></i>Ko'rish
                </a>`;
    }

    // Sana formatini chiroyli ko'rinishda chiqarish
    function formatDate(dateString) {
    if (!dateString) return '<span class="text-muted">-</span>';

    const d = new Date(dateString);
    if (isNaN(d)) return '<span class="text-muted">-</span>';

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = String(d.getFullYear()).slice(-2);

    return `${day}.${month}.${year}`;
}


    // HTML escape funksiyasi
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    function safeText(v, fallback = '-') {
        if (v === null || v === undefined) return fallback;
        const s = String(v).trim();
        if (!s) return fallback;
        return escapeHtml(s);
    }

    // Jadval renderi - qisqartirilgan ustunlar bilan
    function renderInvestors(list = investors) {
        if (!investorTableBody) return;

        if (list.length === 0) {
            investorTableBody.innerHTML = `
                <tr>
                    <td colspan="21">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <div class="mt-2">
                                <h5>Investorlar topilmadi</h5>
                                <p class="text-muted">Filter sozlamalarini o'zgartiring yoki yangi investor qo'shing</p>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        list.forEach(item => {
            html += `
                <tr>
                    <td class="text-center">${item.id}</td>

                    <!-- Korxona: nom + INN (INN ustuni yashiriladi) -->
                    <td>
                        <div class="company-name">${safeText(item.company_name)}</div>
                        <div class="company-info">
                            <span class="text-muted">INN:</span> ${safeText(item.inn)}
                        </div>
                    </td>
                    <td class="col-inn">${safeText(item.inn)}</td>

                    <td class="text-center">${safeText(item.ifut)}</td>
                    <td class="text-center">${getActivityTypeBadge(item.activity_type)}</td>

                    <td>
                        <div class="value-primary">${safeText(item.address)}</div>
                    </td>

                    <td>
                        <div class="value-primary">${safeText(item.director_fio)}</div>
                    </td>

                    <!-- Login: login + telefon + email (telefon/email ustunlari yashiriladi) -->
                    <td>
                        <div class="value-primary">${safeText(item.login)}</div>
                        <div class="value-secondary"><span class="text-muted">Tel:</span> ${safeText(item.phone)}</div>
                        <div class="value-secondary"><span class="text-muted">Email:</span> ${safeText(item.email)}</div>
                    </td>
                    <td class="col-phone">${safeText(item.phone)}</td>
                    <td class="col-email">${safeText(item.email)}</td>

                    <!-- Ro'yxatdan o'tgan sana: sana + reg# + org (2 ustun yashiriladi) -->
                    <td class="text-center">
                        <div class="value-primary">${formatDate(item.registered_at)}</div>
                        <div class="value-secondary"><span class="text-muted">Reg#:</span> ${safeText(item.registration_number, '-')}</div>
                        <div class="value-secondary"><span class="text-muted">Org:</span> ${safeText(item.registration_org, '-')}</div>
                    </td>
                    <td class="col-regno">${safeText(item.registration_number, '-')}</td>
                    <td class="col-regorg">${safeText(item.registration_org, '-')}</td>

                    <!-- Pasport: pasport + JSHSHIR (JSHSHIR ustuni yashiriladi) -->
                    <td class="text-center">
                        <div class="value-primary">${item.passport ? safeText(item.passport) : '<span class="text-muted">-</span>'}</div>
                        <div class="value-secondary"><span class="text-muted">JSHSHIR:</span> ${safeText(item.jshshir, '-')}</div>
                    </td>
                    <td class="col-jshshir text-center">${safeText(item.jshshir, '-')}</td>

                    <td class="text-center">${getStatusBadge(item.status)}</td>
                    <td class="text-center">${formatDate(item.investor_status_date)}</td>
                    <td class="text-center">${getCertificateDisplay(item.certificate_file)}</td>

                    <!-- Ulush: summa + % (ulush % ustuni yashiriladi) -->
                    <td class="text-end">
                        <div class="value-primary">${formatCurrencyShort(item.share_amount)}</div>
                        <div class="value-secondary">${formatPercent(item.share_percent)}</div>
                    </td>
                    <td class="col-sharepct text-center">${formatPercent(item.share_percent)}</td>

                    <td>
                        <div class="action-buttons">
                            <x-edit-button />
                            <x-delete-button />
                        </div>
                    </td>
                </tr>
            `;
        });

        investorTableBody.innerHTML = html;
    }

    // Investorni o'chirish
    function deleteInvestor(id) {
        if (!confirm('Haqiqatan ham ushbu investorni o\'chirmoqchimisiz?\n\nBu amal qaytarib bo\'lmaydi.')) {
            return;
        }

        investors = investors.filter(i => i.id !== id);
        defaultInvestors = [...investors];
        saveToStorage();
        renderInvestors(investors);

        // Xabar ko'rsatish
        showNotification('Investor muvaffaqiyatli o\'chirildi!', 'success');
    }

    // Filterlash funksiyasi - projects sahifasiga o'xshash
    function applyFilter() {
        const search = (searchInput?.value || '').toLowerCase().trim();
        const activityType = activityTypeFilter?.value || '';
        const status = statusFilter?.value || '';

        const filtered = defaultInvestors.filter(i => {
            const matchesSearch = !search ||
                (i.company_name && i.company_name.toLowerCase().includes(search)) ||
                (i.director_fio && i.director_fio.toLowerCase().includes(search)) ||
                (i.login && i.login.toLowerCase().includes(search)) ||
                (i.phone && i.phone.includes(search)) ||
                (i.email && i.email.toLowerCase().includes(search)) ||
                (i.inn && i.inn.includes(search)) ||
                (i.ifut && i.ifut.includes(search));

            const matchesActivityType = !activityType || i.activity_type === activityType;

            const matchesStatus = !status ||
                (status === 'Faol' && i.status === 'active') ||
                (status === 'Bloklangan' && i.status === 'blocked');

            return matchesSearch && matchesActivityType && matchesStatus;
        });

        renderInvestors(filtered);
    }

    // Filtrlarni tozalash
    function resetFilters() {
        if (searchInput) searchInput.value = '';
        if (activityTypeFilter) activityTypeFilter.value = '';
        if (statusFilter) statusFilter.value = '';
        renderInvestors(defaultInvestors);
    }

    // Xabar ko'rsatish funksiyasi
    function showNotification(message, type = 'info') {
        console.log(`[${type.toUpperCase()}] ${message}`);
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function () {
        renderInvestors(investors);

        if (filterBtn) {
            filterBtn.addEventListener('click', applyFilter);
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', resetFilters);
        }

        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilter, 300);
            });

            searchInput.addEventListener('keyup', function (e) {
                if (e.key === 'Enter') applyFilter();
            });
        }

        if (activityTypeFilter) {
            activityTypeFilter.addEventListener('change', applyFilter);
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', applyFilter);
        }
    });

    // Global funksiyalar
    window.deleteInvestor = deleteInvestor;
    window.applyFilter = applyFilter;
    window.resetFilters = resetFilters;