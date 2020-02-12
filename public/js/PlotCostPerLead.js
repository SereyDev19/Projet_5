class PlotCostPerLead {
    constructor(id, url) {
        this.button = document.getElementById(id);
        console.log(this.button)
        this.url = url;
        // console.log(this.url);

        this.init();
    }

    init() {
        var url = this.url
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
                // this.h2 = document.createElement("h2");
                // this.h2.innerHTML = "Zone graphique";
                this.plotarea = document.getElementById("plotarea");
                // this.plotarea.insertAdjacentElement("afterbegin", this.h2);


                this.canvas = document.createElement("canvas");
                this.canvas.setAttribute("id", "CostPerLead");
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);


                this.graph = new Graphe();
                var js_dates = Object.keys(response.history_costperlead);
                // console.log(js_dates);
                var js_values = Object.values(response.history_costperlead);

                this.Canvasid = 'CostPerLead';
                this.title = 'Cost per lead';

                this.graph.plot(this.Canvasid, this.title, js_dates, js_values, 'Dates', this.title + ' (€)');

            }.bind(this));
        })
    }
}