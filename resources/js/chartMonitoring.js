import Chart from "chart.js/auto";
import { fill } from "lodash";
const data = Object(chartData);

const ctx = document.getElementById("myChart");

new Chart(ctx, {
    type: "line",
    data: {
        labels: data.labels,
        datasets: [
            {
                label: "Pagi",
                data: data.dataPagi,
                borderWidth: 1,
                backgroundColor: "rgba(34, 197, 94, 0.3)",
                borderColor: "rgb(34, 197, 94)",
                tension:0.1,
                fill:false
            },
            {
                label: "Sore",
                data: data.dataSore,
                borderWidth: 1,
                backgroundColor: "rgba(239, 68, 68, 0.3)",
                borderColor: "rgb(239, 68, 68)",
                tension:0.1,
                fill:false
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
                text: `Grafik${data.label.replace(
                    /(?:^|_)([a-z])/g,
                    (match, group) => {
                        return " " + group.toUpperCase();
                    }
                )}`,
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
});
