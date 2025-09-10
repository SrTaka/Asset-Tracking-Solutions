import './bootstrap';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;

Alpine.start();

// Dashboard movement modal component
window.movementModal = function () {
    return {
        isOpen: false,
        startDate: new Date(new Date().setDate(new Date().getDate() - 30)).toISOString().slice(0,10),
        endDate: new Date().toISOString().slice(0,10),
        loading: false,
        summary: { range: { start: '', end: '' }, total_assignments: 0, unique_assets: 0, unique_users: 0 },
        rows: [],
        open() {
            this.isOpen = true;
            this.fetchData();
        },
        close() { this.isOpen = false; },
        async fetchData() {
            this.loading = true;
            try {
                const params = new URLSearchParams({ start_date: this.startDate, end_date: this.endDate });
                const response = await fetch(`/admin/dashboard/movement-summary?${params.toString()}`, { headers: { 'Accept': 'application/json' } });
                const data = await response.json();
                this.summary = data.summary || this.summary;
                this.rows = data.assignments || [];
                this.renderChart();
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        renderChart() {
            try {
                const ctx = document.getElementById('movementChart');
                if (!ctx) return;
                const byDate = {};
                for (const row of this.rows) {
                    const d = (row.assigned_at || '').slice(0,10);
                    if (!d) continue;
                    byDate[d] = (byDate[d] || 0) + 1;
                }
                const labels = Object.keys(byDate).sort();
                const dataPoints = labels.map(l => byDate[l]);
                if (window._movementChart) {
                    window._movementChart.data.labels = labels;
                    window._movementChart.data.datasets[0].data = dataPoints;
                    window._movementChart.update();
                    return;
                }
                // Lazy import Chart.js via CDN if not present
                const ensureChart = () => new Promise(resolve => {
                    if (window.Chart) return resolve();
                    const s = document.createElement('script');
                    s.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                    s.onload = resolve; document.head.appendChild(s);
                });
                ensureChart().then(() => {
                    window._movementChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{ label: 'Assignments', data: dataPoints, borderColor: '#4f46e5', backgroundColor: 'rgba(79,70,229,0.2)', tension: 0.25 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
                    });
                });
            } catch (e) { console.error(e); }
        }
    }
}
