class PlotCostPerLead {
    constructor(id, url) {
        this.id = id
        this.button = document.getElementById(id);
        this.url = url;
        this.legend = 'Coût par lead';
        this.hasClicked = true
        this.plotarea = document.getElementById("plotarea");
        this.listCanvas = document.getElementsByTagName("canvas");
        this.listDivs = document.getElementById("plotarea").getElementsByClassName("chart-container");
        this.h2titles = document.getElementById("plotarea").getElementsByTagName("h2");


        this.init();
    }

    init() {
        this.button.addEventListener('click', function () {
            this.plot();
        }.bind(this))
    }

    plot() {
        this.ajaxrequest = new AjaxRequest();
        this.ajaxrequest.ajax(this.url).then(function (response) {
            this.cleanContainer()

            // Preparing Canvas for 6 previous months
            this.canvas = this.createElement("canvas", "CostPerLead", "col-sm-12 col-md-8 col-lg-8 col-xl-6")
            this.plotarea.insertAdjacentElement("beforeend", this.canvas);

            //Div with two graphes : 7 days and 14 days
            this.div = this.createElement("div", false, "row chart-container col-sm-12 col-md-8 col-lg-8 col-xl-6")
            this.plotarea.insertAdjacentElement("beforeend", this.div);

            //Preparing Canvas for 7 previous days
            this.canvas = this.createElement("canvas", "CostPerLead7d", "col-sm-8 col-md-8 col-lg-8 col-xl-8 mb-2")
            this.div.insertAdjacentElement("beforeend", this.canvas);

            //Preparing Canvas for 14 previous days
            this.canvas = this.createElement("canvas", "CostPerLead14d", "col-sm-8 col-md-8 col-lg-8 col-xl-8 mt-2")
            this.div.insertAdjacentElement("beforeend", this.canvas);

            this.graph = new Graphe('bar', 'CostPerLead');
            var js_dates = Object.keys(response.history_costperlead);
            this.reformatDate = new ReformatDate();
            js_dates = this.reformatDate.abrev(js_dates);

            if (js_dates.length >= 6) {
                js_dates.splice(0, js_dates.length - 6)
            }
            var js_values = Object.values(response.history_costperlead);
            if (js_values.length >= 6) {
                js_values.splice(0, js_values.length - 6)
            }

            this.Canvasid = 'CostPerLead';
            this.title = '6 derniers mois';
            var axes = ['Dates', 'Coût par lead']
            this.graph.plot(this.Canvasid, this.title, this.legend, js_dates, js_values, axes[0], axes[1]);

            var js_dates7d = Object.keys(response.historycostperlead7d);
            js_dates7d = this.reformatDate.dayAndMonth(js_dates7d)
            var js_values7d = Object.values(response.historycostperlead7d);

            this.Canvasid = 'CostPerLead7d';
            this.title = '7 derniers jours';
            this.graph = new Graphe('line', 'CostPerLead');
            this.graph.plot(this.Canvasid, this.title, this.legend, js_dates7d, js_values7d, axes[0], axes[1]);

            var js_dates14d = Object.keys(response.historycostperlead14d);
            js_dates14d = this.reformatDate.dayAndMonth(js_dates14d)
            var js_values14d = Object.values(response.historycostperlead14d);

            this.Canvasid = 'CostPerLead14d';
            this.title = '14 derniers jours';
            this.graph = new Graphe('line', 'CostPerLead');
            this.graph.plot(this.Canvasid, this.title, this.legend, js_dates14d, js_values14d, axes[0], axes[1]);

            this.setAnimation()
        }.bind(this));
    }

    cleanContainer() {
        var l = this.listCanvas.length
        for (var i = 0; i < l; i++) {
            this.listCanvas[0].remove();
        }

        var l = this.listDivs.length
        for (var i = 0; i < l; i++) {
            this.listDivs[0].remove();
        }

        var t = this.h2titles.length
        if (t > 0) {
            for (var item of t) {
                item.remove();
            }
        }
    }

    createElement(tagName, idName, className) {
        var newElement = document.createElement(tagName);
        if (idName != false) {
            newElement.setAttribute("id", idName);
        }
        if (className != false) {
            newElement.setAttribute("class", className)
        }
        return newElement
    }

    setAnimation() {
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

        var animTransXPos = [[
            // keyframes
            {
                transform: 'translateX(-1000px)'
            },
            {
                transform: 'translateX(0px)'
            }
        ], {
            // timing options
            fill: 'forwards',
            duration: 500
        }]

        var animTransXNeg = [[
            // keyframes
            {
                transform: 'translateX(500px)'
            },
            {
                transform: 'translateX(0px)'
            }
        ], {
            // timing options
            fill: 'forwards',
            duration: 500
        }]

        if (this.hasClicked == false) {
            document.getElementById("CostPerLead").animate(animTransXPos[0], animTransXPos[1]);
            document.getElementById("CostPerLead7d").animate(animTransXNeg[0], animTransXNeg[1]);
            document.getElementById("CostPerLead14d").animate(animTransXNeg[0], animTransXNeg[1]);
        } else {
            document.getElementById("CostPerLead").animate(animation[0], animation[1]);
            document.getElementById("CostPerLead7d").animate(animation[0], animation[1]);
            document.getElementById("CostPerLead14d").animate(animation[0], animation[1]);
        }
    }
}