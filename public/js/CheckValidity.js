class CheckValidity {

    constructor(id) {
        this.id = id;
        console.log(this.id)
        this.form = document.getElementsByTagName('form')[0];
        this.input = document.getElementById("submit")
        this.email = document.getElementById(this.id);
        console.log(this.email)
        this.error = document.querySelector('.error');
    }

    check() {
        this.email.addEventListener("input", function (event) {
            // Each time the user type in something there is an email validation
            if (!this.email.validity.valid) {
                this.error.innerHTML = "Email invalide";
                this.error.className = "error";
                this.error.style.color = "red";
            } else {
                this.error.innerHTML = "Email valide";
                this.error.style.color = "#18a85c";
                this.input.removeAttribute("disabled")
                this.input.removeAttribute("class")
            }
        }.bind(this), false);
    }
}