class App {

    constructor(url) {
        this.url = url;
    }

    init() {
        this.CallButton = new CallButton();
    }

    plotSpend(id) {
        this.PlotSpend = new PlotSpend(id, this.url);
    }

    plotLead(id) {
        this.PlotLead = new PlotLead(id, this.url);
    }

    plotCostPerLead(id) {
        this.PlotCostPerLead = new PlotCostPerLead(id, this.url);
    }

}
