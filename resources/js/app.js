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
    const dataValues = [50, 30, 20];
    const labels = ['Baik', 'R. Ringan', 'R. Berat'];
    const colors = ['#4b3f94', '#c9de64', '#e63946'];

    const myChart = new Chart(donutChartElement.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: colors,
                borderWidth: 0,
                cutout: '75%' // Dibuat sedikit lebih tipis agar elegan
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false } // MATIKAN LEGEND BAWAAN
            }
        }
    });

    // Render Custom Legend
    const legendContainer = document.getElementById('donutLegend');
    labels.forEach((label, index) => {
        legendContainer.innerHTML += `
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full" style="background-color: ${colors[index]}"></span>
                <span class="text-xs text-gray-600 font-medium">${label} ${dataValues[index]}%</span>
            </div>
        `;
    });
}
