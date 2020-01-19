//LogForm class
class LogForm {
    constructor() {
        //DOM
        this.step1 = document.getElementById("step1");
        this.step2 = document.getElementById("step2");
        this.step3 = document.getElementById("step3");

        this.accessId = document.getElementById("access_id");
        this.email = document.getElementById("access_email");

        this.step1Next = document.getElementById("step1Next");
        this.step2Next = document.getElementById("step2Next");

        this.width1 = parseFloat(getComputedStyle(this.step1).width.split("px")[0]);
        this.width2 = parseFloat(getComputedStyle(this.step2).width.split("px")[0]);
        this.width3 = parseFloat(getComputedStyle(this.step3).width.split("px")[0]);

        this.Form = document.getElementsByTagName("form")[0];
        this.Formwidth = parseFloat(getComputedStyle(this.Form).width.split("px")[0]);
        this.logo = document.getElementById("logo");

        this.init();
        this.addListener();

    }


    init() {

    }

    addListener() {
        this.step1Next.addEventListener('click', function titi() {
            if (!this.accessId.validity.valueMissing && !this.email.validity.valueMissing) {
                this.displayForm('1');
            }
        }.bind(this))
        this.step2Next.addEventListener('click', function titi() {
            this.displayForm('2');
        }.bind(this))
    }


    displayForm(i) {
        var start = -(parseInt(i) - 1) * this.Formwidth;
        var end = -(parseInt(i)) * this.Formwidth;

        var divname = 'step' + i;
        console.log(divname)
        var div = document.getElementById(divname);
        console.log(div)
        this.animation = div.animate([
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

        var j = parseInt(i) + 1;
        console.log(j)
        var divname = 'step' + j;
        var div = document.getElementById(divname);
        console.log(div)

        var start = 0;
        var end = -this.Formwidth;

        this.animation = div.animate([
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

    }
}
