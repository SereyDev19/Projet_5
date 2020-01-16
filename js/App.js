class App {

    constructor() {
        // this.init();
    }

    init() {
        this.CallButton = new CallButton();


    }

    plot(id, title, labelsValues, dataValues){
        var Plot = new Graphe();
        Plot.plot(id, title, labelsValues, dataValues);
    }


}
