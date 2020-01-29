jQuery(function ($) {
    var alert = $('#alert');
    if (alert.length > 0) {
        alert.hide().slideDown(500).delay(1000).slideUp(500);
        alert.height(50);
    }
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

var app = new App;
