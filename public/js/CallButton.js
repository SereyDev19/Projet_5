class CallButton {
    constructor() {
        this.exportButton = document.getElementById('export');
        this.init();
    }

    init() {
        this.ajaxrequest = new AjaxRequest();
    }

    AJAX(url) {
        this.exportButton.addEventListener('click', function () {
            this.ajaxrequest.ajax(url)
        }.bind(this))
    }
}