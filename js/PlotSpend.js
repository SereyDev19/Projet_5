class PlotSpend {
    constructor(id, url) {
        this.button = document.getElementById(id);
        this.url = url;

        this.init();
    }

    init() {
        this.button.addEventListener('click', function () {
            this.ajaxrequest = new AjaxRequest();
            this.ajaxrequest.ajax(url).then(function (response) {
                this.listCanvas = document.getElementsByTagName("canvas");
                for (var item of this.listCanvas) {
                    item.remove();
                }
                var t = document.getElementById("plotarea").getElementsByTagName("h2");
                if (t.length > 0) {
                    for (var item of t) {
                        item.remove();
                    }
                }
                this.h2 = document.createElement("h2");

                this.h2.innerHTML = "Zone graphique";
                this.plotarea = document.getElementById("plotarea");


                this.plotarea.insertAdjacentElement("afterbegin", this.h2);


                this.canvas = document.createElement("canvas");
                this.canvas.setAttribute("id", "Spend");
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);

                console.log('tracer depenses')
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