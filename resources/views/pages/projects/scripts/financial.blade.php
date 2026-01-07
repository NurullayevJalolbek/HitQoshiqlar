// =================== FINANCIAL TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/financial.blade.php

let currentDividendPage = 1;
const itemsPerPage = 5;

function displayFinancial(p) {
    document.getElementById('totalValue').textContent = formatMoney(p.total_value);
    document.getElementById('minShare').textContent = formatMoney(p.min_share);
    document.getElementById('yearlyProfit').textContent = p.yearly_profit + '%';
    document.getElementById('fundingStatus').textContent = p.funding_status + '%';
    document.getElementById('investmentPeriod').textContent = p.investment_period;
    document.getElementById('profitability').textContent = p.profitability;
    document.getElementById('distributionIndicators').textContent = p.distribution_indicators;
    document.getElementById('distributionStart').textContent = p.distribution_start;
    document.getElementById('lastDividend').textContent = p.last_dividend + '%';

    displayDividendHistory(p.dividend_history);
}

function displayDividendHistory(dividendHistory) {
    const historyContainer = document.getElementById('dividendHistory');
    const paginationContainer = document.getElementById('dividendPagination');
    const summaryEl = document.getElementById('dividendSummary');

    if (!dividendHistory || dividendHistory.length === 0) {
        historyContainer.innerHTML = `
            <div class="text-center py-4 text-muted">
                <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                <p>Dividendlar tarixi mavjud emas</p>
            </div>
        `;
        if (paginationContainer) paginationContainer.innerHTML = '';
        if (summaryEl) summaryEl.textContent = '';
        return;
    }

    const totalPages = Math.ceil(dividendHistory.length / itemsPerPage);
    const startIndex = (currentDividendPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedItems = dividendHistory.slice(startIndex, endIndex);

    // Summary
    const total = dividendHistory.length;
    const start = startIndex + 1;
    const end = Math.min(endIndex, total);
    if (summaryEl) {
        summaryEl.textContent = `${start} - ${end} / Jami: ${total}`;
    }

    historyContainer.innerHTML = `
        <table class="table user-table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th><i class="bi bi-calendar3 me-1"></i>Sana</th>
                    <th><i class="bi bi-percent me-1"></i>Dividend foizi</th>
                    <th><i class="bi bi-check-circle me-1"></i>Holati</th>
                </tr>
            </thead>
            <tbody>
                ${paginatedItems.map(item => {
                    const statusClass = item.status === 'To\'langan' ? 'status-badge-paid' : 'status-badge-pending';
                    const statusIcon = item.status === 'To\'langan' ? 'bi-check-circle-fill' : 'bi-clock';
                    return `
                        <tr>
                            <td>
                                <i class="bi bi-calendar-event me-1 text-muted"></i>
                                <strong>${item.date}</strong>
                            </td>
                            <td>
                                <span style="font-size: 1.1rem; font-weight: 600; color: var(--success-color);">
                                    ${item.amount}%
                                </span>
                            </td>
                            <td>
                                <span class="${statusClass}">
                                    <i class="bi ${statusIcon}"></i>
                                    ${item.status}
                                </span>
                            </td>
                        </tr>
                    `;
                }).join('')}
            </tbody>
        </table>
    `;

    if (totalPages > 1) {
        displayDividendPagination(totalPages);
    } else {
        if (paginationContainer) paginationContainer.innerHTML = '';
    }
}

function displayDividendPagination(totalPages) {
    const paginationContainer = document.getElementById('dividendPagination');
    if (!paginationContainer) return;

    let paginationHTML = '<ul class="pagination pagination-sm mb-0 mt-2">';

    // Previous
    paginationHTML += `
        <li class="page-item ${currentDividendPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${currentDividendPage - 1})">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>
    `;

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
            <li class="page-item ${i === currentDividendPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${i})">
                    ${i}
                </a>
            </li>
        `;
    }

    // Next
    paginationHTML += `
        <li class="page-item ${currentDividendPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${currentDividendPage + 1})">
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </li>
    `;

    paginationHTML += '</ul>';
    paginationContainer.innerHTML = paginationHTML;
}

function changeDividendPage(page) {
    if (page < 1 || !projectData || !projectData.dividend_history) return;
    const totalPages = Math.ceil(projectData.dividend_history.length / itemsPerPage);
    if (page > totalPages) return;

    currentDividendPage = page;
    displayDividendHistory(projectData.dividend_history);

    // Scroll to top of table
    const historyContainer = document.getElementById('dividendHistory');
    historyContainer.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}