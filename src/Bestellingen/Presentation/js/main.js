$(document).ready(function ($) {
    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            paswoord: "required"
        },
        messages: {
            email: {
                required: "Vul emailadres in om in te loggen",
                email: "Geldig emailadres vereist"
            },
            paswoord: "Vul paswoord in aub"
        },
        errorLabelContainer: "#errorContainerLogin",
        wrapper: "li"
    });

    $("#registerForm").validate({
        rules: {
            voornaam: "required",
            naam: "required",
            straat: "required",
            huisnummer: "required",
            postcode: {
                required: true,
                digits: true
            },
            woonplaats: "required",
            registeremail: {
                required: true,
                email: true
            }
        },
        messages: {
            postcode: {
                digits: "Enkel getallen toegestaan"
            },
            registeremail: {
                required: "Vul uw emailadres in aub",
                email: "Geldig emailadres vereist"
            }
        }
    });

    $("#reLogin").validate({
        rules: {
            paswoord: "required"
        },
        messages: {
            paswoord: "Vul paswoord in aub"
        }
    });
});