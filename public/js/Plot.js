class Plot {
    constructor(id) {
        this.button = document.getElementById(id);
        this.init();
    }

    init() {
        this.button.addEventListener('click', function () {
            this.ajaxrequest = new AjaxRequest();
            this.ajaxrequest.ajax(url).then(function (response) {
                console.log('Donnees recues');
                this.graph = new Graphe();
                var js_dates = Object.keys(response.history_spend);
                var values = Object.values(response.history_spend);
                var js_values = [];
                for (var i = 0; i < values.length; i++) {
                    js_values.push(values[i]['spend'])
                }

                this.Canvasid = 'Spend';
                this.title = 'Dépenses';

                this.graph.plot(this.Canvasid, this.title, js_dates, js_values);

            }.bind(this));


        })
    }
}