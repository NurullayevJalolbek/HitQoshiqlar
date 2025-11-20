// 1. Foydalanuvchi tanlagan til (masalan: "uz", "ru", "en")
const locale = window.locale || "uz";

// 2. Ranglar: har bir academic_degree `id` uchun rang biriktiramiz
const degreeColorById = {
    1: "#659BE7",   // Moviy
    2: "#F8BD7A",   // Shaftoli
    3: "#8A63D2",   // Binafsha
    4: "#FF4C4C",   // Qizil
    5: "#3ABF7F",   // Yashil
    6: "#6A7D9C",   // Kul-ko'k
    7: "#FFC107",   // Sariq
    8: "#00BCD4",   // Moviy (ochroq)
    9: "#4CAF50",   // Yashil (chuqur)
    10: "#E91E63",  // Pushti
    11: "#FF9800",  // Apelsin
    12: "#9C27B0",  // Qora binafsha
    13: "#3F51B5",  // Indigo
    14: "#009688",  // Teal
    15: "#795548",  // Jigarrang
    16: "#607D8B",  // Kul ko‘k
    17: "#D32F2F",  // Qizil (chuqur)
    18: "#388E3C",  // Qoramtir yashil
    19: "#1976D2",  // Ochiq ko‘k
    20: "#F06292",  // Pushti (yorqin)
};


// 3. Har bir tarjimadan `name` ni chiqarib olish uchun funksiya
function getTranslatedLabel(item, lang = "uz") {
    if (!item.translations || !Array.isArray(item.translations))
        return item.name;

    const found = item.translations.find(
        (t) => t.language_url === lang && t.field_name === "name"
    );

    // Fallback: uzbekcha yoki asosiy name
    return found?.field_value || item.name;
}

// 4. Backenddan kelgan ma'lumot
const rawDegreeData = window.degreeChartData;

// 5. Har bir item uchun tarjima, rang va qiymatni tayyorlab olish
const academicDegreeData = rawDegreeData.map(( item, index) => {
    return {
        label: getTranslatedLabel(item, locale),
        value: item.compatriots_count || item.value || 0,
        color: degreeColorById[index + 1] || "#999",
    };
});

// 6. Umumiy sonini hisoblash
const academicDegreeTotal = academicDegreeData.reduce(
    (sum, item) => sum + item.value,
    0
);

// 7. ApexCharts Donut grafikasi
const academicDegreeDonutOptions = {
    chart: {
        type: "donut",
        height: 240,
        width: 240,
        fontFamily: "Montserrat, Arial, sans-serif",
        toolbar: { show: false },
    },
    series: academicDegreeData.map((x) => x.value),
    labels: academicDegreeData.map((x) => x.label),
    colors: academicDegreeData.map((x) => x.color),
    legend: { show: false },
    dataLabels: { enabled: false },
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
                            return `${academicDegreeTotal} ${window.translations.people}`;
                        },
                    },
                },
            },
        },
    },
    tooltip: {
        y: { formatter: (val) => `${val} ` },
    },
};

// 8. Grafikani chizish
const academicDegreeChart = new ApexCharts(
    document.querySelector("#academicDegreeDonutChart"),
    academicDegreeDonutOptions
);
academicDegreeChart.render();

// 9. Legenda yasash
function renderAcademicDegreeLegend() {
    const legend = document.getElementById("academicDegreeLegend");
    legend.innerHTML = academicDegreeData
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
renderAcademicDegreeLegend();
