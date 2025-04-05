var ctx1 = document.getElementById("chart-widgets-1").getContext("2d");

var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.02)');
gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

var ctx2 = document.getElementById("chart-widgets-2").getContext("2d");

var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

gradientStroke2.addColorStop(1, 'rgba(37,47,64,0.05)');
gradientStroke2.addColorStop(0.2, 'rgba(37,47,64,0.0)');
gradientStroke2.addColorStop(0, 'rgba(37,47,64,0)'); //purple colors

new Chart(ctx1, {
    type: "line",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Calories",
            tension: 0.5,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#252f40",
            borderWidth: 2,
            backgroundColor: gradientStroke2,
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
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    display: false
                }
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    display: false
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
            borderColor: "#252f40",
            borderWidth: 2,
            backgroundColor: gradientStroke2,
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
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    display: false
                }
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    display: false
                }
            },
        },
    },
});

var ctx3 = document.getElementById("chart-line-widgets").getContext("2d");

var gradientStroke3 = ctx3.createLinearGradient(0, 230, 0, 50);

gradientStroke3.addColorStop(1, 'rgba(33,82,255,0.1)');
gradientStroke3.addColorStop(0.2, 'rgba(33,82,255,0.0)');
gradientStroke3.addColorStop(0, 'rgba(33,82,255,0)'); //purple colors

new Chart(ctx3, {
    type: "line",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Tasks",
            tension: 0.3,
            pointRadius: 2,
            pointBackgroundColor: "#cb0c9f",
            borderColor: "#cb0c9f",
            borderWidth: 2,
            backgroundColor: gradientStroke1,
            data: [40, 45, 42, 41, 40, 43, 40, 42, 39],
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
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    display: false
                }
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    color: '#252f40',
                    padding: 10
                }
            },
        },
    },
});
