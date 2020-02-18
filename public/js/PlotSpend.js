class PlotSpend {
    constructor(id, url) {
        this.id = id
        this.button = document.getElementById(id);
        this.width = (document.body.clientWidth);
        this.height = (document.body.clientHeight);
        this.url = url;
        this.legend = 'Dépenses';
        this.axes = ['Dates', 'Dépenses']
        this.hasClicked = true
        this.plotarea = document.getElementById("plotarea");
        this.listCanvas = document.getElementsByTagName("canvas");
        this.listDivs = document.getElementById("plotarea").getElementsByClassName("chart-container");
        this.h2titles = document.getElementById("plotarea").getElementsByTagName("h2");

        this.init();
    }

    init() {
        this.getData()
        this.button.addEventListener('click', function () {
            this.plot();
        }.bind(this))
    }

    getData() {
        this.ajaxrequest = new AjaxRequest();
        this.ajaxrequest.ajax(this.url).then(function (response) {
            this.js_dates = Object.keys(response.history_spend);
            this.reformatDate = new ReformatDate();
            this.js_dates = this.reformatDate.abrev(this.js_dates);
            this.values = Object.values(response.history_spend);
            this.js_values = [];
            for (var i = 0; i < this.values.length; i++) {
                this.js_values.push(this.values[i]['spend'])
            }

            if (this.js_dates.length >= 6) {
                this.js_dates.splice(0, this.js_dates.length - 6)
            }
            if (this.js_values.length >= 6) {
                this.js_values.splice(0, this.js_values.length - 6)
            }

            this.js_dates7d = Object.keys(response.historySpend7d);
            this.js_dates7d = this.reformatDate.dayAndMonth(this.js_dates7d)
            this.values7d = Object.values(response.historySpend7d);
            this.js_values7d = [];
            for (var i = 0; i < this.values7d.length; i++) {
                this.js_values7d.push(this.values7d[i]['spend'])
            }

            this.js_dates14d = Object.keys(response.historySpend14d);
            this.js_dates14d = this.reformatDate.dayAndMonth(this.js_dates14d)
            this.values14d = Object.values(response.historySpend14d);
            this.js_values14d = [];
            for (var i = 0; i < this.values14d.length; i++) {
                this.js_values14d.push(this.values14d[i]['spend'])
            }

        }.bind(this))
    }

    plot() {
        this.ajaxrequest = new AjaxRequest();
        this.ajaxrequest.ajax(this.url).then(function (response) {
            this.cleanContainer()

            // Preparing Canvas for 6 previous months
            this.canvas = this.createElement("canvas", "Spend", "col-sm-12 col-md-8 col-lg-8 col-xl-6")
            this.plotarea.insertAdjacentElement("beforeend", this.canvas);

            //Div with two graphes : 7 days and 14 days
            // this.div = this.createElement("div", false, "row chart-container col-sm-12 col-md-8 col-lg-8 col-xl-6")
            this.div = this.createElement("div", false, "row chart-container col-sm-12 col-md-12 col-lg-12 col-xl-6")
            if (this.width >= 1200) {
                this.plotarea.insertAdjacentElement("beforeend", this.div);
            }
            //Preparing Canvas for 7 previous days
            this.canvas = this.createElement("canvas", "Spend7d", "col-sm-12 col-md-8 col-lg-8 col-xl-8 mt-2 mb-2")
            this.div.insertAdjacentElement("beforeend", this.canvas);
            //Responsive => Graphes goes inside the six months one
            if (this.width < 1200) {
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);
            } else {
                this.div.insertAdjacentElement("beforeend", this.canvas);
            }

            //Preparing Canvas for 14 previous days
            this.canvas = this.createElement("canvas", "Spend14d", "col-sm-12 col-md-8 col-lg-8 col-xl-8")
            this.div.insertAdjacentElement("beforeend", this.canvas);
            //Responsive => Graphes goes inside the six months one
            if (this.width < 1200) {
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);
            } else {
                this.div.insertAdjacentElement("beforeend", this.canvas);
            }

            this.graph = new Graphe('bar', 'Spend');

            this.Canvasid = 'Spend';
            this.title = '6 derniers mois';
            this.graph.plot(this.Canvasid, this.title, this.legend, this.js_dates, this.js_values, this.axes[0], this.axes[1]);

            this.Canvasid = 'Spend7d';
            this.title = '7 derniers jours';
            this.graph = new Graphe('line', 'Spend');
            this.graph.plot(this.Canvasid, this.title, this.legend, this.js_dates7d, this.js_values7d, this.axes[0], this.axes[1]);

            this.Canvasid = 'Spend14d';
            this.title = '14 derniers jours';
            this.graph = new Graphe('line', 'Spend');
            this.graph.plot(this.Canvasid, this.title, this.legend, this.js_dates14d, this.js_values14d, this.axes[0], this.axes[1]);

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
            document.getElementById("Spend").animate(animTransXPos[0], animTransXPos[1]);
            document.getElementById("Spend7d").animate(animTransXNeg[0], animTransXNeg[1]);
            document.getElementById("Spend14d").animate(animTransXNeg[0], animTransXNeg[1]);
        } else {
            document.getElementById("Spend").animate(animation[0], animation[1]);
            document.getElementById("Spend7d").animate(animation[0], animation[1]);
            document.getElementById("Spend14d").animate(animation[0], animation[1]);
        }
    }
}