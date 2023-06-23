import Chart from "chart.js/auto";
const dataPemasukan = Object(chartDataPemasukan);
const dataPengeluaran = Object(chartDataPengeluaran);

const ctx = document.getElementById("myChart");

new Chart(ctx, {
    type: "bar",
    data: {
        labels: dataPemasukan.labels,
        datasets: [
            {
                label: "Pemasukan",
                data: dataPemasukan.values,
                borderWidth: 1,
                backgroundColor: "rgba(34, 197, 94, 0.3)",
                borderColor: "rgb(34, 197, 94)",
            },
            {
                label: "Pengeluaran",
                data: dataPengeluaran.values,
                borderWidth: 1,
                backgroundColor: "rgba(239, 68, 68, 0.3)",
                borderColor: "rgb(239, 68, 68)",
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: "Grafik Pemasukan dan Pengeluaran Per Bulan",
                color: '#000',
                font: {
                    size: 16,
                    weight: "normal",
                    family: "Figtree",
                    
                },
            },
        },
    },
});