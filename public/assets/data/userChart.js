// 1. Backenddan kelgan ma’lumot:
const roleData = window.roleChartData || [];

// 2. Ranglar ro'yxati:
const colors = ["#6A7D9C", "#CCCCCC", "#F8BD7A", "#659BE7"];

// 3. Ranggacha moslashtirilgan userChartData
const userChartData = roleData.map((role, idx) => ({
    ...role,
    color: colors[idx % colors.length], // ranglar aylana oladi
}));

const total = userChartData.reduce((sum, item) => sum + item.value, 0);

// 4. ApexCharts konfiguratsiyasi (siz yozganidek)
const donutOptions = {
    chart: {
        type: "donut",
        height: 240,
        width: 240,
        fontFamily: "Montserrat, Arial, sans-serif",
        toolbar: { show: false },
    },
    series: userChartData.map((x) => x.value),
    labels: userChartData.map((x) => x.label),
    colors: userChartData.map((x) => x.color),
    legend: { show: false },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 3,
        colors: ["#fff"],
    },
    plotOptions: {
        pie: {
            donut: {
                size: "60%",
                labels: {
                    show: true,
                    name: { show: false },
                    value: { show: true },
                    total: {
                        show: true,
                        label: "",
                        formatter: function () {
                            return `${total} ${window.translations.people}`;
                        },
                    },
                },
            },
        },
    },
    tooltip: {
        y: { formatter: (val) => `${val} ta` },
    },
};

const userChart = new ApexCharts(
    document.querySelector("#userDonutChart"),
    donutOptions
);
userChart.render();

// 5. Maxsus legenda
function renderCustomLegend() {
    const legend = document.getElementById("userChartLegend");
    legend.innerHTML = userChartData
        .map(
            (item) => `
    <div class="user-legend-row">
      <span class="user-legend-dot" style="background:${item.color}"></span>
      <span class="user-legend-label">${item.label}</span>
      <span class="user-legend-value">${item.value} </span>
    </div>
  `
        )
        .join("");
}
renderCustomLegend();
