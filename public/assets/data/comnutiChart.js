const workloadData = window.workloadData || [];
const taskDone = workloadData.filter(
    (t) => t.status === window.translations.done
).length;
const percent = ((taskDone / workloadData.length) * 100).toFixed(1); // 37.5%

const donutChart = new ApexCharts(
    document.querySelector("#comnutiDonutChart"),
    {
        chart: {
            type: "donut",
            height: 240,
            width: 240,
            toolbar: { show: false },
            fontFamily: "Montserrat, sans-serif",
        },
        series: [taskDone, workloadData.length - taskDone],
        labels: [window.translations.done, window.translations.pending],
        colors: ["#22c55e", "#d1d5db"],
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: {
            show: true,
            width: 3,
            colors: ["#fff"],
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "75%",
                    labels: {
                        show: true,
                        name: { show: true, offsetY: -10 },
                        value: { show: true, fontSize: "18px", offsetY: 10 },
                        total: {
                            show: true,
                            name: { show: false },
                            value: { show: false },
                            label: window.translations.productivity,
                            fontSize: "8px",
                            color: "#111",
                            fontWeight: 600,
                            formatter: function () {
                                return `${percent}%`;
                            },
                        },
                    },
                },
            },
        },
    }
);

donutChart.render();

// Task legend (ro'yxati)
function renderWorkloadLegend(showAll = false) {
    const legend = document.getElementById("comnutiChartLegend");
    legend.className = "comnuti-chart__legend";

    const visibleTasks = showAll ? workloadData : workloadData.slice(0, 5);

    legend.innerHTML = visibleTasks
        .map((task) => {
            const isDone = task.status === window.translations.done;
            const badgeClass = isDone
                ? "task-badge-done"
                : "task-badge-pending";

            return `
                <div class="task-row">
                    <span class="task-label">${task.label}</span>
                    <span class="task-badge ${badgeClass}">${task.status}</span>
                </div>
            `;
        })
        .join("");

    if (workloadData.length > 5) {
        const toggleBtn = document.createElement("a");
        toggleBtn.textContent = showAll ? "Kamroq ↑" : "Ko'proq ↓";
        toggleBtn.classList.add("task-all-link");
        toggleBtn.style.cursor = "pointer";
        toggleBtn.onclick = () => renderWorkloadLegend(!showAll);
        legend.append(toggleBtn);
    }
}

// Dastlab 5 tasi chiqsin
renderWorkloadLegend();
