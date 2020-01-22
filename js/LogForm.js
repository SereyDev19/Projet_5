//LogForm class
class LogForm {
    constructor() {
        //DOM
        this.step1 = document.getElementById("step1");
        this.step2 = document.getElementById("step2");
        this.step3 = document.getElementById("step3");

        this.accessId = document.getElementById("access_id");
        this.email = document.getElementById("access_email");

        this.NextStep = document.getElementById("NextStep");

        this.width1 = parseFloat(getComputedStyle(this.step1).width.split("px")[0]);
        this.width2 = parseFloat(getComputedStyle(this.step2).width.split("px")[0]);
        this.width3 = parseFloat(getComputedStyle(this.step3).width.split("px")[0]);

        this.Form = document.getElementsByTagName("form")[0];
        this.Formwidth = parseFloat(getComputedStyle(this.Form).width.split("px")[0]);
        this.logo = document.getElementById("logo");
        this.step = 1;

        this.init();
        this.addListener();

    }


    init() {

    }

    addListener() {
        this.NextStep.addEventListener('click', function () {
            if (!this.accessId.validity.valueMissing && !this.email.validity.valueMissing) {
                this.displayForm();
            }
        }.bind(this));
    }


    displayForm() {
        if (this.step == 1) {
            var div1 = this.step1;
            var div2 = this.step2;
            var start = 0;
            var end = -450;
        } else {
            var div1 = this.step2;
            var div2 = this.step3;
            var start = -450;
            var end = -900;
        }


        this.animation = div1.animate([
            // keyframes
            {
                transform: 'translateX(' + start + 'px)',
            },
            {
                transform: 'translateX(' + end + 'px)',
            }
        ], {
            // timing options
            fill: 'forwards',
            duration: 500
        });


        var start = 0;
        var end = -420;

        this.animation = div2.animate([
            // keyframes
            {
                transform: 'translateX(' + start + 'px)'
            },
            {
                transform: 'translateX(' + end + 'px)'
            }
        ], {
            // timing options
            fill: 'forwards',
            duration: 500
        });
        this.step++;
    }
}
