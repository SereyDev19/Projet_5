class Graphe {
    constructor() {
    }

    plot(id, title, labelsValues, dataValues) {
        this.ctx = document.getElementById(id).getContext('2d');
        this.chart = new Chart(this.ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                // labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                labels: labelsValues,
                datasets: [{
                    label: title,
                    // backgroundColor: 'rgb(24, 169, 93)',
                    borderColor: 'rgb(24, 169, 93)',
                    // data: [0, 10, 5, 2, 20, 30, 45]
                    data: dataValues
                }]
            },

            // Configuration options go here
            options: {}
        })
    }
}