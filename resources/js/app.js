import './bootstrap';
import './bootstrap';

/* ==========================================================================
   CHART CONFIGURATION: Bar Chart
   ========================================================================== */

// Memaksa seluruh chart menggunakan font Inter sebagai standar
Chart.defaults.font.family = 'Inter';

const barChartElement = document.getElementById('barChart');

if (barChartElement) {
    const ctx = barChartElement.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Showroom', 'Gudang', 'Service', 'HR', 'Lounge', 'Bengkel'],
            datasets: [{
                label: 'Jumlah Aset',
                data: [800, 680, 150, 80, 320, 20],
                backgroundColor: [
                    '#73FF70', '#77E4FF', '#FF7CE7', '#F15F61', '#646764', '#5F64F1'
                ],
                borderRadius: 8,
                barThickness: 35,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#111827',
                    bodyColor: '#6B7280',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    // Menggunakan weight 400 (Regular) secara eksplisit
                    bodyFont: { family: 'Inter', weight: 400 },
                    titleFont: { family: 'Inter', weight: 'bold' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#F3F4F6', drawBorder: false },
                    // Menggunakan weight 400 untuk teks sumbu Y
                    ticks: { font: { family: 'Inter', weight: 400 }, color: '#9CA3AF' }
                },
                x: {
                    grid: { display: false },
                    // Menggunakan weight 400 untuk teks sumbu X
                    ticks: { font: { family: 'Inter', weight: 400 }, color: '#6B7280' }
                }
            }
        }
    });
}

/* ==========================================================================
   CHART CONFIGURATION: Donut Chart
   ========================================================================== */
const donutChartElement = document.getElementById('donutChart');

if (donutChartElement) {
    const ctx = donutChartElement.getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['  Baik', '  R. Ringan', '  R. Berat'],
            datasets: [{
                data: [50, 30, 20],
                backgroundColor: ['#4b3f94', '#c9de64', '#e63946'],
                borderWidth: 0,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            // Perbesar nilai bottom di sini untuk memberi jarak fisik dari grafik ke bawah
            layout: {
                padding: { bottom: 0 }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    align: 'center',
                    fullWidth: true,
                    labels: {
                        font: { family: 'Inter', size: 11, weight: 400 },
                        usePointStyle: true,
                        pointStyle: 'circle',
                        // Padding ini mengontrol jarak vertikal legend dari titik terendah grafik
                        padding: 20,
                        boxWidth: 6,
                        maxWidth: 300,
                        generateLabels: (chart) => {
                            const data = chart.data;
                            return data.labels.map((label, i) => ({
                                text: `${label} ${data.datasets[0].data[i]}%`,
                                fillStyle: data.datasets[0].backgroundColor[i],
                                pointStyle: 'circle'
                            }));
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#111827',
                    bodyColor: '#6B7280',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 10
                }
            },
            cutout: '70%'
        }
    });
}
