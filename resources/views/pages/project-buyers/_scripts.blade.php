<script>
    const EDIT_ROUTE_BASE = "{{ url('admin/project-buyers') }}";

    // TZ bo'yicha to'liq static ma'lumotlar
    const DEFAULT_BUYERS = [{
        id: 1,
        direction: "qurilish",
        company_name: "\"Techno Building Group\" MChJ",
        inn: "305667443",
        activity_type: "MChJ",
        director_name: "Rasulov Baxtiyor Azimovich",
        phone: "+998901112233",
        passport: "",
        pinfl: "",
        contract_file: "shartnoma_001.pdf",
        contract_number: "TB-2024/01",
        contract_date: "2024-01-15",
        payment_terms: "Bosqichma-bosqich 12 oy davomida to'lov"
    },
    {
        id: 2,
        direction: "ijara",
        company_name: "\"Global Rent Service\" AJ",
        inn: "308900221",
        activity_type: "AJ",
        director_name: "Xolmurodov Aziz Shuxratovich",
        phone: "+998909998877",
        passport: "",
        pinfl: "",
        contract_file: "shartnoma_002.pdf",
        contract_number: "GR-2024/03",
        contract_date: "2024-02-01",
        payment_terms: "Oylik to'lov, har oy 1-sanasida"
    },
    {
        id: 3,
        direction: "yer",
        company_name: "\"Premium Land Invest\" MChJ",
        inn: "309765432",
        activity_type: "MChJ",
        director_name: "Karimova Dilnoza Rustamovna",
        phone: "+998903334455",
        passport: "",
        pinfl: "",
        contract_file: "shartnoma_003.pdf",
        contract_number: "PL-2024/04",
        contract_date: "2024-03-12",
        payment_terms: "Bir martalik to'lov"
    },
    {
        id: 4,
        direction: "qurilish",
        company_name: "\"Silver Construction\" MChJ",
        inn: "302345678",
        activity_type: "MChJ",
        director_name: "Tursunov Aziz Mahmudovich",
        phone: "+998935551122",
        passport: "",
        pinfl: "",
        contract_file: "shartnoma_004.pdf",
        contract_number: "SC-2024/05",
        contract_date: "2024-04-25",
        payment_terms: "24 oy muddat, oylik to'lovlar"
    },
    {
        id: 5,
        direction: "ijara",
        company_name: "Rustamova Malika Azimovna",
        inn: "301122334",
        activity_type: "YaTT",
        director_name: "Rustamova Malika Azimovna",
        phone: "+998933210987",
        passport: "AB9876543",
        pinfl: "12345678901234",
        contract_file: "shartnoma_005.pdf",
        contract_number: "MR-2024/06",
        contract_date: "2024-06-01",
        payment_terms: "Oylik to'lov + depozit (3 oylik)"
    },
    {
        id: 6,
        direction: "yer",
        company_name: "\"Land Development Corp\" AJ",
        inn: "307654321",
        activity_type: "AJ",
        director_name: "Abdullayev Otabek Farxodovich",
        phone: "+998977654321",
        passport: "",
        pinfl: "",
        contract_file: "shartnoma_006.pdf",
        contract_number: "LD-2024/07",
        contract_date: "2024-05-20",
        payment_terms: "50% oldindan, 50% topshirishda"
    },
    {
        id: 7,
        direction: "qurilish",
        company_name: "Yuldashev Jamshid Olimovich",
        inn: "304567890",
        activity_type: "YaTT",
        director_name: "Yuldashev Jamshid Olimovich",
        phone: "+998913456789",
        passport: "AA1234567",
        pinfl: "98765432109876",
        contract_file: "shartnoma_007.pdf",
        contract_number: "YJ-2024/08",
        contract_date: "2024-07-10",
        payment_terms: "Qurilish jarayonida bosqichma-bosqich"
    }];

    // LocalStorage'dan yuklash
    let buyers = JSON.parse(localStorage.getItem('project_buyers') || '[]');
    let defaultBuyers = [];

    if (buyers.length === 0) {
        buyers = DEFAULT_BUYERS;
        localStorage.setItem('project_buyers', JSON.stringify(buyers));
    }
    defaultBuyers = [...buyers];

    const tableBody = document.getElementById('buyerTableBody');
    const emptyState = document.getElementById('emptyState');
    const searchInput = document.getElementById('searchInput');
    const directionFilter = document.getElementById('filter_direction');
    const activityFilter = document.getElementById('filter_activity');
    const filterBtn = document.getElementById('filterBtn');
    const clearBtn = document.getElementById('clearBtn');

    function saveToStorage() {
        localStorage.setItem('project_buyers', JSON.stringify(buyers));
    }

    // Yo'nalish nomi
    function getDirectionName(direction) {
        const names = {
            'yer': 'Yer',
            'qurilish': 'Qurilish',
            'ijara': 'Ijara'
        };
        return names[direction] || direction;
    }

    // Yo'nalish badge
    function getDirectionBadge(direction) {
        const badgeClass = direction === 'yer' ? 'badge-direction-yer' :
            direction === 'qurilish' ? 'badge-direction-qurilish' :
                'badge-direction-ijara';
        return `<span class="badge badge-custom ${badgeClass}">${getDirectionName(direction)}</span>`;
    }

    // Faoliyat turi badge
    function getActivityBadge(type) {
        const badgeClass = type === 'MChJ' ? 'badge-activity-mchj' :
            type === 'AJ' ? 'badge-activity-aj' :
                'badge-activity-yatt';
        return `<span class="badge badge-custom ${badgeClass}">${type}</span>`;
    }

    function formatDate(dateString) {
    if (!dateString) return '<span class="text-muted">-</span>';

    const d = new Date(dateString);
    if (isNaN(d)) return '<span class="text-muted">-</span>';

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = String(d.getFullYear()).slice(-2);

    return `${day}.${month}.${year}`;
}




    // Shartnoma fayli
    function getContractFileDisplay(filename) {
        if (!filename) return '<span class="text-muted">-</span>';
        return `<a href="#" class="certificate-link" title="${filename}">
                    <i class="fas fa-file-pdf me-1"></i>Ko'rish
                </a>`;
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>\"']/g, m => map[m]);
    }

    // Jadval render
    function renderBuyers(list = buyers) {
        if (!tableBody) return;

        if (emptyState) emptyState.style.display = list.length === 0 ? 'block' : 'none';

        if (list.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="14">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <div class="mt-2">
                                <h5>Харидорлар топилмади</h5>
                                <p class="text-muted">Filter sozlamalarini o'zgartiring yoki yangi xaridor qo'shing</p>
                            </div>
                        </div>
                    </td>
                </tr>`;
            return;
        }

        let html = '';
        list.forEach(item => {
            const editUrl = `${EDIT_ROUTE_BASE}/${item.id}/edit`;

            const phoneCompact = item.phone ? escapeHtml(item.phone) : '';
            const pinflCompact = item.pinfl ? escapeHtml(item.pinfl) : '';

            html += `
                <tr>
                    <td class="text-center">${item.id}</td>

                    <!-- Korxona: nom + INN (ko‘rinadigan) -->
                    <td>
                        <div class="value-primary">${escapeHtml(item.company_name)}</div>
                        <div class="value-secondary"><i class="fas fa-hashtag me-1"></i>${escapeHtml(item.inn)}</div>
                    </td>

                    <!-- INN: kodda bor, ko‘rinmaydi (CSS .col-inn) -->
                    <td class="col-inn">${escapeHtml(item.inn)}</td>

                    <td class="text-center">${getActivityBadge(item.activity_type)}</td>

                    <!-- Direktor: ism + telefon (ko‘rinadigan) -->
                    <td>
                        <div class="value-primary">${escapeHtml(item.director_name)}</div>
                        ${phoneCompact ? `<div class="value-secondary"><i class="fas fa-phone me-1"></i>${phoneCompact}</div>` : `<div class="value-secondary"><span class="text-muted">-</span></div>`}
                    </td>

                    <!-- Telefon: kodda bor, ko‘rinmaydi (CSS .col-phone) -->
                    <td class="col-phone">${escapeHtml(item.phone)}</td>

                    <!-- Pasport: pasport + JSHSHIR (ko‘rinadigan) -->
                    <td class="text-center">
                        <div class="value-primary">${item.passport ? escapeHtml(item.passport) : '<span class="text-muted">-</span>'}</div>
                        ${pinflCompact ? `<div class="value-secondary"><i class="fas fa-id-card me-1"></i>${pinflCompact}</div>` : `<div class="value-secondary"><span class="text-muted">-</span></div>`}
                    </td>

                    <!-- JSHSHIR: kodda bor, ko‘rinmaydi (CSS .col-pinfl) -->
                    <td class="col-pinfl text-center">${item.pinfl ? escapeHtml(item.pinfl) : '<span class="text-muted">-</span>'}</td>

                    <td class="text-center">${getContractFileDisplay(item.contract_file)}</td>
                    <td>${escapeHtml(item.contract_number)}</td>
                    <td class="text-center">${formatDate(item.contract_date)}</td>
                    <td><div class="value-secondary">${escapeHtml(item.payment_terms || '')}</div></td>
                    <td class="text-center">${getDirectionBadge(item.direction)}</td>
                    <td>
                        <div class="action-buttons">
                            <x-edit-button />
                            <x-delete-button />
                        </div>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
    }

    // O'chirish
    function deleteBuyer(id) {
        if (!confirm('Haqiqatan ham ushbu ma\'lumotni o\'chirmoqchimisiz?')) {
            return;
        }

        buyers = buyers.filter(i => i.id !== id);
        defaultBuyers = [...buyers];
        saveToStorage();
        renderBuyers(buyers);
    }

    // Filterlash
    function applyFilters() {
        const search = (searchInput?.value || '').toLowerCase().trim();
        const direction = directionFilter?.value || '';
        const activity = activityFilter?.value || '';

        const filtered = defaultBuyers.filter(i => {
            const matchSearch = !search ||
                (i.company_name && i.company_name.toLowerCase().includes(search)) ||
                (i.director_name && i.director_name.toLowerCase().includes(search)) ||
                (i.phone && i.phone.includes(search)) ||
                (i.inn && i.inn.includes(search)) ||
                (i.contract_number && i.contract_number.toLowerCase().includes(search)) ||
                (i.payment_terms && i.payment_terms.toLowerCase().includes(search));

            const matchDirection = !direction || i.direction === direction;
            const matchActivity = !activity || i.activity_type === activity;

            return matchSearch && matchDirection && matchActivity;
        });

        renderBuyers(filtered);
    }

    // Tozalash
    function resetFilters() {
        if (searchInput) searchInput.value = '';
        if (directionFilter) directionFilter.value = '';
        if (activityFilter) activityFilter.value = '';
        renderBuyers(defaultBuyers);
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function () {
        // birinchi render
        renderBuyers(defaultBuyers);

        if (filterBtn) filterBtn.addEventListener('click', applyFilters);
        if (clearBtn) clearBtn.addEventListener('click', resetFilters);

        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 300);
            });
            searchInput.addEventListener('keyup', function (e) {
                if (e.key === 'Enter') applyFilters();
            });
        }

        if (directionFilter) directionFilter.addEventListener('change', applyFilters);
        if (activityFilter) activityFilter.addEventListener('change', applyFilters);
    });

    window.deleteBuyer = deleteBuyer;
    window.applyFilters = applyFilters;
    window.resetFilters = resetFilters;
</script>
