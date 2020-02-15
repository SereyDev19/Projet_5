class PlotCostPerLead {
    constructor(id, url) {
        this.button = document.getElementById(id);
        this.url = url;
        this.legend = 'Coût par lead';
        this.init();
    }

    init() {
        var url = this.url
        this.button.addEventListener('click', function () {
            this.ajaxrequest = new AjaxRequest();
            this.ajaxrequest.ajax(url).then(function (response) {
                this.listCanvas = document.getElementsByTagName("canvas");
                console.log(this.listCanvas)
                var l = this.listCanvas.length
                for (var i = 0; i < l; i++) {
                    this.listCanvas[0].remove();
                }

                this.listDivs = document.getElementById("plotarea").getElementsByClassName("chart-container");
                var l = this.listDivs.length
                console.log(this.listDivs)
                for (var i = 0; i < l; i++) {
                    this.listDivs[0].remove();
                }

                var t = document.getElementById("plotarea").getElementsByTagName("h2");
                if (t.length > 0) {
                    for (var item of t) {
                        item.remove();
                    }
                }

                // Preparing Canvas for 6 previous months
                this.canvas = document.createElement("canvas");
                this.canvas.setAttribute("id", "CostPerLead");
                this.canvas.setAttribute("class", "col-sm-12 col-md-8 col-lg-8 col-xl-6")
                this.plotarea = document.getElementById("plotarea");
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);

                //Div with two graphes : 7 days and 14 days
                this.div = document.createElement("div")
                this.div.setAttribute("class", "row chart-container col-sm-12 col-md-8 col-lg-8 col-xl-6")
                this.plotarea.insertAdjacentElement("beforeend", this.div);

                //Preparing Canvas for 7 previous days
                this.canvas = document.createElement("canvas");
                this.canvas.setAttribute("id", "CostPerLead7d");
                this.plotarea = document.getElementById("plotarea");
                this.canvas.setAttribute("class", "col-sm-8 col-md-8 col-lg-8 col-xl-8 mb-2")
                this.div.insertAdjacentElement("beforeend", this.canvas);

                //Preparing Canvas for 14 previous days
                this.canvas = document.createElement("canvas");
                this.canvas.setAttribute("id", "CostPerLead14d");
                this.canvas.setAttribute("class", "col-sm-8 col-md-8 col-lg-8 col-xl-8 mt-2")
                this.plotarea = document.getElementById("plotarea");
                this.div.insertAdjacentElement("beforeend", this.canvas);

                this.graph = new Graphe('bar', 'CostPerLead');
                var js_dates = Object.keys(response.history_costperlead);
                // console.log(js_dates);
                var js_values = Object.values(response.history_costperlead);

                if (js_dates.length >= 6) {
                    js_dates.splice(0, js_dates.length - 6)
                }
                if (js_values.length >= 6) {
                    js_values.splice(0, js_values.length - 6)
                }

                this.Canvasid = 'CostPerLead';
                this.title = '6 derniers mois';
                var axes = ['Dates', 'Coût par lead (€)'];
                this.graph.plot(this.Canvasid, this.title, this.legend, js_dates, js_values, axes[0], axes[1]);

                var js_dates7d = Object.keys(response.historycostperlead7d);
                var js_values7d = Object.values(response.historycostperlead7d);

                this.Canvasid = 'CostPerLead7d';
                this.title = '7 derniers jours';
                this.graph = new Graphe('line', 'CostPerLead');
                this.graph.plot(this.Canvasid, this.title, this.legend, js_dates7d, js_values7d, axes[0], axes[1]);

                var js_dates14d = Object.keys(response.historycostperlead14d);
                var js_values14d = Object.values(response.historycostperlead14d);

                this.Canvasid = 'CostPerLead14d';
                this.title = '14 derniers jours';
                this.graph = new Graphe('line', 'CostPerLead');
                this.graph.plot(this.Canvasid, this.title, this.legend, js_dates14d, js_values14d, axes[0], axes[1]);

                var animation = [[
                    // keyframes
                    {
                        transform: 'translateX(0px)'
                    },
                    {
                        transform: 'rotateY(180deg)'
                    },
                    {
                        transform: 'rotateY(360deg)'
                    }
                ], {
                    // timing options
                    fill: 'forwards',
                    duration: 500
                }]

                document.getElementById("CostPerLead").animate(animation[0], animation[1]);
                document.getElementById("CostPerLead7d").animate(animation[0], animation[1]);
                document.getElementById("CostPerLead14d").animate(animation[0], animation[1]);
            }.bind(this));
        }.bind(this))
    }
}