class App {

    constructor(url_history, url_adsets) {
        this.url_history = url_history;
        this.url_adsets = url_adsets;
    }

    init() {
        // this.CallButton = new CallButton();
    }

    plotSpend(id) {
        console.log('plotSpend')
        this.PlotSpend = new PlotSpend(id, this.url_history);
    }

    plotLead(id) {
        console.log('plotLead')
        this.PlotLead = new PlotLead(id, this.url_history);
        this.PlotLead.plot();
    }

    plotCostPerLead(id) {
        console.log('plotCostPerLead')
        this.PlotCostPerLead = new PlotCostPerLead(id, this.url_history);
    }

    queryAdsets(id) {
        this.QueryAdsets = new QueryAdsets(id, this.url_adsets);
    }

}
