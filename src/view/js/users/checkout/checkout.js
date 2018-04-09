function validLoginCredentials(email, pwd) {
    return email.length >= 5 && pwd.length > 0;
}

$('#submit-login').on('click', function (e) {

    e.preventDefault();

    var email = $('#email-login').val();
    var password = $('#password-login').val();

    if (validLoginCredentials(email, password)) {
        submitForLogin();
    }

});

function submitForLogin() {

    var formData = JSON.stringify($('#login-form').serializeArray());

    $.ajax({
        type: "POST",
        url: `http://localhost:8000/controller/accounts/login.php?cookie=${getCookieValue("idCode")}`,
        data: formData,
        dataType: "json",
        contentType: "application/json",

        success: function (result) {

            if (result === 'The account does not exist, please sign up') {
                alert(result);

            } else if (result === 'The password does not match the email account') {
                alert(result);
            } else {
                document.querySelector(".login-modal").classList.toggle("show-modal");
                var loginAccountDetails = result;
                login(loginAccountDetails);

            }
        }
    })
}

$('#submit-signUp').on('click', function (e) {

    e.preventDefault();

    var email = $('#email-signUp').val();
    var password = $('#password-signUp').val();
    var passwordConfirmation = $('#passwordConfirmation-signUp').val();

    if (password != passwordConfirmation) {
        alert("Please ensure that the passwords are the same");
        return;
    }

    if (email.length < 5) {
        alert("Please ensure that your email is valid");
        return;
    }

    if (password.length === 0 || passwordConfirmation === 0) {
        alert("Please enter a password");
        return;
    }

    submitForSignUp();


});

function submitForSignUp() {

    var formData = JSON.stringify($('#signUp-form').serializeArray());

    $.ajax({
        type: "POST",
        url: `http://localhost:8000/controller/accounts/signUp.php?cookie=${getCookieValue("idCode")}`,
        data: formData,
        dataType: "json",
        contentType: "application/json",

        success: function (result) {

            if (result === 'The account already exist, please login to your account') {

                alert(result);
                document.querySelector(".signUp-modal").classList.toggle("show-modal");
                document.querySelector(".login-modal").classList.toggle("show-modal");
            } else {

                alert(" The account has been created");

                document.querySelector(".signUp-modal").classList.toggle("show-modal");
                document.querySelector(".login-modal").classList.toggle("show-modal");

            }
        }
    })
}

function login(loginAccountDetails) {

    document.cookie = `idCode=${loginAccountDetails.cookie}`;

    var email = loginAccountDetails.email;

    localStorage.setItem("loginState", "true");
    localStorage.setItem("loginEmail", email);
    $(".logout").show();

    $('.welcome').html("Welcome " + email);

    addButtonSubmitToForm();

}

function addButtonSubmitToForm() {

    var cookie = getCookieValue("idCode");
    var amount = $(".numberOfPassengers").val();

    $.ajax({
        url: `http://localhost:8000/controller/bookings/calculateTotal.php?cookie=${cookie}&amount=${amount}`,

        success: function (totalCost) {
            var data = JSON.parse(totalCost);

            console.log("ADD FINAL BUTTON");

            var submitButton = document.createElement('button');
            submitButton.setAttribute('id', 'finalSubmit');
            submitButton.innerHTML = `Pay (£${data.total})`;

            $('#validPassengers').after(submitButton);

            $('#validPassengers').hide();

            addPaymentEvent(submitButton);

        },
        error: function (err) {
            console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
        }
    });
}

function addPaymentEvent(submitButton) {

    submitButton.addEventListener('click', function (e) {

        e.preventDefault();

        var forms = [];
        $(".passengers").each(function () {
            forms = ($(this).find('form'));
        });

        var allPassengers = [];

        for (var i = 0; i < forms.length; i++) {
            var currentForm = forms[i];

            var passenger = ({

                "fname": currentForm.fname.value,
                "mname": currentForm.mname.value,
                "lname": currentForm.lname.value,
                "passport_number": currentForm.passport_number.value,
                "identity_card": currentForm.identify_card.value,
                "country_code": currentForm.country_code.value,
                "dob": currentForm.dob.value
            });


            allPassengers.push(passenger);
        }

        var cookie = getCookieValue("idCode");
        var allPassengersJson = {"cookie": cookie, "passengers": allPassengers};
        var data = JSON.stringify(allPassengersJson);

        if (confirm('Would you like to pay now')) {

            $.ajax({
                type: "POST",
                url: `http://localhost:8000/controller/makePayment.php`,
                data: data,
                dataType: "json",
                contentType: "application/json",

                success: function (result) {

                    console.log("Sent, result: " + result);

                },
                error: function (err) {
                    console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                }
            });
        }

    });
}

$('#validPassengers').on('click', function (e) {

    e.preventDefault();

    var loginState = localStorage.getItem('loginState');

        var numberOfPassengers = $('.numberOfPassengers').val();
        var checkPassengerDiv = $('.passengers > form').length;

        var check = validationPassengersField();

        if (numberOfPassengers === 0) {
            alert('Please add a passenger');
        } else if (checkPassengerDiv === 0) {
            alert("Please valid the number of passengers");
        } else if (check) {
            alert("Please enter the passenger details");
        } else {
            if(loginState === "true"){
                addButtonSubmitToForm();
            }else{
                document.querySelector(".signUp-modal").classList.toggle("show-modal");
            }
        }
});

function validationPassengersField() {

    var result = $(".passengers input[required]").filter(function () {
        return $.trim($(this).val()).length === 0
    }).length === 0;

    return !result;

}