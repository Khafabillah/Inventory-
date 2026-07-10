import "./bootstrap";

/* ==========================================================================
CHART CONFIGURATION: Bar Chart
========================================================================== */

// PELINDUNG: Hanya jalankan jika Chart tersedia di halaman
if (typeof Chart !== "undefined") {
    Chart.defaults.font.family = "Inter";
}

const barChartElement = document.getElementById("barChart");

if (barChartElement && typeof Chart !== "undefined") {
    const ctx = barChartElement.getContext("2d");

    const dynamicLabels = window.dashboardData?.barLabels || [
        "Showroom",
        "Gudang",
        "Service",
        "HR",
        "Lounge",
        "Bengkel",
    ];
    const dynamicData = window.dashboardData?.barData || [
        800, 680, 150, 80, 320, 20,
    ];

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: dynamicLabels,
            datasets: [
                {
                    label: "Jumlah Aset",
                    data: dynamicData,
                    backgroundColor: [
                        "#73FF70",
                        "#77E4FF",
                        "#FF7CE7",
                        "#F15F61",
                        "#646764",
                        "#5F64F1",
                        "#F59E0B",
                        "#10B981",
                    ],
                    borderRadius: 8,
                    barThickness: 35,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#ffffff",
                    titleColor: "#111827",
                    bodyColor: "#6B7280",
                    borderColor: "#E5E7EB",
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    bodyFont: { family: "Inter", weight: 400 },
                    titleFont: { family: "Inter", weight: "bold" },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: "#F3F4F6", drawBorder: false },
                    ticks: {
                        font: { family: "Inter", weight: 400 },
                        color: "#9CA3AF",
                    },
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: "Inter", weight: 400 },
                        color: "#6B7280",
                    },
                },
            },
        },
    });
}

/* ==========================================================================
CHART CONFIGURATION: Donut Chart
========================================================================== */
const donutChartElement = document.getElementById("donutChart");

if (donutChartElement && typeof Chart !== "undefined") {
    const dataValues = window.dashboardData?.donutData || [50, 30, 20];
    const labels = ["Baik", "R. Ringan", "R. Berat"];
    const colors = ["#4b3f94", "#c9de64", "#e63946"];

    const myChart = new Chart(donutChartElement.getContext("2d"), {
        type: "doughnut",
        data: {
            labels: labels,
            datasets: [
                {
                    data: dataValues,
                    backgroundColor: colors,
                    borderWidth: 0,
                    cutout: "75%",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
        },
    });

    const legendContainer = document.getElementById("donutLegend");
    labels.forEach((label, index) => {
        legendContainer.innerHTML += `
<div class="flex items-center gap-2">
    <span class="w-3 h-3 rounded-full" style="background-color: ${colors[index]}"></span>
    <span class="text-xs text-gray-600 font-medium">${label} ${dataValues[index]} Aset</span>
</div>
`;
    });
}

/* ==========================================================================
LOGIKA GLOBAL: MANAJEMEN ASET & UI COMPONENTS
========================================================================== */

window.toggleModal = function (id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.toggle("hidden");
    el.classList.toggle("flex");
};

window.openQrModal = function (code, name, branch) {
    document.getElementById("qrAssetCode").innerText = code;
    document.getElementById("qrAssetName").innerText = name;
    document.getElementById("qrAssetBranch").innerText = "Cabang: " + branch;

    const qrImage = document.getElementById("qrImage");
    qrImage.src = `/aset/qr/${encodeURIComponent(code)}`;

    window.toggleModal("modalCetakQR");
};

window.printQR = function () {
    const printContent = document.getElementById("printArea").innerHTML;
    const originalContent = document.body.innerHTML;

    document.body.innerHTML = `
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif;">
    <div style="text-align: center;">
        ${printContent}
    </div>
</div>
`;

    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload();
};

document.addEventListener("DOMContentLoaded", function () {
    const alertSukses = document.getElementById("alert-sukses");
    if (alertSukses) {
        setTimeout(() => {
            alertSukses.classList.add("opacity-0");
            setTimeout(() => {
                alertSukses.remove();
            }, 500);
        }, 3000);
    }
});

window.toggleDropdown = function (id) {
    document.querySelectorAll('[id^="dropdown-"]').forEach((el) => {
        if (el.id !== id) el.classList.add("hidden");
    });
    const el = document.getElementById(id);
    if (el) el.classList.toggle("hidden");
};

window.addEventListener("click", function (e) {
    if (!e.target.closest('button[onclick^="toggleDropdown"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach((el) => {
            el.classList.add("hidden");
        });
    }
});
