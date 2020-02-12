class QueryAdsets {
    constructor(id, url) {
        this.id = id;
        this.button = document.getElementById(id);
        console.log(this.button)
        this.url = url;
        // console.log(this.url);

        this.init();
    }

    init() {
        var url = this.url
        this.button.addEventListener('click', function () {
                this.ajaxrequest = new AjaxRequest();
                this.ajaxrequest.ajax(url).then(function (response) {
                    this.data = response;
                    //CSS for all the buttons
                    var buttons = document.getElementsByClassName("adsetname")
                    for (var button of buttons) {
                        console.log(button)
                        // console.log(buttons[button])
                        // button.style.backgroundColor = "#f8ad22"
                        // button.style.border = "#fff"
                    }


                    for (var adset of response.adSets) {
                        if (adset.adset_name === this.id) {
                            this.res = adset;
                        }
                    }

                    var keys = ['optimization_goal',
                        'spend30d',
                        'cpm30d',
                        'clicks30d',
                        'cost_per_click30d',
                        'leads30d',
                        'cost_per_lead30d']

                    var realkeys = ['Objectif', 'dépenses', 'CPM', 'clics', 'coûr par clic', 'leads', 'coût par lead']

                    // Erase previous data in sectionAdsets
                    var sectionAds = document.getElementById("sectionAdsets")
                    var listdivs = sectionAds.getElementsByClassName("data")
                    var l = listdivs.length;
                    for (var index in keys) {
                        var temp = document.getElementById(keys[index])
                        temp.innerHTML = '';
                        // listdivs[i].innerHTML = '';
                    }

                    //Write Div with main data
                    for (var index in keys) {
                        var p1 = document.createElement("p")
                        p1.innerHTML = realkeys[index]
                        p1.setAttribute("class", "title")
                        this.div = document.getElementById(keys[index]);
                        var p2 = document.createElement("p")
                        p2.innerHTML = this.res[keys[index]];
                        // this.div.innerHTML = this.res[keys[index]];
                        this.div.appendChild(p1);
                        this.div.appendChild(p2)
                    }

                    //CSS
                    var resultgroup = document.getElementsByClassName("resultsgroup")[0];
                    var costsgroup = document.getElementsByClassName("costsgroup")[0];
                    var detailedresult = document.getElementsByClassName("detailedresult")[0];

                    resultgroup.style.borderColor = "#18a85c"
                    resultgroup.style.borderWidth = "2px"
                    resultgroup.style.borderStyle = "solid"
                    costsgroup.style.borderColor = "#ea5a63"
                    costsgroup.style.borderWidth = "2px"
                    costsgroup.style.borderStyle = "solid"
                    detailedresult.style.borderColor = "#f8ad22"
                    detailedresult.style.borderWidth = "2px"
                    detailedresult.style.borderStyle = "solid"

                    // Erase previous data in sectionAds
                    var sectionAds = document.getElementById("sectionAds")
                    var listdivs = sectionAds.getElementsByClassName("sectionAd")
                    console.log('longueur' + listdivs.length)
                    var l = listdivs.length;
                    for (var i = 0; i < l; i++) {
                        listdivs[0].remove();
                    }
                    // }

                    // Get the adsets ads data
                    // var sectionAds = document.getElementById("sectionAds")
                    var ads = this.data.allAds[this.res.adset_id];
                    ads.forEach(function (ad) {
                        var anAd = document.createElement("div")
                        anAd.setAttribute("class", "d-flex sectionAd justify-content-around")
                        var h4 = document.createElement("h4")
                        h4.innerHTML = ad.ad_name
                        var divtitle = document.createElement("div")
                        divtitle.appendChild(h4)
                        anAd.appendChild(divtitle)
                        sectionAds.appendChild(anAd)

                        // console.log(keys)
                        for (var index in keys) {
                            var elt = document.createElement("div");
                            elt.setAttribute("class", "detailedresult")
                            // console.log(ad[keys[index]])
                            elt.innerHTML = ad[keys[index]];
                            anAd.appendChild(elt);
                        }
                    })
                }.bind(this));
            }
        )
    }
}