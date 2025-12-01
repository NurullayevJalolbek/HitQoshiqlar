<script>
(function() {
    'use strict';

    /* ============================
        1) DEFAULT MA'LUMOTLAR
    ============================ */
    const DEFAULT_PURCHASERS = [
        {
            id: 1,
            company_name: "Techno Building Group MCHJ",
            inn: "305667443",
            activity_type: "MCHJ",
            director_name: "Rasulov Baxtiyor",
            phone: "+998901112233",
            contract_file: "",
            contract_number: "TB-2024/01",
            contract_date: "2024-01-15",
            payment_terms: "Bosqichma-bosqich 12 oy",
            category: "qurilish"
        },
        {
            id: 2,
            company_name: "Global Rent Service AJ",
            inn: "308900221",
            activity_type: "AJ",
            director_name: "Xolmurodov Aziz",
            phone: "+998909998877",
            contract_file: "",
            contract_number: "GR-2024/03",
            contract_date: "2024-02-01",
            payment_terms: "Oylik to'lov",
            category: "ijara"
        },
        {
            id: 3,
            company_name: "Premium Land Invest MCHJ",
            inn: "309765432",
            activity_type: "MCHJ",
            director_name: "Karimova Dilnoza",
            phone: "+998903334455",
            contract_file: "",
            contract_number: "PL-2024/04",
            contract_date: "2024-03-12",
            payment_terms: "Bir martalik to'lov",
            category: "yer"
        },
        {
            id: 4,
            company_name: "Silver Construction LTD",
            inn: "302345678",
            activity_type: "LTD",
            director_name: "Tursunov Aziz",
            phone: "+998935551122",
            contract_file: "",
            contract_number: "SC-2024/05",
            contract_date: "2024-04-25",
            payment_terms: "24 oy muddat",
            category: "qurilish"
        },
        {
            id: 5,
            company_name: "Mega Rent Solutions YATT",
            inn: "301122334",
            activity_type: "YATT",
            director_name: "Rustamova Malika",
            phone: "+998933210987",
            contract_file: "",
            contract_number: "MR-2024/06",
            contract_date: "2024-06-01",
            payment_terms: "Oylik + depozit",
            category: "ijara"
        }
    ];

    /* ============================
        2) MA'LUMOTLAR BOSHQARUVI
        ESLATMA: localStorage o'rniga buyerda 
        server-side ma'lumotlar ishlatilishi kerak.
        Hozircha default data bilan ishlaymiz.
    ============================ */
    let purchasers = [...DEFAULT_PURCHASERS];
    
    // Agar server-side ma'lumotlar mavjud bo'lsa:
    @if(isset($buyers) && count($buyers) > 0)
        purchasers = @json($buyers);
    @endif

    /* ============================
        3) CATEGORY TRANSLATSIYA
    ============================ */
    const categoryTranslations = {
        'yer': "{{ __('Ер') }}",
        'qurilish': "{{ __('Қурилиш') }}",
        'ijara': "{{ __('Ижара') }}"
    };

    function translateCategory(category) {
        return categoryTranslations[category] || category;
    }

    /* ============================
        4) JADVAL RENDERLASH
    ============================ */
    const EDIT_ROUTE = "{{ route('admin.project-buyers.index') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    function renderPurchasers(list = purchasers) {
        const tbody = document.getElementById('purchaser-table-body');
        const emptyState = document.getElementById('emptyState');
        
        if (!tbody) return;

        tbody.innerHTML = "";

        if (list.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            return;
        }

        if (emptyState) emptyState.style.display = 'none';

        list.forEach((p, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td><strong>${escapeHtml(p.company_name)}</strong></td>
                <td>${escapeHtml(p.inn)}</td>
                <td><span class="badge bg-info">${escapeHtml(p.activity_type)}</span></td>
                <td>${escapeHtml(p.director_name)}</td>
                <td><a href="tel:${escapeHtml(p.phone)}">${escapeHtml(p.phone)}</a></td>
                <td>${escapeHtml(p.contract_number)}</td>
                <td>${formatDate(p.contract_date)}</td>
                <td><small>${escapeHtml(p.payment_terms)}</small></td>
                <td><span class="badge bg-${getCategoryBadge(p.category)}">${translateCategory(p.category)}</span></td>
                <td class="table-actions">
                    <a href="${EDIT_ROUTE}/${p.id}/edit" 
                       class="me-2" 
                       title="{{ __('Таҳрирлаш') }}">
                        <img src="{{ asset('svg/edit-2.svg') }}" alt="Edit" width="18">
                    </a>
                    <button onclick="confirmDelete(${p.id})"
                            class="btn btn-link p-0"
                            title="{{ __('Ўчириш') }}">
                        <img src="{{ asset('svg/trash.svg') }}" alt="Delete" width="18">
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    /* ============================
        5) YORDAMCHI FUNKSIYALAR
    ============================ */
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}.${month}.${year}`;
    }

    function getCategoryBadge(category) {
        const badges = {
            'yer': 'success',
            'qurilish': 'warning',
            'ijara': 'primary'
        };
        return badges[category] || 'secondary';
    }

    /* ============================
        6) DELETE FUNKSIYASI
    ============================ */
    window.confirmDelete = function(id) {
        if (!confirm("{{ __('Ҳақиқатан ҳам ўчирмоқчимисиз?') }}")) {
            return;
        }

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        // AJAX so'rov - Laravel backend ga
        fetch(`${EDIT_ROUTE}/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Ma'lumotlarni yangilash
                purchasers = purchasers.filter(x => x.id !== id);
                renderPurchasers();
                
                // Success xabari
                showAlert('success', data.message || "{{ __('Муваффақиятли ўчирилди') }}");
            } else {
                showAlert('danger', data.message || "{{ __('Хатолик юз берди') }}");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', "{{ __('Хатолик юз берди') }}");
        })
        .finally(() => {
            if (loadingOverlay) loadingOverlay.classList.remove('active');
        });
    };

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${escapeHtml(message)}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        const container = document.querySelector('.breadcrumb-block');
        if (container) {
            container.insertAdjacentHTML('afterend', alertHtml);
            
            // 5 soniyadan keyin avtomatik yopish
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    }

    /* ============================
        7) FILTER FUNKSIYASI
    ============================ */
    function filterPurchasers() {
        const searchInput = document.getElementById('filter_search');
        const categorySelect = document.getElementById('filter_category');
        
        if (!searchInput || !categorySelect) return;

        const search = searchInput.value.toLowerCase().trim();
        const category = categorySelect.value;

        const result = purchasers.filter(p => {
            const matchesSearch = !search || 
                p.company_name.toLowerCase().includes(search) ||
                p.inn.includes(search) ||
                p.director_name.toLowerCase().includes(search) ||
                p.phone.includes(search);

            const matchesCategory = !category || p.category === category;

            return matchesSearch && matchesCategory;
        });

        renderPurchasers(result);
    }

    /* ============================
        8) EVENT LISTENERS
    ============================ */
    document.addEventListener('DOMContentLoaded', function() {
        // Filter button
        const filterBtn = document.getElementById('filterBtn');
        if (filterBtn) {
            filterBtn.addEventListener('click', filterPurchasers);
        }

        // Enter tugmasi bilan qidiruv
        const searchInput = document.getElementById('filter_search');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    filterPurchasers();
                }
            });
        }

        // Category o'zgarganda avtomatik filter
        const categorySelect = document.getElementById('filter_category');
        if (categorySelect) {
            categorySelect.addEventListener('change', filterPurchasers);
        }

        // Boshlang'ich render
        renderPurchasers();
    });

})();
</script>