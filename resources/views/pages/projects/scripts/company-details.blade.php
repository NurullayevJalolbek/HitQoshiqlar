const DEFAULT_COMPANIES = [
            {
                id: 1,
                company_name: '"Envast Capital" MChJ',
                category: 'full_partner',
                inn: '123456789',
                ifut: '00001',
                activity_type: 'MChJ',
                address: "Toshkent sh., Yunusobod t., Amir Temur ko'chasi 15-uy",
                director_fio: 'Abdullayev Jamshid Murodovich',
                phone: '+998 90 123-45-67',
                email: 'info@envast.uz',
                registered_at: '2020-05-15',
                registration_number: 'REG-2020-001',
                registration_org: "Toshkent shahar adliya boshqarmasi",
                passport: '',
                jshshir: '',
            },
            {
                id: 2,
                company_name: '"Premium Residence" MChJ',
                category: 'subsidiary',
                inn: '987654321',
                ifut: '00002',
                activity_type: 'MChJ',
                address: "Toshkent sh., Mirzo Ulug'bek t., Buyuk Ipak yo'li 45-uy",
                director_fio: 'Karimov Aziz Rustamovich',
                phone: '+998 97 222-33-44',
                email: 'office@premium-res.uz',
                registered_at: '2021-08-10',
                registration_number: 'REG-2021-045',
                registration_org: "Toshkent shahar adliya boshqarmasi",
                passport: '',
                jshshir: '',
            },
            {
                id: 3,
                company_name: '"Envast Commandite 1" Komandit shirkati',
                category: 'commandite',
                inn: '564738291',
                ifut: '00003',
                activity_type: 'MChJ',
                address: "Toshkent sh., Chilonzor t., Bunyodkor ko'chasi 120-uy",
                director_fio: 'Sattorov Dilshod Shavkatovich',
                phone: '+998 93 555-66-77',
                email: 'commandite1@envast.uz',
                registered_at: '2024-01-05',
                registration_number: 'REG-2024-010',
                registration_org: "Toshkent shahar adliya boshqarmasi",
                passport: '',
                jshshir: '',
            },
            {
                id: 4,
                company_name: 'Tursunov Aziz Mahmudovich',
                category: 'full_partner',
                inn: '321654987',
                ifut: '00004',
                activity_type: 'YaTT',
                address: "Samarqand sh., Siab t., Bog'ishamol ko'chasi 7-uy",
                director_fio: 'Tursunov Aziz Mahmudovich',
                phone: '+998 90 333-44-55',
                email: 'aziz.t@example.uz',
                registered_at: '2019-03-20',
                registration_number: 'REG-2019-077',
                registration_org: "Samarqand viloyati soliq boshqarmasi",
                passport: 'AA1234567',
                jshshir: '12345678901234',
            },
        ];

        let companies = [...DEFAULT_COMPANIES];
        let defaultCompanies = [...DEFAULT_COMPANIES];

        const companyTableBody = document.getElementById('companyTableBody');
        const companyCategoryFilter = document.getElementById('companyCategoryFilter');
        <!-- const activityTypeFilter = document.getElementById('activityTypeFilter'); -->


        function escapeHtml(text) {
            if (!text) return '';
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return String(text).replace(/[&<>"']/g, m => map[m]);
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



        function getCategoryBadge(category) {
            if (category === 'full_partner') return '<span class="badge badge-custom badge-category-full">To‘liq sherik</span>';
            if (category === 'subsidiary') return '<span class="badge badge-custom badge-category-subsidiary">Shu\'ba korxona</span>';
            if (category === 'commandite') return '<span class="badge badge-custom badge-category-commandite">Komandit shirkati</span>';
            return '<span class="badge badge-custom">-</span>';
        }

        function getActivityBadge(type) {
            if (type === 'MChJ') return '<span class="badge badge-custom badge-activity-mchj">MChJ</span>';
            if (type === 'AJ') return '<span class="badge badge-custom badge-activity-aj">AJ</span>';
            if (type === 'YaTT') return '<span class="badge badge-custom badge-activity-yatt">YaTT</span>';
            return '<span class="badge badge-custom">-</span>';
        }

        function renderCompanies(list = companies) {
            if (!companyTableBody) return;

            if (!list.length) {
                companyTableBody.innerHTML = `
                    <tr>
                        <td colspan="16">
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <div class="mt-2">
                                    <h5>Korxonalar topilmadi</h5>
                                    <p class="text-muted">Filterlarni o‘zgartiring yoki yangi korxona qo‘shing</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            list.forEach(item => {
                const inn = item.inn ? escapeHtml(item.inn) : '-';
                const phone = item.phone ? escapeHtml(item.phone) : '-';

                // registered_at shu yerda ishlatiladi -> dd.mm.yy
                const regDate = item.registered_at ? formatDate(item.registered_at) : '<span class="text-muted">-</span>';
                const regNum = item.registration_number ? escapeHtml(item.registration_number) : '-';
                const regOrg = item.registration_org ? escapeHtml(item.registration_org) : '-';

                const passport = item.passport ? escapeHtml(item.passport) : '';
                const jshshir = item.jshshir ? escapeHtml(item.jshshir) : '';

                html += `
                    <tr>
                        <td class="text-center">${item.id}</td>

                        <!-- Korxona nomi ichiga INN jamlanadi -->
                        <td>
                            <div class="company-name">${escapeHtml(item.company_name)}</div>
                            <div class="company-info"><i class="fas fa-id-card me-1"></i>${inn}</div>
                        </td>

                        <td class="text-center">${getCategoryBadge(item.category)}</td>

                        <!-- INN: data bor, lekin ko‘rinmaydi -->
                        <td class="col-inn text-center">${inn}</td>

                        <td class="text-center">${escapeHtml(item.ifut)}</td>
                        <td class="text-center">${getActivityBadge(item.activity_type)}</td>

                        <td>
                            <div class="value-primary">${escapeHtml(item.address)}</div>
                        </td>

                        <!-- Direktor ichiga Telefon jamlanadi -->
                        <td>
                            <div class="value-primary">${escapeHtml(item.director_fio)}</div>
                            <div class="value-secondary"><span class="text-muted">Tel:</span> ${phone}</div>
                        </td>

                        <!-- Telefon: data bor, lekin ko‘rinmaydi -->
                        <td class="col-phone">${phone}</td>

                        <td>${escapeHtml(item.email)}</td>

                        <!-- Ro‘yxatdan o‘tgan sana ichiga raqam + organ jamlanadi -->
                        <td class="text-center">
                            <div class="value-primary">${regDate}</div>
                            <div class="value-secondary"><span class="text-muted">№</span> ${regNum}</div>
                            <div class="value-secondary">${regOrg}</div>
                        </td>

                        <!-- reg_number/reg_org: data bor, lekin ko‘rinmaydi -->
                        <td class="col-regnum">${regNum}</td>
                        <td class="col-regorg">${regOrg}</td>

                        <!-- Pasport ichiga JSHSHIR jamlanadi (faqat YaTT mazmuni saqlanadi) -->
                        <td class="text-center">
                            ${
                                item.activity_type === 'YaTT'
                                ? `
                                    <div class="value-primary">${passport ? passport : '<span class="text-muted">-</span>'}</div>
                                    <div class="value-secondary"><span class="text-muted">JSHSHIR:</span> ${jshshir ? jshshir : '-'}</div>
                                  `
                                : '<span class="text-muted">-</span>'
                            }
                        </td>

                        <!-- JSHSHIR: data bor, lekin ko‘rinmaydi -->
                        <td class="col-jshshir text-center">
                            ${item.activity_type === 'YaTT' ? (jshshir ? jshshir : '-') : '-'}
                        </td>

                        <td>
                            <div class="action-buttons">
                                <x-edit-button />
                                <x-delete-button />
                            </div>
                        </td>
                    </tr>
                `;
            });

            companyTableBody.innerHTML = html;
        }

        function applyFilter() {
            const search = (searchInput?.value || '').toLowerCase().trim();
            const category = companyCategoryFilter?.value || '';
            <!-- const activity = activityTypeFilter?.value || ''; -->

            const filtered = defaultCompanies.filter(c => {
                const matchesSearch = !search
                    || (c.company_name && c.company_name.toLowerCase().includes(search))
                    || (c.director_fio && c.director_fio.toLowerCase().includes(search))
                    || (c.inn && c.inn.includes(search))
                    || (c.phone && c.phone.includes(search))
                    || (c.email && c.email.toLowerCase().includes(search));

                const matchesCategory = !category || c.category === category;
                const matchesActivity = !activity || c.activity_type === activity;

                return matchesSearch && matchesCategory && matchesActivity;
            });

            renderCompanies(filtered);
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (companyCategoryFilter) companyCategoryFilter.value = '';
            if (activityTypeFilter) activityTypeFilter.value = '';
            renderCompanies(defaultCompanies);
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderCompanies(companies);

            if (filterBtn) filterBtn.addEventListener('click', applyFilter);
            if (clearBtn) clearBtn.addEventListener('click', resetFilters);

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

            if (companyCategoryFilter) companyCategoryFilter.addEventListener('change', applyFilter);
            if (activityTypeFilter) activityTypeFilter.addEventListener('change', applyFilter);
        });