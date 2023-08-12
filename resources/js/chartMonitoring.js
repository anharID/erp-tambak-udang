import Chart from "chart.js/auto";
import { fill } from "lodash";
const data = Object(chartData);

const ctx = document.getElementById("myChart");
const selectChart = document.getElementById("selectChart");
let chart

const makeChart = (prop = 'suhu', label = 'Suhu') => {
    return chart = new Chart(ctx, {
        type: "line",
        data: {
            datasets: [
                {
                    label: "Pagi",
                    data: Object.keys(data.dataPagi).map((key) => ({
                        x: key,
                        y: data.dataPagi[key][prop],
                    })),
                    borderWidth: 1,
                    backgroundColor: "rgba(34, 197, 94, 0.3)",
                    borderColor: "rgb(34, 197, 94)",
                    tension: 0.1,
                    fill: false,
                },
                {
                    label: "Sore",
                    data: Object.keys(data.dataSore).map((key) => ({
                        x: key,
                        y: data.dataSore[key][prop],
                    })),
                    borderWidth: 1,
                    backgroundColor: "rgba(239, 68, 68, 0.3)",
                    borderColor: "rgb(239, 68, 68)",
                    tension: 0.1,
                    fill: false,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    // title: { display: true, text: "seconds" },
                },
            },

            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: `Grafik ${label}`,
                    color: "#000",
                    font: {
                        size: 16,
                        weight: "normal",
                        family: "Figtree",
                    },
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                },
            },
        },
    })
}

makeChart()

selectChart.addEventListener("change", (e) => {
    const selectedOption = e.target.options[e.target.selectedIndex];
    const label = selectedOption.getAttribute("chartLabel");
    const prop = e.target.value;
    if (chart) {
        chart.destroy()
    }
    makeChart(prop, label)
});
