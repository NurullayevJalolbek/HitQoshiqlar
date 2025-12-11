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
        }
    ];

    // LocalStorage'dan yuklash
    let buyers = JSON.parse(localStorage.getItem('project_buyers') || '[]');

    if (buyers.length === 0) {
        buyers = DEFAULT_BUYERS;
        localStorage.setItem('project_buyers', JSON.stringify(buyers));
    }

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

    // Yo'nalish badge rangi
    function getDirectionBadge(direction) {
        const badges = {
            'yer': 'success',
            'qurilish': 'warning',
            'ijara': 'primary'
        };
        return badges[direction] || 'secondary';
    }

    // Sana formati
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}.${month}.${year}`;
    }

    // Shartnoma fayli
    function getContractFileDisplay(filename) {
        if (!filename) return '<span class="text-muted">-</span>';
        return `<a href="#" class="text-primary" title="${filename}">
                    <i class="fas fa-file-pdf"></i> Ko'rish
                </a>`;
    }

    // Jadval render
    function renderTable(list = buyers) {
        let tbody = document.getElementById('purchaser-table-body');
        if (!tbody) return;

        tbody.innerHTML = "";

        if (list.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="11" class="text-center text-muted py-4">
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
                    <td class="text-center">${index + 1}</td>
                    <td><strong>${item.company_name}</strong></td>
                    <td>${item.inn}</td>
                    <td>
                        <span class="badge ${item.activity_type === 'MChJ' ? 'bg-primary' : item.activity_type === 'AJ' ? 'bg-info' : 'bg-warning text-dark'}">${item.activity_type}</span>
                    </td>
                    <td>${item.director_name}</td>
                    <td><a href="tel:${item.phone}">${item.phone}</a></td>
                    <td>${item.contract_number}</td>
                    <td class="text-center">${formatDate(item.contract_date)}</td>
                    <td><small>${item.payment_terms}</small></td>
                    <td class="text-center">
                        <span class="badge bg-${getDirectionBadge(item.direction)}">${getDirectionName(item.direction)}</span>
                    </td>
                    <td class="text-center">
                        <a href="${EDIT_ROUTE_BASE}/${item.id}/edit" class="me-2" title="Tahrirlash">
                            <x-edit-button />
                        </a>
                        <button onclick="deleteBuyer(${item.id})" 
                                style="border:none;background:none;cursor:pointer;padding:0;" 
                                title="O'chirish">
                            <x-delete-button />
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    // O'chirish
    function deleteBuyer(id) {
        if (!confirm('Haqiqatan ham ushbu ma\'lumotni o\'chirmoqchimisiz?')) {
            return;
        }

        buyers = buyers.filter(i => i.id !== id);
        saveToStorage();
        renderTable();
    }

    // Filterlash
    function applyFilters() {
        let search = (document.getElementById('searchInput')?.value || '').toLowerCase().trim();
        let direction = document.getElementById('filter_category')?.value || '';

        let filtered = buyers.filter(i => {
            let matchSearch = !search ||
                i.company_name.toLowerCase().includes(search) ||
                i.director_name.toLowerCase().includes(search) ||
                i.phone.includes(search) ||
                i.inn.includes(search) ||
                i.contract_number.toLowerCase().includes(search);

            let matchDirection = !direction || i.direction === direction;

            return matchSearch && matchDirection;
        });

        renderTable(filtered);
    }

    // Tozalash
    function resetFilters() {
        if (document.getElementById('searchInput')) {
            document.getElementById('searchInput').value = '';
        }
        if (document.getElementById('filter_category')) {
            document.getElementById('filter_category').value = '';
        }
        renderTable(buyers);
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') applyFilters();
            });
        }

        const categoryFilter = document.getElementById('filter_category');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', applyFilters);
        }

        const filterBtn = document.getElementById('filterBtn');
        if (filterBtn) {
            filterBtn.addEventListener('click', applyFilters);
        }

        const clearBtn = document.getElementById('clearBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', resetFilters);
        }

        renderTable();
    });

    window.deleteBuyer = deleteBuyer;
    window.applyFilters = applyFilters;
    window.resetFilters = resetFilters;
</script>
