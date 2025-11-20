const ageLabels = ["0-7", "7-12", "12-18", "18-25", "25-40", "40-60", "60+"];
const maleData = window.ageMaleData || []; // Laraveldan kelsa: @json($maleData)
const femaleData = window.ageFemaleData || []; // Laraveldan kelsa: @json($femaleData)

// k-formatga o‘girish funksiyasi
function formatK(val) {
  if (val >= 1000) {
    return Math.round(val / 1000) + 'k';
  }
  return val.toString();
}

const ageChartOptions = {
    chart: {
        type: "bar",
        height: 370,
        toolbar: { show: false },
        fontFamily: "Montserrat, Arial, sans-serif",
    },
    series: [
        {
            name: "Erkaklar",
            data: maleData,
            color: "#5C6FA6",
        },
        {
            name: "Ayollar",
            data: femaleData,
            color: "#FFCC88",
        },
    ],
    xaxis: {
        categories: ageLabels,
        labels: {
            style: {
                fontSize: "15px",
                colors: "#7c8797",
                fontWeight: 500,
            },
        },
        axisBorder: { show: false },
        axisTicks: { show: false },
    },
    yaxis: {
        min: 0,
        max: Math.max(...maleData, ...femaleData) + 20,
        tickAmount: 4,
        labels: {
            style: {
                fontSize: "15px",
                colors: "#7c8797",
                fontWeight: 500,
            },
        },
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "60%",
            borderRadius: 6,
            endingShape: "rounded",
        },
    },
    dataLabels: {
        enabled: true,
        // position: "top",
        offsetY: 20,
        style: {
            fontSize: "16px",
            colors: ["#222"],
            fontWeight: 600,
        },
        formatter: function (val) {
            return formatK(val);
        },
    },
    legend: { show: false },
    tooltip: {
        y: {
            formatter: function (val) {
                return `${val} ta`;
            },
        },
    },
    grid: {
        borderColor: "#e8eaee",
        row: { colors: ["#f6f7fa", "transparent"], opacity: 0.8 },
        xaxis: { lines: { show: false } },
    },
    responsive: [
    {
      breakpoint: 576,
      options: {
        dataLabels: {
          enabled: false
        }
      }
    }
  ]
};

const ageChart = new ApexCharts(
    document.querySelector("#ageBarChart"),
    ageChartOptions
);

ageChart.render().then(() => {
    document.querySelectorAll(".legend-dot").forEach((dot) => {
        // dot.addEventListener("click", function () {
        //     const seriesName = this.getAttribute("data-series");
        //     ageChart.toggleSeries(seriesName);

        //     setTimeout(() => {
        //         const isActive =
        //             !ageChart.w.globals.collapsedSeries.includes(seriesName);
        //         this.classList.toggle("inactive", !isActive);
        //     }, 10);
        // });
    });
});
