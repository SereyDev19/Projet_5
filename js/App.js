class App {

    constructor() {
        // this.init();
    }

    init() {
        this.CallButton = new CallButton();


    }

    plotSpend(id, url) {
        this.PlotSpend = new PlotSpend(id, url);

    }

    plotLead(id, url) {
        this.PlotLead = new PlotLead(id, url);
    }

    plotCostPerLead(id, url) {
        this.PlotCostPerLead = new PlotCostPerLead(id, url);
    }

}
