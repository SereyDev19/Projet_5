class QueryAdsets {
    constructor(id, url) {
        this.id = id;
        this.button = document.getElementById(id);
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
                        // console.log(buttons[button])
                        // button.style.backgroundColor = "#f8ad22"
                        // button.style.border = "#fff"
                    }


                    for (var adset of response.adSets) {
                        var name = adset.adset_name.split(' ').join('')
                        if (name === this.id) {
                            this.res = adset;
                        }
                    }
                    //Remove previous data
                    if (document.getElementsByClassName("data").length != 0) {
                        console.log(document.getElementsByClassName("data"))
                        document.getElementsByClassName("data")[0].remove()
                    }


                    var sectionAdsets = document.getElementById("sectionAdsets")
                    var tempdiv = document.createElement("div")
                    tempdiv.setAttribute("class", "data")
                    sectionAdsets.appendChild(tempdiv)

                    var data = document.getElementsByClassName("data")[0]

                    tempdiv = document.createElement("div")
                    tempdiv.setAttribute("id", "optimization_goal")
                    tempdiv.setAttribute("class", "optimization_goal detailedresult mb-2")
                    data.appendChild(tempdiv)

                    tempdiv = document.createElement("div")
                    tempdiv.setAttribute("class", "resultsgroup d-flex justify-content-around mb-2")
                    data.appendChild(tempdiv)

                    tempdiv = document.createElement("div")
                    tempdiv.setAttribute("class", "costsgroup d-flex justify-content-around mb-2")
                    data.appendChild(tempdiv)

                    var sectionresultsgroup = document.getElementsByClassName("resultsgroup")[0]
                    var keysResults = ['clicks30d', 'leads30d']

                    for (var index in keysResults) {
                        tempdiv = document.createElement("div")
                        tempdiv.setAttribute("id", keysResults[index])
                        tempdiv.setAttribute("class", "detailedresult mb-2")
                        sectionresultsgroup.appendChild(tempdiv)
                    }

                    var sectioncostsgroup = document.getElementsByClassName("costsgroup")[0]
                    var keysCosts = ['cpm30d', 'spend30d', 'cost_per_click30d', 'cost_per_lead30d']

                    for (var index in keysCosts) {
                        tempdiv = document.createElement("div")
                        tempdiv.setAttribute("id", keysCosts[index])
                        tempdiv.setAttribute("class", "detailedresult mb-2")
                        sectioncostsgroup.appendChild(tempdiv)
                    }

                    var keys = ['optimization_goal',
                        'spend30d',
                        'cpm30d',
                        'clicks30d',
                        'cost_per_click30d',
                        'leads30d',
                        'cost_per_lead30d']

                    var realkeys = ['Objectif', 'Dépenses', 'CPM', 'Clics', 'Coût par clic', 'Leads', 'Coût par lead']

                    // Erase previous data in sectionAdsets
                    var sectionAds = document.getElementById("sectionAdsets")
                    var listdivs = sectionAds.getElementsByClassName("data")
                    var l = listdivs.length;
                    for (var index in keys) {
                        var temp = document.getElementById(keys[index])
                        temp.innerHTML = '';
                    }

                    //Write Content with main data
                    for (var index in keys) {
                        var unite = ''
                        var p1 = document.createElement("p")
                        p1.innerHTML = realkeys[index]
                        p1.setAttribute("class", "title")
                        this.div = document.getElementById(keys[index]);
                        var p2 = document.createElement("p")
                        if (keys[index] === 'spend30d' || keys[index] === 'cost_per_click30d' || keys[index] === 'cost_per_lead30d' || keys[index] === 'cpm30d') {
                            unite = '€'
                        }
                        p2.innerHTML = this.res[keys[index]] + unite;
                        // this.div.innerHTML = this.res[keys[index]];
                        this.div.appendChild(p1);
                        this.div.appendChild(p2)
                    }

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
                    var data = document.createElement("div")
                    data.setAttribute("class", "data")
                    sectionAds.appendChild(data)

                    ads.forEach(function (ad) {
                        var anAd = document.createElement("div")
                        anAd.setAttribute("class", "sectionAd")
                        var h4 = document.createElement("h4")
                        h4.innerHTML = ad.ad_name
                        var divtitle = document.createElement("div")
                        divtitle.appendChild(h4)
                        anAd.appendChild(divtitle)
                        data.appendChild(anAd)

                        tempdiv = document.createElement("div")
                        tempdiv.setAttribute("id", "optimization_goalad")
                        tempdiv.setAttribute("class", "optimization_goalad optimization_goal detailedresult mb-2")
                        anAd.appendChild(tempdiv)

                        tempdiv = document.createElement("div")
                        tempdiv.setAttribute("class", "resultsgroup d-flex justify-content-around mb-2")
                        anAd.appendChild(tempdiv)

                        tempdiv = document.createElement("div")
                        tempdiv.setAttribute("class", "costsgroup d-flex justify-content-around mb-2")
                        anAd.appendChild(tempdiv)

                        var sectionresultsgroup = anAd.getElementsByClassName("resultsgroup")[0]
                        var keysResults = ['clicks30d', 'leads30d']

                        for (var index in keysResults) {
                            tempdiv = document.createElement("div")
                            tempdiv.setAttribute("id", keysResults[index] + 'ad')
                            tempdiv.setAttribute("class", keysResults[index] + "ad detailedresult mb-2")
                            sectionresultsgroup.appendChild(tempdiv)
                        }

                        var sectioncostsgroup = anAd.getElementsByClassName("costsgroup")[0]
                        var keysCosts = ['cpm30d', 'spend30d', 'cost_per_click30d', 'cost_per_lead30d']

                        for (var index in keysCosts) {
                            tempdiv = document.createElement("div")
                            tempdiv.setAttribute("id", keysCosts[index] + 'ad')
                            tempdiv.setAttribute("class", keysCosts[index] + "ad detailedresult mb-2")
                            sectioncostsgroup.appendChild(tempdiv)
                        }


                        // Fill the ad contents
                        for (var index in keys) {
                            var unite = ''
                            var p1 = document.createElement("p")
                            p1.innerHTML = realkeys[index]
                            p1.setAttribute("class", "title")

                            var div = anAd.getElementsByClassName(keys[index] + 'ad')[0];
                            console.log(div)

                            var p2 = document.createElement("p")
                            if (keys[index] === 'spend30d' || keys[index] === 'cost_per_click30d' || keys[index] === 'cost_per_lead30d' || keys[index] === 'cpm30d') {
                                unite = '€'
                            }
                            p2.innerHTML = ad[keys[index]] + unite;
                            // this.div.innerHTML = this.res[keys[index]];
                            div.appendChild(p1);
                            div.appendChild(p2)
                        }
                    })


                    //Add CSS
                    var resultgroup = document.getElementsByClassName("resultsgroup");
                    var costsgroup = document.getElementsByClassName("costsgroup");
                    var detailedresult = document.getElementsByClassName("optimization_goal");
                    for (var i = 0; i < resultgroup.length; i++) {
                        resultgroup[i].style.borderColor = "#18a85c"
                        resultgroup[i].style.borderWidth = "2px"
                        resultgroup[i].style.borderStyle = "solid"
                        costsgroup[i].style.borderColor = "#ea5a63"
                        costsgroup[i].style.borderWidth = "2px"
                        costsgroup[i].style.borderStyle = "solid"
                        detailedresult[i].style.borderColor = "#f8ad22"
                        detailedresult[i].style.borderWidth = "2px"
                        detailedresult[i].style.borderStyle = "solid"
                    }

                }.bind(this));
            }
        )
    }
}