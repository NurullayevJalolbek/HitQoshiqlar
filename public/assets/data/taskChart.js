document.addEventListener("DOMContentLoaded", function () {
    const taskTitles = window.userTasks || [];
    const userRole = String(window.userRole || "guest");
    const container = document.getElementById("taskChartLegend");

    if (!container) return;

    // 1. Topshiriqlarni ro'yxat ko'rinishida chiqarish
    container.innerHTML = taskTitles
        .map(
            (title, idx) => `
            <div class="task-item">
                <span class="task-number">${idx + 1}.</span>
                <span class="task-text" title="${title}">${title}</span>
            </div>
        `
        )
        .join("");

    // 2. Rolidan kelib chiqib yo'nalishni aniqlash
    let basePath = "#";
    if (userRole === "employee") {
        basePath = "/employee/tasks/index";
    } else if (userRole === "volunteer") {
        basePath = "/volunteer/tasks/index";
    }

    // 3. "Barchasi →" tugmasini qo'shish
    const allBtn = document.createElement("div");
    allBtn.className = "task-all-wrapper";
    allBtn.innerHTML = `<a href="${basePath}" class="task-all-link">${window.translations.all} →</a>`;
    container.appendChild(allBtn);
});
