class Graphe {
    constructor() {
    }

    plot(id, title, labelsValues, dataValues) {
        console.log(id)
        this.ctx = document.getElementById(id).getContext('2d');
        this.chart = new Chart(this.ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                // labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                labels: labelsValues,
                datasets: [{
                    label: title,
                    backgroundColor: '#f8ad22',
                    borderColor: '#f8ad22',
                    // data: [0, 10, 5, 2, 20, 30, 45]
                    data: dataValues,
                    hoverBackgroundColor: "rgba(232,105,90,0.8)"
                }]
            },

            // Configuration options go here
            options: {
                legend: {
                    labels: {
                        fontColor: '#fff',
                        fontSize: 30

                    }
                },

                scales: {
                    yAxes: [{
                        ticks: {
                            fontSize: 20,
                            fontColor: "#fff"
                        },
                        gridLines: {
                            color: "#fff",
                            lineWidth: 0.1,
                            zeroLineColor: "#fff",
                            zeroLineWidth: 0.1
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 20,
                            fontColor: "#fff"
                        },
                        gridLines: {
                            color: "#fff",
                            lineWidth: 0.1,
                            zeroLineColor: "#fff",
                            zeroLineWidth: 0.1
                        }
                    }]
                }
            }
        })
    }
}