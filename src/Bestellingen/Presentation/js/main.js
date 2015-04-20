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
            voornaam: "Vul uw achternaam in",
            naam: "Vul uw voornaam in",
            straat: "Geef uw straatnaam in",
            huisnummer: "Wat is uw huisnummer?",
            postcode: {
                required: "Vul uw postcode in",
                digits: "Enkel getallen toegestaan"
            },
            registeremail: {
                required: "Vul uw emailadres in aub",
                email: "Geldig emailadres vereist"
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
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