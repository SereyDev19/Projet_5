class AjaxRequest {
    constructor() {
        this.data = [];
    }

// Exécute un appel AJAX GET
// Prend en paramètres l'URL cible et la fonction callback appelée en cas de succès
    ajaxGet(url) {
        return new Promise(function (resolve, reject) {
            var req = new XMLHttpRequest();
            req.open("GET", url);
            req.addEventListener("load", function () {
                if (req.status >= 200 && req.status < 400) {
                    // Appelle la fonction callback en lui passant la réponse de la requête
                    resolve(req.responseText);
                } else {
                    reject(req.status + " " + req.statusText + " " + url);
                }
            });
            req.addEventListener("error", function () {
                console.error("Erreur réseau avec l'URL " + url);
            });
            req.send(null);
        })
    }

    ajax(url) {
        return new Promise(function (resolve, reject) {
            // console.log(url)
            this.ajaxGet(url).then(function (response) {
                // console.log("Requête Ajax lancée");
                this.data = JSON.parse(response);
                resolve(this.data);
                // console.log(this.data);
            }.bind(this)).catch(function (req) {
                console.error(url)
                console.error("Pb URL");
                reject("Pb requête ajax")
            })
        }.bind(this))
    }
}