class FilterAds {
    constructor() {
        this.tables = document.getElementsByTagName("table")
        this.tr = this.tables[0].getElementsByTagName("tr");
        // this.tr = document.getElementsByTagName("tr");
        this.init();
    }

    init() {
        var testTR = document.getElementById("RTG - VV nettoyage routes");
        testTR.addEventListener("click", function () {
            console.log("toto")
        })


        // console.log(this.tr)
        // for (var value of this.tr) {
        //
        //     this.value = value;
        //     this.value.addEventListener('click', function () {
        //         console.log(this.value)
        //         var att = this.value.getAttribute("id")
        //         console.log(att)
        //         var ads = this.tables[1].getElementsByClassName(att) // array
        //         console.log(ads)
        //         for (var item of ads)
        //             item.remove();
        //     }.bind(this)(), false)
        // }
    }


}