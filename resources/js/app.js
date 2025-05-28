import './bootstrap';
import 'alpinejs';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
Livewire.start();

import Chart from 'chart.js/auto';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('laporanChart');
    const filterSelect = document.getElementById('filterDurasi');

    if (!ctx || !filterSelect) return;

    let chart;

    async function fetchData(filter) {
        try {
            const response = await axios.post('/api/dashboard-graph', {
                filter_durasi: filter
            });

            const { description, laporan_masuk_pengiriman, laporan_keluar } = response.data.data;

            const labels = description;
            const dataMasuk = laporan_masuk_pengiriman;
            const dataKeluar = laporan_keluar;

            updateChart(labels, dataMasuk, dataKeluar);
        } catch (error) {
            console.error("Gagal mengambil data grafik:", error);
        }
    }

    function updateChart(labels, masuk, keluar) {
        if (chart) {
            chart.destroy();
        }

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Laporan Masuk Pengiriman',
                        data: masuk,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.4
                    },
                    {
                        label: 'Laporan Keluar',
                        data: keluar,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.4
                    }
                ]
            }
        });
    }

    // Event listener untuk dropdown
    filterSelect.addEventListener('change', (e) => {
        fetchData(e.target.value);
    });

    // Fetch awal
    fetchData(filterSelect.value);
});
