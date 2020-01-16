class PlotLead {
    constructor(id) {
        this.button = document.getElementById(id);



        this.init();
    }

    init() {
        this.button.addEventListener('click', function () {

            this.ajaxrequest = new AjaxRequest();
            this.ajaxrequest.ajax(url).then(function (response) {
                this.listCanvas =  document.getElementsByTagName("canvas");
                for (var item of this.listCanvas){
                    console.log(item);
                    item.parentNode.removeChild(item);
                }

                this.canvas = document.createElement("canvas");
                this.canvas.setAttribute("id", "Lead");
                this.plotarea = document.getElementById("plotarea");
                this.plotarea.insertAdjacentElement("beforeend", this.canvas);


                console.log('tracer leads')
                console.log('Donnees recues');
                this.graph = new Graphe();
                var js_dates = Object.keys(response.history_lead);
                var js_values = Object.values(response.history_lead);

                this.Canvasid = 'Lead';
                this.title = 'Lead';

                this.graph.plot(this.Canvasid, this.title, js_dates, js_values);

            }.bind(this));


        })
    }
}