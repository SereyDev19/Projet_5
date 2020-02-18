class PlotLead {
    constructor(id, url) {
        this.id = id
        this.button = document.getElementById(id);
        this.width = (document.body.clientWidth);
        this.height = (document.body.clientHeight);
        this.url = url;
        this.legend = 'Lead';
        this.axes = ['Dates', 'Nombre de leads']
        this.hasClicked = false
        this.plotarea = document.getElementById("plotarea");
        this.listCanvas = document.getElementsByTagName("canvas");
        this.listDivs = document.getElementById("plotarea").getElementsByClassName("chart-container");
        this.h2titles = document.getElementById("plotarea").getElementsByTagName("h2");


        this.init();
    }

    init() {
        this.button.addEventListener('click', function () {
            this.plot();
            this.hasClicked = true
        }.bind(this))
    }

    plot() {
        this.ajaxrequest = new AjaxRequest();
        this.ajaxrequest.ajax(this.url).then(function (response) {
            this.cleanContainer()

            // Preparing Canvas for 6 previous months
            this.canvas = this.createElement("canvas", "Lead", "col-sm-12 col-md-8 col-lg-8 col-xl-6")
            this.plotarea.insertAdjacentElement("beforeend", this.canvas);

            //Div with two graphes : 7 days and 14 days
            // this.div = this.createElement("div", false, "row chart-container col-sm-12 col-md-8 col-lg-8 col-xl-6")
            this.div = this.createElement("div", false, "row chart-container col-sm-12 col-md-12 col-lg-12 col-xl-6")
            if (this.width >= 1200) {
                this.plotarea.insertAdjacentElement("beforeend", this.div);
            }

            //Preparing Canvas for 7 previous days
            this.canvas = this.createElement("canvas", "Lead7d", "col-sm-12 col-md-8 col-lg-8 col-xl-8 mt-2 mb-2")
            //Responsive => Graphes goes inside the six months one
            if (this.width < 1200) {
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);
            } else {
                this.div.insertAdjacentElement("beforeend", this.canvas);
            }

            //Preparing Canvas for 14 previous days
            this.canvas = this.createElement("canvas", "Lead14d", "col-sm-12 col-md-8 col-lg-8 col-xl-8")
            //Responsive => Graphes goes inside the six months one
            if (this.width < 1200) {
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);
            } else {
                this.div.insertAdjacentElement("beforeend", this.canvas);
            }

            this.graph = new Graphe('bar', 'Lead');
            var js_dates = Object.keys(response.history_lead);
            this.reformatDate = new ReformatDate();
            js_dates = this.reformatDate.abrev(js_dates);

            if (js_dates.length >= 6) {
                js_dates.splice(0, js_dates.length - 6)
            }
            var js_values = Object.values(response.history_lead);
            if (js_values.length >= 6) {
                js_values.splice(0, js_values.length - 6)
            }

            this.Canvasid = 'Lead';
            this.title = '6 derniers mois';
            this.graph.plot(this.Canvasid, this.title, this.legend, js_dates, js_values, this.axes[0], this.axes[1]);

            var js_dates7d = Object.keys(response.historylead7d);
            js_dates7d = this.reformatDate.dayAndMonth(js_dates7d)
            var js_values7d = Object.values(response.historylead7d);

            this.Canvasid = 'Lead7d';
            this.title = '7 derniers jours';
            this.graph = new Graphe('line', 'Lead');
            this.graph.plot(this.Canvasid, this.title, this.legend, js_dates7d, js_values7d, this.axes[0], this.axes[1]);

            var js_dates14d = Object.keys(response.historylead14d);
            js_dates14d = this.reformatDate.dayAndMonth(js_dates14d)
            var js_values14d = Object.values(response.historylead14d);

            this.Canvasid = 'Lead14d';
            this.title = '14 derniers jours';
            this.graph = new Graphe('line', 'Lead');
            this.graph.plot(this.Canvasid, this.title, this.legend, js_dates14d, js_values14d, this.axes[0], this.axes[1]);

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
            document.getElementById("Lead").animate(animTransXPos[0], animTransXPos[1]);
            document.getElementById("Lead7d").animate(animTransXNeg[0], animTransXNeg[1]);
            document.getElementById("Lead14d").animate(animTransXNeg[0], animTransXNeg[1]);
        } else {
            document.getElementById("Lead").animate(animation[0], animation[1]);
            document.getElementById("Lead7d").animate(animation[0], animation[1]);
            document.getElementById("Lead14d").animate(animation[0], animation[1]);
        }
    }
}