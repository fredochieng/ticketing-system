$(function() {
    "use strict";

    var ticksStyle = {
        fontColor: "#495057",
        fontStyle: "bold"
    };

    var mode = "index";
    var intersect = true;

    var $salesChart = $("#sales-chart");
    var salesChart = new Chart($salesChart, {
        type: "bar",
        data: {
            labels: ["JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
            datasets: [
                {
                    backgroundColor: "green",
                    borderColor: "#007bff",
                    data: [100, 200, 300, 250, 270, 250, 300]
                },
                {
                    backgroundColor: "blue",
                    borderColor: "#ced4da",
                    data: [70, 170, 270, 200, 180, 150, 200]
                },
                {
                    backgroundColor: "#851425",
                    borderColor: "#007bff",
                    data: [50, 100, 200, 500, 250, 210, 30]
                },
                {
                    backgroundColor: "purple",
                    borderColor: "#007bff",
                    data: [100, 20, 340, 30, 250, 210, 560]
                }
                // {
                //   backgroundColor: 'grey',
                //   borderColor    : '#007bff',
                //   data           : [90, 300, 250, 130, 220, 250, 430]
                // },
                // {
                //   backgroundColor: 'red',
                //   borderColor    : '#007bff',
                //   data           : [500, 270, 390, 250, 270, 210, 300]
                // },
                // {
                //   backgroundColor: '#6717ad',
                //   borderColor    : '#007bff',
                //   data           : [100, 20, 360, 250, 100, 200, 400]
                // }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [
                    {
                        // display: false,
                        gridLines: {
                            display: false,
                            lineWidth: "4px",
                            color: "rgba(0, 0, 0, .2)",
                            zeroLineColor: "transparent"
                        },
                        ticks: $.extend(
                            {
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    if (value >= 1000) {
                                        value /= 1000;
                                        value += "k";
                                    }
                                    return +value;
                                }
                            },
                            ticksStyle
                        )
                    }
                ],
                xAxes: [
                    {
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }
                ]
            }
        }
    });

    var $visitorsChart = $("#visitors-chart");
    var visitorsChart = new Chart($visitorsChart, {
        data: {
            labels: ["18th", "20th", "22nd", "24th", "26th", "28th", "30th"],
            datasets: [
                {
                    type: "line",
                    data: [100, 120, 170, 167, 180, 177, 160],
                    backgroundColor: "transparent",
                    borderColor: "#007bff",
                    pointBorderColor: "#007bff",
                    pointBackgroundColor: "#007bff",
                    fill: false
                    // pointHoverBackgroundColor: '#007bff',
                    // pointHoverBorderColor    : '#007bff'
                },
                {
                    type: "line",
                    data: [60, 80, 70, 67, 80, 77, 100],
                    backgroundColor: "tansparent",
                    borderColor: "#ced4da",
                    pointBorderColor: "#ced4da",
                    pointBackgroundColor: "#ced4da",
                    fill: false
                    // pointHoverBackgroundColor: '#ced4da',
                    // pointHoverBorderColor    : '#ced4da'
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [
                    {
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: "4px",
                            color: "rgba(0, 0, 0, .2)",
                            zeroLineColor: "transparent"
                        },
                        ticks: $.extend(
                            {
                                beginAtZero: true,
                                suggestedMax: 200
                            },
                            ticksStyle
                        )
                    }
                ],
                xAxes: [
                    {
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }
                ]
            }
        }
    });
});
