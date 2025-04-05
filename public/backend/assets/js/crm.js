var ctx1 = document.getElementById("chart-line-1").getContext("2d");

var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.02)');
gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

var ctx2 = document.getElementById("chart-line-2").getContext("2d");

new Chart(ctx1, {
    type: "line",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Visitors",
            tension: 0.5,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 2,
            backgroundColor: gradientStroke1,
            data: [50, 45, 60, 60, 80, 65, 90, 80, 100],
            maxBarThickness: 6,
            fill: true
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            y: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    display: true,
                    padding: 10,
                    color: '#9ca2b7'
                }
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    display: true,
                    padding: 10,
                    color: '#9ca2b7'
                }
            },
        },
    },
});

new Chart(ctx2, {
    type: "line",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Income",
            tension: 0.5,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 2,
            backgroundColor: gradientStroke1,
            data: [60, 80, 75, 90, 67, 100, 90, 110, 120],
            maxBarThickness: 6,
            fill: true
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            y: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    callback: function (value, index, values) {
                        return '$' + value;
                    },
                    display: true,
                    padding: 10,
                    color: '#9ca2b7'
                }
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    display: true,
                    padding: 10,
                    color: '#9ca2b7'
                }
            },
        },
    },
});
