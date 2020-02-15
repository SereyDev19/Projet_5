class Graphe {
    constructor(type,data) {
        this.type = type;
        this.data = data;
        this.width = (document.body.clientWidth);
        this.height = (document.body.clientHeight);
        this.fontSizeLarge = 30;
        this.fontSizeMedium = 20;
        this.ticksLimit = 12;
    }

    plot(id, title, legend, labelsValues, dataValues, axisX, axisY) {
        switch (this.data) {
            case 'Lead':
                var hoverBackgroundColor = "#86c59a";
                var backgroundColor = "#18a85c";
                var fontColor = "#fff";
                break;
            case 'Spend':
                var hoverBackgroundColor = "#f4abb6";
                var backgroundColor = "#ea5a63";
                var fontColor = "#fff";
                break;
            case 'CostPerLead':
                var hoverBackgroundColor = "#29a7c3";
                var backgroundColor = "#29a7c3";
                var fontColor = "#fff";
                break;
            default:
                var hoverBackgroundColor = "rgba(232,105,90,0.8)";
                var backgroundColor = "#f8ad22";
                var fontColor = "#fff";
        }

        //Responsive
        if (this.width < 850) {
            this.fontSizeLarge = 20;
            this.fontSizeMedium = 15;
            this.ticksLimit = 6;
        }
        if (this.width < 450) {
            this.fontSizeLarge = 15;
            this.fontSizeMedium = 10;
            this.ticksLimit = 4;
        }

        // console.log(id)
        this.ctx = document.getElementById(id).getContext('2d');
        this.chart = new Chart(this.ctx, {
            // The type of chart we want to create
            type: this.type,

            // The data for our dataset
            data: {
                labels: labelsValues,
                datasets: [{
                    label: legend,
                    fill:false,
                    backgroundColor: backgroundColor,
                    borderColor: backgroundColor,
                    data: dataValues,
                    hoverBackgroundColor: hoverBackgroundColor
                }]
            },

            // Configuration options go here
            options: {
                title: {
                    display: true,
                    text: title,
                    fontSize:this.fontSizeLarge,
                    fontColor:'#fff'
                },
                legend: {
                    labels: {
                        fontColor: fontColor,
                        fontSize: this.fontSizeMedium

                    }
                },

                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: axisY,
                            fontSize: this.fontSizeMedium,
                            fontColor: fontColor
                        },
                        ticks: {
                            maxTicksLimit: this.ticksLimit,
                            fontSize: this.fontSizeMedium,
                            fontColor: fontColor
                        },
                        gridLines: {
                            color: fontColor,
                            lineWidth: 0.1,
                            zeroLineColor: fontColor,
                            zeroLineWidth: 0.1
                        }

                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: false,
                            labelString: axisX,
                            fontColor: fontColor,
                            fontSize: this.fontSizeMedium
                        },
                        ticks: {
                            fontSize: this.fontSizeMedium,
                            fontColor: fontColor
                        },
                        gridLines: {
                            color: fontColor,
                            lineWidth: 0.1,
                            zeroLineColor: fontColor,
                            zeroLineWidth: 0.1
                        }
                    }]
                }
            }
        })
    }
}