// main.js
// Barcha logika DOM tayyor bo‘lganda ishga tushadi
document.addEventListener("DOMContentLoaded", function () {
    const doc = document; // ============================== // 1. SweetAlert2 konfiguratsiyasi // ============================== // Kalendar eventlarini o‘chirishda ishlatiladi

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-primary me-3",
            cancelButton: "btn btn-gray",
        },
        buttonsStyling: false,
    }); // ============================== // 2. Preloader // ==============================

    const preloader = doc.querySelector(".preloader");
    if (preloader) {
        setTimeout(function () {
            preloader.style.display = "none";
            const loaderEl = doc.querySelector(".loader-element");
            if (loaderEl) {
                loaderEl.classList.add("hide");
            }
        }, 1000);
    } // ============================== // 3. Bildirishnoma qo‘ng‘irog‘i // ==============================

    const notificationBell = doc.querySelector(".notification-bell");
    if (notificationBell) {
        notificationBell.addEventListener("click", function () {
            notificationBell.classList.remove("unread");
        });
    } // ============================== // 4. data-atributlar orqali background & color // ============================== // [data-background] -> style.background = url(...)

    Array.prototype.slice
        .call(doc.querySelectorAll("[data-background]"))
        .forEach(function (el) {
            const bg = el.getAttribute("data-background");
            if (bg) {
                el.style.background = "url(" + bg + ")";
            }
        }); // [data-background-lg] -> katta ekranlarda boshqa fon

    Array.prototype.slice
        .call(doc.querySelectorAll("[data-background-lg]"))
        .forEach(function (el) {
            if (document.body.clientWidth > 960) {
                const bg = el.getAttribute("data-background-lg");
                if (bg) {
                    el.style.background = "url(" + bg + ")";
                }
            }
        }); // [data-color] -> color style

    Array.prototype.slice
        .call(doc.querySelectorAll("[data-color]"))
        .forEach(function (el) {
            const color = el.getAttribute("data-color");
            if (color) {
                el.style.color = "url(" + color + ")";
            }
        }); // [data-background-color] -> background color

    Array.prototype.slice
        .call(doc.querySelectorAll("[data-background-color]"))
        .forEach(function (el) {
            const color = el.getAttribute("data-background-color");
            if (color) {
                el.style.background = "url(" + color + ")";
            }
        }); // ============================== // 5. Bootstrap Tooltip va Popover // ============================== // Tooltip

    Array.prototype.slice
        .call(doc.querySelectorAll('[data-bs-toggle="tooltip"]'))
        .forEach(function (el) {
            new bootstrap.Tooltip(el);
        }); // Popover

    Array.prototype.slice
        .call(doc.querySelectorAll('[data-bs-toggle="popover"]'))
        .map(function (el) {
            return new bootstrap.Popover(el);
        }); // ============================== // 6. Datepicker (vanillajs-datepicker) // ==============================

    Array.prototype.slice
        .call(doc.querySelectorAll("[data-datepicker]"))
        .forEach(function (el) {
            new Datepicker(el, {
                buttonClass: "btn",
            });
        }); // ============================== // 7. simple-datatables (#datatable) // ==============================

    const datatableEl = doc.getElementById("datatable");
    if (datatableEl) {
        new simpleDatatables.DataTable(datatableEl);
    } // ============================== // 8. noUiSlider – Range sliderlar // ============================== // 8.1. Oddiy .input-slider-container ichida bitta range slider

    if (doc.querySelector(".input-slider-container")) {
        Array.prototype.slice
            .call(doc.querySelectorAll(".input-slider-container"))
            .forEach(function (container) {
                const slider = container.querySelector(":scope .input-slider");
                const sliderId = slider.getAttribute("id");
                const minVal = slider.getAttribute("data-range-value-min");
                const maxVal = slider.getAttribute("data-range-value-max");

                const rangeValue = container.querySelector(
                    ":scope .range-slider-value"
                );
                const rangeValueId = rangeValue.getAttribute("id");
                const startVal = rangeValue.getAttribute(
                    "data-range-value-low"
                );

                const sliderNode = doc.getElementById(sliderId);
                const valueNode = doc.getElementById(rangeValueId);

                if (!sliderNode || !valueNode) return;

                noUiSlider.create(sliderNode, {
                    start: [parseInt(startVal)],
                    connect: [true, false],
                    range: {
                        min: [parseInt(minVal)],
                        max: [parseInt(maxVal)],
                    },
                });

                sliderNode.noUiSlider.on("update", function (values, handle) {
                    valueNode.textContent = Math.round(values[handle]);
                });
            });
    } // 8.2. Ikki tutqichli slider: #input-slider-range

    if (doc.getElementById("input-slider-range")) {
        const sliderRange = doc.getElementById("input-slider-range");
        const lowValueEl = doc.getElementById("input-slider-range-value-low");
        const highValueEl = doc.getElementById("input-slider-range-value-high");

        const elementsToUpdate = [lowValueEl, highValueEl];

        noUiSlider.create(sliderRange, {
            start: [
                parseInt(
                    lowValueEl.getAttribute("data-range-value-low") || "0"
                ),
                parseInt(
                    highValueEl.getAttribute("data-range-value-high") || "0"
                ),
            ],
            connect: true,
            tooltips: true,
            range: {
                min: parseInt(
                    sliderRange.getAttribute("data-range-value-min") || "0"
                ),
                max: parseInt(
                    sliderRange.getAttribute("data-range-value-max") || "100"
                ),
            },
        });

        sliderRange.noUiSlider.on("change", function (values, handle) {
            elementsToUpdate[handle].textContent = Math.round(values[handle]);
        });
    } // ============================== // 9. ApexCharts – Diagrammalar // ============================== // 9.1. Asosiy area chart (#chart)

    (function initMainAreaChart() {
        const chartEl = doc.getElementById("chart");
        if (!chartEl) return;

        const options = {
            chart: {
                height: 420,
                type: "area",
                fontFamily: "Inter",
                foreColor: "#4B5563",
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: false,
                        selection: false,
                        zoom: false,
                        zoomin: true,
                        zoomout: true,
                        pan: false,
                        reset: undefined,
                        customIcons: [],
                    },
                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ",",
                            headerCategory: "category",
                            headerValue: "value",
                            dateFormatter: (timestamp) =>
                                new Date(timestamp).toDateString(),
                        },
                    },
                    autoSelected: "zoom",
                },
            },
            dataLabels: { enabled: false },
            tooltip: {
                style: {
                    fontSize: "12px",
                    fontFamily: "Inter",
                },
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: "#F8BD7A",
                },
            },
            grid: {
                show: true,
                borderColor: "#f1f1f1",
                strokeDashArray: 1,
            },
            series: [
                {
                    name: "Users",
                    data: [95, 52, 78, 45, 19, 53, 60],
                },
            ],
            markers: {
                size: 5,
                strokeColors: "#ffffff",
                hover: {
                    size: undefined,
                    sizeOffset: 3,
                },
            },
            xaxis: {
                categories: [
                    "01 Feb",
                    "02 Feb",
                    "03 Feb",
                    "04 Feb",
                    "05 Feb",
                    "06 Feb",
                    "07 Feb",
                ],
                labels: {
                    style: {
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                },
                axisBorder: { color: "#f5e1c5" },
                axisTicks: { color: "#f1f1f1" },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: ["#4B5563"],
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                },
            },
            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        yaxis: { show: false },
                    },
                },
            ],
        };

        const chart = new ApexCharts(chartEl, options);
        chart.render();
    })(); // 9.2. Weekly sales – bar sparkline (#chart-weekly-sales)

    (function initWeeklySalesChart() {
        const el = doc.getElementById("chart-weekly-sales");
        if (!el) return;

        new ApexCharts(el, {
            series: [
                {
                    name: "Sales",
                    data: [32, 44, 37, 47, 42, 55, 47, 65],
                },
            ],
            chart: {
                type: "bar",
                width: "100%",
                height: 260,
                sparkline: { enabled: true },
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: "#4D4AE8",
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: "20%",
                    borderRadius: 5,
                    radiusOnLastStackedBar: true,
                    horizontal: false,
                    distributed: false,
                    endingShape: "rounded",
                    colors: {
                        backgroundBarColors: [
                            "#F2F4F6",
                            "#F8BD7A",
                            "#F2F4F6",
                            "#F8BD7A",
                        ],
                        backgroundBarRadius: 5,
                    },
                },
            },
            labels: [1, 2, 3, 4, 5, 6, 7, 8],
            xaxis: {
                categories: [
                    "Week 1",
                    "Week 2",
                    "Week 3",
                    "Week 4",
                    "Week 5",
                    "Week 6",
                    "Week 7",
                    "Week 8",
                ],
                crosshairs: { width: 1 },
            },
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: { highlightDataSeries: false },
                theme: "light",
                style: {
                    fontSize: "12px",
                    fontFamily: "Inter",
                },
                y: {
                    formatter: function (val) {
                        return "$ " + val + "k";
                    },
                },
            },
        }).render();
    })(); // 9.3. Users – area sparkline (#chart-users)

    (function initUsersChart() {
        const el = doc.getElementById("chart-users");
        if (!el) return;

        new ApexCharts(el, {
            series: [
                {
                    name: "Users",
                    data: [
                        120, 160, 200, 470, 420, 150, 470, 750, 650, 190, 140,
                    ],
                },
            ],
            labels: [
                "01 Feb",
                "02 Feb",
                "03 Feb",
                "04 Feb",
                "05 Feb",
                "06 Feb",
                "07 Feb",
                "08 Feb",
                "09 Feb",
                "10 Feb",
                "11 Feb",
            ],
            chart: {
                type: "area",
                width: "100%",
                height: 140,
                sparkline: { enabled: true },
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: "#31316A",
                },
            },
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: { highlightDataSeries: false },
                theme: "light",
                style: { fontSize: "12px", fontFamily: "Inter" },
            },
        }).render();
    })(); // 9.4. Revenue – area sparkline (#chart-revenue)

    (function initRevenueChart() {
        const el = doc.getElementById("chart-revenue");
        if (!el) return;

        new ApexCharts(el, {
            series: [
                {
                    name: "Revenue",
                    data: [
                        520, 560, 500, 570, 520, 550, 570, 550, 550, 590, 540,
                    ],
                },
            ],
            labels: [
                "01 Feb",
                "02 Feb",
                "03 Feb",
                "04 Feb",
                "05 Feb",
                "06 Feb",
                "07 Feb",
                "08 Feb",
                "09 Feb",
                "10 Feb",
                "11 Feb",
            ],
            chart: {
                type: "area",
                width: "100%",
                height: 140,
                sparkline: { enabled: true },
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: "#4D4AE8",
                },
            },
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: { highlightDataSeries: false },
                theme: "light",
                style: { fontSize: "12px", fontFamily: "Inter" },
            },
        }).render();
    })(); // 9.5. Customers – bar sparkline (#chart-customers)

    (function initCustomersChart() {
        const el = doc.getElementById("chart-customers");
        if (!el) return;

        new ApexCharts(el, {
            series: [
                {
                    name: "Customers",
                    data: [34, 29, 32, 38, 39, 35, 36],
                },
            ],
            chart: {
                type: "bar",
                width: "100%",
                height: 140,
                sparkline: { enabled: true },
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: "#4D4AE8",
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: "25%",
                    borderRadius: 5,
                    radiusOnLastStackedBar: true,
                    colors: {
                        backgroundBarColors: [
                            "#F2F4F6",
                            "#F8BD7A",
                            "#F8BD7A",
                            "#F2F4F6",
                        ],
                        backgroundBarRadius: 5,
                    },
                },
            },
            labels: [1, 2, 3, 4, 5, 6, 7],
            xaxis: {
                categories: [
                    "01 Feb",
                    "02 Feb",
                    "03 Feb",
                    "04 Feb",
                    "05 Feb",
                    "06 Feb",
                    "07 Feb",
                ],
                crosshairs: { width: 1 },
            },
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: { highlightDataSeries: false },
                theme: "light",
                style: {
                    fontSize: "12px",
                    fontFamily: "Inter",
                },
                y: {
                    formatter: function (val) {
                        return "$ " + val + "k";
                    },
                },
            },
        }).render();
    })(); // 9.6. App ranking – bar chart (#chart-app-ranking)

    (function initAppRankingChart() {
        const el = doc.getElementById("chart-app-ranking");
        if (!el) return;

        new ApexCharts(el, {
            series: [
                {
                    name: "Standard",
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
                },
                {
                    name: "Widgets",
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
                },
            ],
            chart: {
                type: "bar",
                height: 350,
                fontFamily: "Inter",
                foreColor: "#4B5563",
            },
            colors: ["#06A77D", "#31316A"],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "40%",
                    borderRadius: 10,
                    colors: {
                        backgroundBarColors: ["#fff"],
                        backgroundBarOpacity: 0.2,
                        backgroundBarRadius: 10,
                    },
                },
            },
            grid: { show: false },
            dataLabels: { enabled: false },
            legend: {
                show: true,
                fontSize: "14px",
                fontFamily: "Inter",
                fontWeight: 500,
                height: 40,
                offsetY: 10,
                markers: {
                    width: 14,
                    height: 14,
                    strokeWidth: 1,
                    strokeColor: "#f2f2f2",
                    radius: 50,
                },
            },
            stroke: {
                show: true,
                width: 2,
                colors: ["#ffffff"],
            },
            xaxis: {
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                ],
                labels: {
                    style: {
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                },
                axisBorder: { color: "#EBE3EE" },
                axisTicks: { color: "#f2f2f2" },
            },
            yaxis: { show: false },
            fill: { opacity: 1 },
            responsive: [
                {
                    breakpoint: 1500,
                    options: {
                        chart: { height: 350 },
                    },
                },
            ],
        }).render();
    })(); // 9.7. Traffic volumes – multi-line chart (#traffic-volumes-chart)

    (function initTrafficVolumesChart() {
        const el = doc.getElementById("traffic-volumes-chart");
        if (!el) return;

        const options = {
            series: [
                {
                    name: "Organic",
                    data: [7108, 9600, 10000, 8700, 12000, 15400, 19000],
                },
                {
                    name: "Social",
                    data: [4100, 6800, 7000, 6700, 7200, 14000, 12000],
                },
                {
                    name: "Refferals",
                    data: [1100, 3200, 4500, 3200, 3400, 5200, 4100],
                },
            ],
            colors: ["#4D4AE8", "#FD8E7A", "#06A77D", "#f0bc74"],
            chart: {
                height: 420,
                type: "line",
                fontFamily: "Inter",
                foreColor: "#4B5563",
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: false,
                        selection: false,
                        zoom: false,
                        zoomin: true,
                        zoomout: true,
                        pan: false,
                        reset: undefined,
                        customIcons: [],
                    },
                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ",",
                            headerCategory: "category",
                            headerValue: "value",
                            dateFormatter: (timestamp) =>
                                new Date(timestamp).toDateString(),
                        },
                    },
                    autoSelected: "zoom",
                },
            },
            dataLabels: { enabled: false },
            stroke: { curve: "smooth" },
            grid: {
                show: true,
                borderColor: "#f2f2f2",
                strokeDashArray: 1,
            },
            xaxis: {
                categories: [
                    "01 Feb",
                    "02 Feb",
                    "03 Feb",
                    "04 Feb",
                    "05 Feb",
                    "06 Feb",
                    "07 Feb",
                ],
                labels: {
                    style: {
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                },
                axisBorder: { color: "#f3c78e" },
                axisTicks: { color: "#f3c78e" },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: ["#4B5563"],
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                },
            },
            legend: {
                show: true,
                fontSize: "14px",
                fontFamily: "Inter",
                fontWeight: 400,
                height: 60,
                offsetY: 20,
                markers: {
                    width: 14,
                    height: 14,
                    strokeWidth: 1,
                    strokeColor: "#ffffff",
                    radius: 50,
                },
            },
            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        yaxis: { show: false },
                    },
                },
            ],
        };

        new ApexCharts(el, options).render();
    })(); // 9.8. Traffic share – gorizontal bar (#traffic-share-chart)

    (function initTrafficShareChart() {
        const el = doc.getElementById("traffic-share-chart");
        if (!el) return;

        new ApexCharts(el, {
            series: [
                {
                    name: "Visits",
                    data: [4, 7, 9, 29, 51],
                },
            ],
            chart: {
                type: "bar",
                height: 500,
                foreColor: "#4B5563",
                fontFamily: "Inter",
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    distributed: false,
                    barHeight: "40%",
                    borderRadius: 10,
                    colors: {
                        backgroundBarColors: ["#F2F4F6"],
                        backgroundBarOpacity: 0.2,
                        backgroundBarRadius: 10,
                    },
                },
            },
            colors: ["#4D4AE8"],
            dataLabels: {
                enabled: true,
                textAnchor: "middle",
                formatter: function (val, opts) {
                    return opts.w.globals.labels[opts.dataPointIndex];
                },
                offsetY: -1,
                dropShadow: { enabled: false },
                style: {
                    fontSize: "12px",
                    fontFamily: "Inter",
                    fontWeight: 400,
                },
            },
            grid: {
                show: false,
                borderColor: "#f1f1f1",
                strokeDashArray: 1,
            },
            legend: { show: false },
            yaxis: { labels: { show: false } },
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: { highlightDataSeries: false },
                theme: "light",
                style: {
                    fontSize: "12px",
                    fontFamily: "Inter",
                },
                y: {
                    formatter: function (val) {
                        return val + " %";
                    },
                },
            },
            xaxis: {
                categories: [
                    "Mail",
                    "Social",
                    "Organic",
                    "Referrals",
                    "Direct",
                ],
                labels: {
                    style: {
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                    offsetY: 5,
                },
                axisBorder: { color: "#f3c78e" },
                axisTicks: { color: "#f3c78e", offsetY: 5 },
            },
        }).render();
    })(); // ============================== // 10. "Load more" tugmasi (#loadOnClick) // ==============================

    const loadOnClickBtn = doc.getElementById("loadOnClick");
    if (loadOnClickBtn) {
        const extraContent = doc.getElementById("extraContent");
        const allLoadedText = doc.getElementById("allLoadedText");

        loadOnClickBtn.addEventListener("click", function () {
            loadOnClickBtn.classList.add("btn-loading");
            loadOnClickBtn.setAttribute("disabled", "true");

            setTimeout(function () {
                if (extraContent) {
                    extraContent.style.display = "block";
                }
                loadOnClickBtn.style.display = "none";
                if (allLoadedText) {
                    allLoadedText.style.display = "block";
                }
            }, 1500);
        });
    } // ============================== // 11. SmoothScroll – kotvachali linklar // ==============================

    if (typeof SmoothScroll !== "undefined") {
        new SmoothScroll('a[href*="#"]', {
            speed: 500,
            speedAsDuration: true,
        });
    } // ============================== // 12. SVG xarita (svgMap) – #state // ==============================

    if (doc.querySelector("#state") && typeof svgMap !== "undefined") {
        new svgMap({
            targetElementID: "state",
            colorMin: "#f5e1c5",
            colorMax: "#F8BD7A",
            flagType: "emoji",
            data: {
                data: {
                    visitors: {
                        name: "Visitors",
                        format: "{0} visitors",
                        thousandSeparator: ",",
                        thresholdMax: 500000,
                        thresholdMin: 0,
                    },
                    change: {
                        name: "Change by month",
                        format: "{0} %",
                    },
                },
                applyData: "visitors",
                values: {
                    US: { visitors: 272557, change: 4.73 },
                    CA: { visitors: 160000, change: 11.09 },
                    DE: { visitors: 120000, change: -2.3 },
                    GB: { visitors: 110000, change: 3.3 },
                    FR: { visitors: 100000, change: 1.3 },
                    ES: { visitors: 90000, change: 1.5 },
                    JP: { visitors: 56000, change: 3.5 },
                    IT: { visitors: 48000, change: 1 },
                    NL: { visitors: 40000, change: 2 },
                    RU: { visitors: 30000, change: 3.4 },
                    CN: { visitors: 50000, change: 6 },
                    IN: { visitors: 140000, change: 2 },
                    BR: { visitors: 40000, change: 5 },
                },
            },
        });
    } // ============================== // 13. Dropzone – fayl yuklash (#myDropzone) // ==============================

    if (doc.getElementById("myDropzone") && typeof Dropzone !== "undefined") {
        new Dropzone("#myDropzone", {
            url: "/file/post",
        });
    } // ============================== // 14. FullCalendar – Kalendar + CRUD // ==============================

    (function initCalendar() {
        const calendarEl = doc.getElementById("calendar");
        if (!calendarEl || typeof FullCalendar === "undefined") return; // Yangi event modal

        const newEventModalEl = doc.getElementById("modal-new-event");
        const newEventModal = new bootstrap.Modal(newEventModalEl);

        const eventTitleInput = doc.getElementById("eventTitle");
        const dateStartInput = doc.getElementById("dateStart");
        const dateEndInput = doc.getElementById("dateEnd");

        const datepickerStart = new Datepicker(dateStartInput, {
            buttonClass: "btn",
        });
        const datepickerEnd = new Datepicker(dateEndInput, {
            buttonClass: "btn",
        }); // Edit event modal

        const editEventModalEl = doc.getElementById("modal-edit-event");
        const editEventModal = new bootstrap.Modal(editEventModalEl);

        const eventTitleEditInput = doc.getElementById("eventTitleEdit");
        const dateStartEditInput = doc.getElementById("dateStartEdit");
        const dateEndEditInput = doc.getElementById("dateEndEdit");

        const datepickerStartEdit = new Datepicker(dateStartEditInput, {
            buttonClass: "btn",
        });
        const datepickerEndEdit = new Datepicker(dateEndEditInput, {
            buttonClass: "btn",
        });

        let selectedEventId = null;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            selectable: true,
            initialView: "dayGridMonth",
            themeSystem: "bootstrap",
            initialDate: "2020-11-19",
            editable: true,
            events: [
                {
                    id: 1,
                    title: "Call with Jane",
                    start: "2020-11-18",
                    end: "2020-11-19",
                    className: "bg-red",
                },
                {
                    id: 2,
                    title: "Dinner meeting",
                    start: "2020-11-20",
                    end: "2020-11-21",
                    className: "bg-orange",
                },
                {
                    id: 3,
                    title: "Black Friday",
                    start: "2020-11-21",
                    end: "2020-11-22",
                    className: "bg-secondary",
                },
                {
                    id: 4,
                    title: "Cyber Week",
                    start: "2020-11-22",
                    end: "2020-11-29",
                    className: "bg-blue",
                },
                {
                    id: 5,
                    title: "HackTM conference",
                    start: "2020-12-03",
                    end: "2020-12-04",
                    className: "bg-purple",
                },
                {
                    id: 6,
                    title: "Digital event",
                    start: "2020-12-07",
                    end: "2020-12-10",
                    className: "bg-info",
                },
                {
                    id: 7,
                    title: "Marketing event",
                    start: "2020-12-10",
                    end: "2020-12-11",
                    className: "bg-yellow",
                },
                {
                    id: 8,
                    title: "Dinner with Parents",
                    start: "2020-12-19",
                    end: "2020-12-20",
                    className: "bg-green",
                },
                {
                    id: 9,
                    title: "Summer Hackaton",
                    start: "2020-12-20",
                    end: "2020-12-23",
                    className: "bg-blue",
                },
                {
                    id: 10,
                    title: "Dinner with partners",
                    start: "2020-12-23",
                    end: "2020-12-25",
                    className: "bg-green",
                },
            ],
            buttonText: {
                prev: "Previous",
                next: "Next",
            },
            dateClick: function (info) {
                // Yangi event qo‘shish modalini ochish
                newEventModal.show(); // title ni tozalash

                if (eventTitleInput) eventTitleInput.value = ""; // Tanlangan sanani datepickerga set qilamiz

                datepickerStart.setDate(info.date);
                const endDate = new Date(info.date);
                endDate.setDate(endDate.getDate() + 1);
                datepickerEnd.setDate(endDate); // Modal ochilgandan keyin inputga fokus

                newEventModalEl.addEventListener(
                    "shown.bs.modal",
                    function handleShown() {
                        eventTitleInput && eventTitleInput.focus(); // eventni qayta-qayta qo‘shmaslik uchun listenerni olib tashlaymiz
                        newEventModalEl.removeEventListener(
                            "shown.bs.modal",
                            handleShown
                        );
                    }
                );
            },
            eventClick: function (info) {
                // Tahrirlash uchun eventni olib kelamiz
                selectedEventId = info.event.id;
                if (eventTitleEditInput) {
                    eventTitleEditInput.value = info.event.title;
                }

                datepickerStartEdit.setDate(info.event.start);
                datepickerEndEdit.setDate(
                    info.event.end ? info.event.end : info.event.start
                );

                editEventModal.show();

                editEventModalEl.addEventListener(
                    "shown.bs.modal",
                    function handleShown() {
                        eventTitleEditInput && eventTitleEditInput.focus();
                        editEventModalEl.removeEventListener(
                            "shown.bs.modal",
                            handleShown
                        );
                    }
                );
            },
        });

        calendar.render(); // Yangi event formasi (#addNewEventForm)

        const addNewEventForm = doc.getElementById("addNewEventForm");
        if (addNewEventForm) {
            addNewEventForm.addEventListener("submit", function (e) {
                e.preventDefault();

                const title = eventTitleInput.value;
                const startDate = moment(datepickerStart.getDate()).format(
                    "YYYY-MM-DD"
                );
                const endDate = moment(datepickerEnd.getDate()).format(
                    "YYYY-MM-DD"
                );

                if (!title) return;

                calendar.addEvent({
                    id: 10000 * Math.random(),
                    title: title,
                    start: startDate,
                    end: endDate,
                    className: "bg-blue",
                    dragabble: true,
                });

                newEventModal.hide();
            });
        } // Eventni tahrirlash formasi (#editEventForm)

        const editEventForm = doc.getElementById("editEventForm");
        if (editEventForm) {
            editEventForm.addEventListener("submit", function (e) {
                e.preventDefault();

                const eventObj = calendar.getEventById(selectedEventId);
                if (!eventObj) return;

                const newStart = moment(datepickerStartEdit.getDate()).format(
                    "YYYY-MM-DD"
                );
                const newEnd = moment(datepickerEndEdit.getDate()).format(
                    "YYYY-MM-DD"
                );

                eventObj.setProp("title", eventTitleEditInput.value);
                eventObj.setStart(newStart);
                eventObj.setEnd(newEnd);

                editEventModal.hide();
            });
        } // Eventni o‘chirish (#deleteEvent + SweetAlert2)

        const deleteEventBtn = doc.getElementById("deleteEvent");
        if (deleteEventBtn) {
            deleteEventBtn.addEventListener("click", function () {
                swalWithBootstrapButtons
                    .fire({
                        icon: "error",
                        title: "Confirm deletion",
                        text: "Are you sure you want to delete this event?",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                    })
                    .then(function (result) {
                        if (result.value) {
                            swalWithBootstrapButtons.fire(
                                "Deleted!",
                                "The event has been deleted.",
                                "success"
                            );
                            const ev = calendar.getEventById(selectedEventId);
                            if (ev) ev.remove();
                        } else if (
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            editEventModal.hide();
                        }
                    });
            });
        }
    })(); // ============================== // 15. Footer – joriy yil (.current-year) // ==============================

    const currentYearEl = doc.querySelector(".current-year");
    if (currentYearEl) {
        currentYearEl.textContent = new Date().getFullYear();
    } // ============================== // 16. Glide slayderlar // ==============================

    if (doc.querySelector(".glide")) {
        new Glide(".glide", {
            type: "carousel",
            startAt: 0,
            perView: 3,
        }).mount();
    }

    if (doc.querySelector(".glide-testimonials")) {
        new Glide(".glide-testimonials", {
            type: "carousel",
            startAt: 0,
            perView: 1,
            autoplay: 2000,
        }).mount();
    }

    if (doc.querySelector(".glide-clients")) {
        new Glide(".glide-clients", {
            type: "carousel",
            startAt: 0,
            perView: 5,
            autoplay: 2000,
        }).mount();
    }

    if (doc.querySelector(".glide-autoplay")) {
        new Glide(".glide-autoplay", {
            type: "carousel",
            startAt: 0,
            perView: 1,
            autoplay: 2000,
        }).mount();
    }

    if (doc.querySelector(".glide-news-widget")) {
        new Glide(".glide-news-widget", {
            type: "carousel",
            startAt: 0,
            perView: 3,
            autoplay: 2000,
        }).mount();
    } // ============================== // 17. Leaflet xarita (#map) // ==============================

    (function initLeafletMap() {
        const mapEl = doc.querySelector("#map");
        if (!mapEl || typeof L === "undefined") return;

        const customIcon = L.icon({
            iconUrl: "../assets/img/marker.svg",
            iconSize: [38, 95],
            shadowSize: [50, 64],
            iconAnchor: [22, 94],
            shadowAnchor: [4, 62],
            popupAnchor: [-3, -76],
        });

        const map = L.map("map").setView([37.57, -122.26], 10);

        L.tileLayer(
            "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
            {
                attribution:
                    'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: "mapbox/light-v10",
                accessToken:
                    "pk.eyJ1Ijoiem9sdGFudGhlbWVzYmVyZyIsImEiOiJjazZqaWUwcWswYTBvM21td2Jmcm5mYmdyIn0.7_5YCbbOFRnvqZzCNDo9fw",
            }
        ).addTo(map);

        const locations = [
            {
                url: "#",
                latLng: [37.7, -122.41],
                name: "Call with Jane",
                date: "Tomorrow at 12:30 PM",
            },
            {
                url: "#",
                latLng: [37.59, -122.39],
                name: "Meeting with John",
                date: "In about 5 minutes",
            },
            {
                url: "#",
                latLng: [37.52, -122.29],
                name: "Marketing event",
                date: "Today at 1:00 PM",
            },
            {
                url: "#",
                latLng: [37.37, -122.12],
                name: "Interview with Google",
                date: "In 2 hours",
            },
            {
                url: "#",
                latLng: [37.36, -121.94],
                name: "Summer Hackaton",
                date: "In two days at 15:00 PM",
            },
        ];

        locations.map(function (item) {
            const popupContent =
                '<a href="' +
                item.url +
                '" class="card card-article-wide border-0 flex-column no-gutters no-hover">' +
                '<div class="card-body py-0 d-flex flex-column justify-content-between col-12">' +
                '<h4 class="h5 fw-normal mb-2">' +
                item.name +
                "</h4>" +
                '<div class="d-flex"><div class="icon icon-xs icon-tertiary me-2">' +
                '<span class="fas fa-clock"></span></div>' +
                '<div class="font-xs text-dark">' +
                item.date +
                "</div></div>" +
                "</div>" +
                "</a>";

            L.marker(item.latLng, { icon: customIcon })
                .addTo(map)
                .bindPopup(popupContent);
        });
    })(); // ============================== // 18. Choices – selectlar // ==============================

    const singleStateSelect = doc.getElementById("state");
    if (singleStateSelect && typeof Choices !== "undefined") {
        new Choices(singleStateSelect);
    }

    const statesSelect = doc.getElementById("states");
    if (statesSelect && typeof Choices !== "undefined") {
        new Choices(statesSelect);
    } // ============================== // 19. SortableJS – Kanban board // ==============================

    if (doc.body.clientWidth > 960 && typeof Sortable !== "undefined") {
        const col1 = doc.getElementById("kanbanColumn1");
        if (col1) new Sortable(col1, { group: "shared" });

        const col2 = doc.getElementById("kanbanColumn2");
        if (col2) new Sortable(col2, { group: "shared" });

        const col3 = doc.getElementById("kanbanColumn3");
        if (col3) new Sortable(col3, { group: "shared" });

        const col4 = doc.getElementById("kanbanColumn4");
        if (col4) new Sortable(col4, { group: "shared" });
    } // ============================== // 20. CountUp – Tarif narxlari toggling (#billingSwitch) // ==============================

    const billingSwitch = doc.getElementById("billingSwitch");
    if (billingSwitch && typeof countUp !== "undefined") {
        const priceStandardCounter = new countUp.CountUp("priceStandard", 99, {
            startVal: 199,
        });
        const pricePremiumCounter = new countUp.CountUp("pricePremium", 199, {
            startVal: 299,
        });

        billingSwitch.addEventListener("change", function () {
            if (billingSwitch.checked) {
                priceStandardCounter.start();
                pricePremiumCounter.start();
            } else {
                priceStandardCounter.reset();
                pricePremiumCounter.reset();
            }
        });
    }
});
