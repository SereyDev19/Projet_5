class PlotLead {
    constructor(id, url) {
        console.log(id)
        this.button = document.getElementById(id);
        console.log(this.button)
        this.url = url;
        // console.log(this.url);

        this.init();
    }

    init() {
        var url = this.url
        this.button.addEventListener('click', function () {
            this.plot();
        }.bind(this))
    }

    plot() {
        this.ajaxrequest = new AjaxRequest();
        this.ajaxrequest.ajax(this.url).then(function (response) {
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
            this.canvas.setAttribute("id", "Lead");
            this.plotarea = document.getElementById("plotarea");
            this.plotarea.insertAdjacentElement("beforeend", this.canvas);


            // console.log('tracer leads')
            // console.log('Donnees recues');
            this.graph = new Graphe();
            var js_dates = Object.keys(response.history_lead);
            var js_values = Object.values(response.history_lead);

            this.Canvasid = 'Lead';
            this.title = 'Lead';

            this.graph.plot(this.Canvasid, this.title, js_dates, js_values, 'Dates', 'Nombre de leads');

            this.canvas.animate([
                // keyframes
                {
                    transform: 'translateX(0px)'
                    //transform: 'translate3D(10px , 10px , 10px)'
                },
                {
                    transform: 'rotateY(180deg)'
                    //transform: 'translate3D(100px,100px,100px)'
                },
                {
                    transform: 'rotateY(360deg)'
                    //transform: 'translate3D(100px,100px,100px)'
                }
            ], {
                // timing options
                fill: 'forwards',
                duration: 500
            });
        }.bind(this));
    }
}