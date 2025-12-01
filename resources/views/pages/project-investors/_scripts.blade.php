<script>
    const EDIT_ROUTE_BASE = "{{ url('admin/project-investors') }}";

    // Default static data
    const DEFAULT_INVESTORS = [
        {
            id: 1,
            full_name: "Islomov Sardor",
            login: "sardor_i",
            phone: "+998901112233",
            passport: "AB1234567",
            jshshir: "12345678901234",
            status: "active",
            registered_at: "2024-01-05",
            share_amount: 25000000,
            share_percent: 12
        },
        {
            id: 2,
            full_name: "Karimova Dilnoza",
            login: "dilnoza_k",
            phone: "+998909998877",
            passport: "AC9876543",
            jshshir: "23456789012345",
            status: "pending",
            registered_at: "2024-02-11",
            share_amount: 15000000,
            share_percent: 7
        },
        {
            id: 3,
            full_name: "Tursunov Aziz",
            login: "aziz_t",
            phone: "+998903334455",
            passport: "AA4567890",
            jshshir: "34567890123456",
            status: "active",
            registered_at: "2024-03-02",
            share_amount: 18000000,
            share_percent: 9
        },
        {
            id: 4,
            full_name: "Hamroyev Bekzod",
            login: "bekzod_h",
            phone: "+998935551122",
            passport: "AD7654321",
            jshshir: "45678901234567",
            status: "inactive",
            registered_at: "2024-04-19",
            share_amount: 0,
            share_percent: 0
        },
        {
            id: 5,
            full_name: "Rustamova Malika",
            login: "malika_r",
            phone: "+998933210987",
            passport: "AE1122334",
            jshshir: "56789012345678",
            status: "active",
            registered_at: "2024-05-27",
            share_amount: 22000000,
            share_percent: 11
        }
    ];

    // Load or initialize
    let investors = JSON.parse(localStorage.getItem('investors') || '[]');

    if (investors.length === 0) {
        investors = DEFAULT_INVESTORS;
        localStorage.setItem('investors', JSON.stringify(investors));
    }

    function saveToStorage() {
        localStorage.setItem('investors', JSON.stringify(investors));
    }

    function renderTable(list = investors) {
        let tbody = document.getElementById('investor-table-body');
        if (!tbody) return;

        tbody.innerHTML = "";

        list.forEach((item, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.full_name}</td>
                    <td>${item.login}</td>
                    <td>${item.phone}</td>
                    <td>${item.passport}</td>
                    <td>${item.jshshir}</td>
                    <td>${item.status}</td>
                    <td>${item.registered_at}</td>
                    <td>${item.share_amount}</td>
                    <td>${item.share_percent}</td>
                    <td>
                        <a href="${EDIT_ROUTE_BASE}/${item.id}/edit" class="me-2">
                            <img src="{{ asset('svg/edit-2.svg') }}">
                        </a>
                        <button onclick="deleteInvestor(${item.id})" style="border:none;background:none">
                            <img src="{{ asset('svg/trash.svg') }}">
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    function deleteInvestor(id) {
        investors = investors.filter(i => i.id !== id);
        saveToStorage();
        renderTable();
    }

    function applyFilters() {
        let search = document.getElementById('filter_search').value.toLowerCase();
        let status = document.getElementById('filter_status').value;

        let filtered = investors.filter(i =>
            (i.full_name.toLowerCase().includes(search) ||
             i.login.toLowerCase().includes(search) ||
             i.phone.includes(search)) &&
            (status ? i.status === status : true)
        );

        renderTable(filtered);
    }

    document.getElementById('filterBtn')?.addEventListener('click', applyFilters);

    renderTable();
</script>
