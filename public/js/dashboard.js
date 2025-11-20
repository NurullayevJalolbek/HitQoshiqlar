// flag emoji
const ISO3_TO_ISO2 = {
    AFG: "AF",
    ALB: "AL",
    DZA: "DZ",
    ASM: "AS",
    AND: "AD",
    AGO: "AO",
    AIA: "AI",
    ATA: "AQ",
    ATG: "AG",
    ARG: "AR",
    ARM: "AM",
    ABW: "AW",
    AUS: "AU",
    AUT: "AT",
    AZE: "AZ",
    BHS: "BS",
    BHR: "BH",
    BGD: "BD",
    BRB: "BB",
    BLR: "BY",
    BEL: "BE",
    BLZ: "BZ",
    BEN: "BJ",
    BMU: "BM",
    BTN: "BT",
    BOL: "BO",
    BES: "BQ",
    BIH: "BA",
    BWA: "BW",
    BVT: "BV",
    BRA: "BR",
    IOT: "IO",
    BRN: "BN",
    BGR: "BG",
    BFA: "BF",
    BDI: "BI",
    CPV: "CV",
    KHM: "KH",
    CMR: "CM",
    CAN: "CA",
    CYM: "KY",
    CAF: "CF",
    TCD: "TD",
    CHL: "CL",
    CHN: "CN",
    CXR: "CX",
    CCK: "CC",
    COL: "CO",
    COM: "KM",
    COG: "CG",
    COD: "CD",
    COK: "CK",
    CRI: "CR",
    CIV: "CI",
    HRV: "HR",
    CUB: "CU",
    CUW: "CW",
    CYP: "CY",
    CZE: "CZ",
    DNK: "DK",
    DJI: "DJ",
    DMA: "DM",
    DOM: "DO",
    ECU: "EC",
    EGY: "EG",
    SLV: "SV",
    GNQ: "GQ",
    ERI: "ER",
    EST: "EE",
    SWZ: "SZ",
    ETH: "ET",
    FLK: "FK",
    FRO: "FO",
    FJI: "FJ",
    FIN: "FI",
    FRA: "FR",
    GUF: "GF",
    PYF: "PF",
    ATF: "TF",
    GAB: "GA",
    GMB: "GM",
    GEO: "GE",
    DEU: "DE",
    GHA: "GH",
    GIB: "GI",
    GRC: "GR",
    GRL: "GL",
    GRD: "GD",
    GLP: "GP",
    GUM: "GU",
    GTM: "GT",
    GGY: "GG",
    GIN: "GN",
    GNB: "GW",
    GUY: "GY",
    HTI: "HT",
    HMD: "HM",
    VAT: "VA",
    HND: "HN",
    HKG: "HK",
    HUN: "HU",
    ISL: "IS",
    IND: "IN",
    IDN: "ID",
    IRN: "IR",
    IRQ: "IQ",
    IRL: "IE",
    IMN: "IM",
    ISR: "IL",
    ITA: "IT",
    JAM: "JM",
    JPN: "JP",
    JEY: "JE",
    JOR: "JO",
    KAZ: "KZ",
    KEN: "KE",
    KIR: "KI",
    PRK: "KP",
    KOR: "KR",
    KWT: "KW",
    KGZ: "KG",
    LAO: "LA",
    LVA: "LV",
    LBN: "LB",
    LSO: "LS",
    LBR: "LR",
    LBY: "LY",
    LIE: "LI",
    LTU: "LT",
    LUX: "LU",
    MAC: "MO",
    MDG: "MG",
    MWI: "MW",
    MYS: "MY",
    MDV: "MV",
    MLI: "ML",
    MLT: "MT",
    MHL: "MH",
    MTQ: "MQ",
    MRT: "MR",
    MUS: "MU",
    MYT: "YT",
    MEX: "MX",
    FSM: "FM",
    MDA: "MD",
    MCO: "MC",
    MNG: "MN",
    MNE: "ME",
    MSR: "MS",
    MAR: "MA",
    MOZ: "MZ",
    MMR: "MM",
    NAM: "NA",
    NRU: "NR",
    NPL: "NP",
    NLD: "NL",
    NCL: "NC",
    NZL: "NZ",
    NIC: "NI",
    NER: "NE",
    NGA: "NG",
    NIU: "NU",
    NFK: "NF",
    MKD: "MK",
    MNP: "MP",
    NOR: "NO",
    OMN: "OM",
    PAK: "PK",
    PLW: "PW",
    PSE: "PS",
    PAN: "PA",
    PNG: "PG",
    PRY: "PY",
    PER: "PE",
    PHL: "PH",
    PCN: "PN",
    POL: "PL",
    PRT: "PT",
    PRI: "PR",
    QAT: "QA",
    REU: "RE",
    ROU: "RO",
    RUS: "RU",
    RWA: "RW",
    BLM: "BL",
    SHN: "SH",
    KNA: "KN",
    LCA: "LC",
    MAF: "MF",
    SPM: "PM",
    VCT: "VC",
    WSM: "WS",
    SMR: "SM",
    STP: "ST",
    SAU: "SA",
    SEN: "SN",
    SRB: "RS",
    SYC: "SC",
    SLE: "SL",
    SGP: "SG",
    SXM: "SX",
    SVK: "SK",
    SVN: "SI",
    SLB: "SB",
    SOM: "SO",
    ZAF: "ZA",
    SGS: "GS",
    SSD: "SS",
    ESP: "ES",
    LKA: "LK",
    SDN: "SD",
    SUR: "SR",
    SJM: "SJ",
    SWE: "SE",
    CHE: "CH",
    SYR: "SY",
    TWN: "TW",
    TJK: "TJ",
    TZA: "TZ",
    THA: "TH",
    TLS: "TL",
    TGO: "TG",
    TKL: "TK",
    TON: "TO",
    TTO: "TT",
    TUN: "TN",
    TUR: "TR",
    TKM: "TM",
    TCA: "TC",
    TUV: "TV",
    UGA: "UG",
    UKR: "UA",
    ARE: "AE",
    GBR: "GB",
    USA: "US",
    UMI: "UM",
    URY: "UY",
    UZB: "UZ",
    VUT: "VU",
    VEN: "VE",
    VNM: "VN",
    VGB: "VG",
    VIR: "VI",
    WLF: "WF",
    ESH: "EH",
    YEM: "YE",
    ZMB: "ZM",
    ZWE: "ZW",
};

function getISO2(feature) {
    const code3 =
        feature.id || feature.properties.iso_a3 || feature.properties.ADM0_A3;
    let code2 = ISO3_TO_ISO2[code3];
    if (!code2)
        code2 = (
            feature.properties.iso_a2 ||
            feature.properties.ISO_A2 ||
            ""
        ).toUpperCase();
    return code2 ? code2.toLowerCase() : "";
}

function getFlagEmoji(iso2) {
    if (!iso2 || iso2.length !== 2) return "";
    return String.fromCodePoint(
        ...iso2
            .toUpperCase()
            .split("")
            .map((c) => 127397 + c.charCodeAt())
    );
}

let population = window.population.population;
let ids = window.population.ids;

const values = Object.values(population);
const minPop = Math.min(...values);
const maxPop = Math.max(...values);

renderMap({ minPop, maxPop });

// 3. map yaratish
const map = L.map("map", {
    zoomControl: false,
    minZoom: 2,
    maxZoom: 8,
    maxBounds: [
        [-90, -180],
        [90, 180],
    ],
    attributionControl: false,
    zoomAnimation: true,
    fadeAnimation: true,
    inertia: true,
    inertiaDeceleration: 3500,
    inertiaMaxSpeed: 1200,
}).setView([25, 20], 2);

L.tileLayer("", { attribution: "" }).addTo(map);

let countryLabels = [];
let countryCenters = [];
let geojsonLayer,
    countryFeatures = [];

// 4. Asosiy render funksiyasi
function renderMap({ minPop, maxPop }) {
    fetch(
        "https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json"
    )
        .then((res) => res.json())
        .then((geojson) => {
            function getColor(pop) {
                if (pop == null) return "#ecf2ff";
                const t = Math.max(
                    0,
                    Math.min(1, (pop - minPop) / (maxPop - minPop))
                );
                const r = Math.round(236 + (106 - 236) * t);
                const g = Math.round(242 + (125 - 242) * t);
                const b = Math.round(255 + (156 - 255) * t);
                return `rgb(${r},${g},${b})`;
            }

            function style(feature) {
                const code = feature.id || feature.properties.iso_a3;
                if (code === "UZB") {
                    return {
                        fillColor: "#3399FF",
                        color: "#fff",
                        weight: 2,
                        fillOpacity: 1,
                        opacity: 1,
                    };
                }
                const pop = population[code];
                return {
                    fillColor: getColor(pop),
                    weight: 1,
                    color: "#fff",
                    fillOpacity: 0.88,
                };
            }

            function highlightFeature(e) {
                let layer = e.target;
                let code =
                    layer.feature.id || layer.feature.properties.iso_a3 || "";
                let name =
                    layer.feature.properties.name ||
                    layer.feature.properties.ADMIN ||
                    "";
                let iso2 = getISO2(layer.feature);
                let flag = getFlagEmoji(iso2);
                if (code === "UZB") {
                    showTooltip(
                        {
                            name: "O‘zbekiston",
                            flag: flag,
                            creative: "Mehr va do‘stlik yurti)",
                        },
                        e.originalEvent
                    );
                    layer.setStyle({
                        fillOpacity: 1,
                        color: "#1444e8",
                        weight: 3,
                    });
                } else {
                    showTooltip(
                        {
                            name: name,
                            flag: flag,
                            pop:
                                typeof population[code] === "number"
                                    ? population[code].toLocaleString("en-US")
                                    : "No data",
                            creative: null,
                        },
                        e.originalEvent
                    );
                    layer.setStyle({
                        fillColor: "#F8BD7A",
                        weight: 2,
                        color: "#1F2937",
                        fillOpacity: 1,
                    });
                }
            }

            function resetHighlight(e) {
                geojsonLayer.resetStyle(e.target);
                hideTooltip();
            }
            function moveTooltip(e) {
                updateTooltipPosition(e.originalEvent);
            }
            geojsonLayer = L.geoJson(geojson, {
                style,
                filter: (feature) =>
                    feature.id !== "ATA" &&
                    feature.properties.name !== "Antarctica",
                onEachFeature: (feature, layer) => {
                    countryFeatures.push({ feature, layer });
                    layer.on({
                        mouseover: highlightFeature,
                        mouseout: resetHighlight,
                        mousemove: moveTooltip,
                        click: function (e) {
                            const feature = e.target.feature;
                            const code = feature.id || feature.properties.iso_a3 || "";

                            const countryId = ids[code];

                            if (!countryId) return;

                            const pathParts = window.location.pathname.split("/");
                            const moduleName = pathParts[1] || "volunteer";

                            const baseUrl = window.location.origin;
                            const url = `${baseUrl}/${moduleName}/compatriots?search=&country_id=${countryId}`;

                            window.location.href = url;
                        }
                    });
                    try {
                        const name =
                            feature.properties.name ||
                            feature.properties.ADMIN ||
                            "";
                        if (name && feature.geometry) {
                            const center =
                                turf.centroid(feature).geometry.coordinates;
                            const iso2 = getISO2(feature);
                            const label = L.tooltip({
                                permanent: true,
                                direction: "center",
                                className: "country-label",
                                interactive: false,
                                offset: [0, 0],
                                opacity: 0.88,
                            })
                                .setContent(`${name}`)
                                .setLatLng([center[1], center[0]]);
                            countryLabels.push(label);
                            countryCenters.push({
                                name: name,
                                code: feature.id || feature.properties.iso_a3,
                                iso2: iso2,
                                flag: getFlagEmoji(iso2),
                                center: [center[1], center[0]],
                                layer: layer,
                                feature: feature,
                            });
                        }
                    } catch (e) {}
                },
            }).addTo(map);

            function toggleLabels() {
                const z = map.getZoom();
                countryLabels.forEach((l) => {
                    if (z >= 4) {
                        if (!map.hasLayer(l)) map.addLayer(l);
                    } else {
                        if (map.hasLayer(l)) map.removeLayer(l);
                    }
                });
            }
            map.on("zoomend", toggleLabels);
            toggleLabels();

            setupSearch();
        });
}

// search
function setupSearch() {
    const searchInput = document.getElementById("searchInput");
    const searchList = document.getElementById("searchList");
    let searchResults = [],
        activeIndex = -1;

    function showSearchList() {
        searchList.style.display = "block";
    }
    function hideSearchList() {
        searchList.style.display = "none";
        activeIndex = -1;
    }
    searchInput.addEventListener("input", function () {
        const val = searchInput.value.trim().toLowerCase();
        searchList.innerHTML = "";
        if (!val || countryCenters.length == 0) {
            hideSearchList();
            return;
        }
        searchResults = countryCenters.filter((c) =>
            c.name.toLowerCase().includes(val)
        );
        if (searchResults.length === 0) {
            hideSearchList();
            return;
        }
        searchResults.slice(0, 10).forEach((c, i) => {
            const div = document.createElement("div");
            div.className = "searchitem" + (i === 0 ? " active" : "");
            div.innerHTML = `${c.name}`;
            div.addEventListener("mousedown", (e) => {
                selectCountry(i);
            });
            searchList.appendChild(div);
        });
        showSearchList();
        activeIndex = 0;
    });
    searchInput.addEventListener("keydown", function (e) {
        if (!searchResults.length) return;
        if (e.key === "ArrowDown") {
            activeIndex = Math.min(searchResults.length - 1, activeIndex + 1);
            updateActive();
            e.preventDefault();
        } else if (e.key === "ArrowUp") {
            activeIndex = Math.max(0, activeIndex - 1);
            updateActive();
            e.preventDefault();
        } else if (e.key === "Enter") {
            selectCountry(activeIndex);
            hideSearchList();
            e.preventDefault();
        }
    });
    function updateActive() {
        Array.from(searchList.children).forEach((c, i) =>
            c.classList.toggle("active", i === activeIndex)
        );
    }
    document.body.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !searchList.contains(e.target))
            hideSearchList();
    });
    function selectCountry(idx) {
        const c = searchResults[idx];
        hideSearchList();
        searchInput.value = c.name;
        map.flyTo(c.center, 5, {
            animate: true,
            duration: 1.6,
            easeLinearity: 0.25,
        });
        setTimeout(() => {
            let pop = population[c.code] || "No data";
            if (typeof pop === "number") pop = pop.toLocaleString();
            showTooltip(
                {
                    name: c.name,
                    iso2: c.iso2,
                    flag: c.flag || getFlagEmoji(c.iso2),
                    pop: pop,
                },
                {
                    clientX: window.innerWidth / 2,
                    clientY: window.innerHeight / 2,
                }
            );
            c.layer.setStyle({
                weight: 3,
                color: "#1444e8",
                fillColor: "#ffe066",
                fillOpacity: 1,
            });
            setTimeout(
                () =>
                    c.layer.setStyle({
                        weight: 1,
                        color: "#fff",
                        fillOpacity: 0.9,
                    }),
                1000
            );
        }, 1300);
    }
}

// tooltip funksiyasi
const tooltip = document.getElementById("tooltip");
function showTooltip(data, evt) {
    tooltip.innerHTML = `
    <div class="tooltip-header">
      <div class="tooltip-country">${data.name || ""}</div>
      <span class="tooltip-flag-emoji">${data.flag || ""}</span>
    </div>
    ${
        data.creative
            ? `<div class="tooltip-creative">${data.creative}</div>`
            : `<div class="tooltip-row" style="margin-top:5px">
            <span class="tooltip-label">Vatandoshlar</span>
            <span class="tooltip-value">${data.pop} ta</span>
          </div>`
    }
  `;
    tooltip.style.display = "block";
    updateTooltipPosition(evt);
}
function updateTooltipPosition(evt) {
    const mapRect = document.getElementById("map").getBoundingClientRect();
    tooltip.style.left = evt.clientX - mapRect.left + 17 + "px";
    tooltip.style.top = evt.clientY - mapRect.top + 11 + "px";
}
function hideTooltip() {
    tooltip.style.display = "none";
}
