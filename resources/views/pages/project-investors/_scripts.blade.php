<script>
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

    if (investors.length === 0) {
        investors = DEFAULT_INVESTORS;
        localStorage.setItem('project_investors', JSON.stringify(investors));
    }

    function saveToStorage() {
        localStorage.setItem('project_investors', JSON.stringify(investors));
    }

    // Pul formatini chiroyli ko'rinishda chiqarish
    function formatMoney(amount) {
        return new Intl.NumberFormat('uz-UZ').format(amount) + ' so\'m';
    }

    // Status badge
    function getStatusBadge(status) {
        if (status === 'active') {
            return '<span class="badge bg-success">Faol</span>';
        } else if (status === 'blocked') {
            return '<span class="badge bg-danger">Bloklangan</span>';
        }
        return '<span class="badge bg-secondary">Noma\'lum</span>';
    }

    // Sertifikat fayli ko'rinishi
    function getCertificateDisplay(filename) {
        if (!filename) return '<span class="text-muted">-</span>';
        return `<a href="#" class="text-primary" title="${filename}">
                    <i class="fas fa-file-pdf"></i> Ko'rish
                </a>`;
    }

    // Jadval renderi
    function renderTable(list = investors) {
        let tbody = document.getElementById('investor-table-body');
        if (!tbody) return;

        tbody.innerHTML = "";

        if (list.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="22" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        <p class="mb-0">Ma'lumotlar topilmadi</p>
                    </td>
                </tr>
            `;
            return;
        }

        list.forEach((item, index) => {
            tbody.innerHTML += `
                <tr>
                    <td class="text-center">${item.id}</td>
                    <td>${item.company_name}</td>
                    <td>${item.inn}</td>
                    <td class="text-center">${item.ifut}</td>
                    <td class="text-center">
                        <span class="badge ${item.activity_type === 'MChJ' ? 'bg-primary' : item.activity_type === 'AJ' ? 'bg-info' : 'bg-warning text-dark'}">${item.activity_type}</span>
                    </td>
                    <td>${item.address}</td>
                    <td>${item.director_fio}</td>
                    <td>${item.login}</td>
                    <td>${item.phone}</td>
                    <td>${item.email}</td>
                    <td class="text-center">${item.registered_at}</td>
                    <td>${item.registration_number || '-'}</td>
                    <td>${item.registration_org || '-'}</td>
                    <td class="text-center">${item.passport || '<span class="text-muted">-</span>'}</td>
                    <td class="text-center">${item.jshshir || '<span class="text-muted">-</span>'}</td>
                    <td class="text-center">${getStatusBadge(item.status)}</td>
                    <td class="text-center">${item.investor_status_date || '-'}</td>
                    <td class="text-center">${getCertificateDisplay(item.certificate_file)}</td>
                    <td class="text-end"><strong>${formatMoney(item.share_amount)}</strong></td>
                    <td class="text-center"><strong>${item.share_percent}%</strong></td>
                    <td class="text-center">
                        <a href="${EDIT_ROUTE_BASE}/${item.id}/edit" class="me-2" title="Tahrirlash">
                            <x-edit-button />
                        </a>
                        <button onclick="deleteInvestor(${item.id})" 
                                style="border:none;background:none;cursor:pointer;padding:0;" 
                                title="O'chirish">
                            <x-delete-button />
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    // Investorni o'chirish
    function deleteInvestor(id) {
        if (!confirm('Haqiqatan ham ushbu investorni o\'chirmoqchimisiz?\n\nBu amal qaytarib bo\'lmaydi.')) {
            return;
        }

        investors = investors.filter(i => i.id !== id);
        saveToStorage();
        renderTable();

        // Xabar ko'rsatish
        showNotification('Investor muvaffaqiyatli o\'chirildi!', 'success');
    }

    // Filterlash funksiyasi
    function applyFilters() {
        let search = (document.getElementById('searchInput')?.value || '').toLowerCase().trim();
        let status = document.getElementById('statusFilter')?.value || '';

        let filtered = investors.filter(i => {
            // Qidiruv bo'yicha
            let matchSearch = !search ||
                i.company_name.toLowerCase().includes(search) ||
                i.director_fio.toLowerCase().includes(search) ||
                i.login.toLowerCase().includes(search) ||
                i.phone.includes(search) ||
                i.email.toLowerCase().includes(search) ||
                i.inn.includes(search) ||
                i.ifut.includes(search);

            // Status bo'yicha
            let matchStatus = !status ||
                (status === 'Faol' && i.status === 'active') ||
                (status === 'Bloklangan' && i.status === 'blocked');

            return matchSearch && matchStatus;
        });

        renderTable(filtered);
    }

    // Filtrlarni tozalash
    function resetFilters() {
        if (document.getElementById('searchInput')) {
            document.getElementById('searchInput').value = '';
        }
        if (document.getElementById('statusFilter')) {
            document.getElementById('statusFilter').value = '';
        }
        renderTable(investors);
    }

    // Xabar ko'rsatish funksiyasi
    function showNotification(message, type = 'info') {
        // Bu yerda toast notification qo'shish mumkin
        console.log(`[${type.toUpperCase()}] ${message}`);
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Qidiruv
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }

        // Status filter
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', applyFilters);
        }

        // Dastlabki render
        renderTable();
    });

    // Global funksiyalar
    window.deleteInvestor = deleteInvestor;
    window.applyFilters = applyFilters;
    window.resetFilters = resetFilters;
</script>
