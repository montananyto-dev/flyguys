
// function to check the login state
$( document ).ready(function() {

    var loginState = localStorage.getItem('loginState');
    var email = localStorage.getItem('loginEmail');

    if(loginState === "true"){

        $('.welcome').html("Welcome " + email);

    }else{
        $('.welcome').html("Welcome, newcomer ");
        $(".logout").hide();
    }

});

$('.logout').on('click', function (e) {

    e.preventDefault();
    $(".logout").hide();
    localStorage.setItem("loginState", "false");
    document.cookie = 'idCode=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    window.location.replace("index.html");

});

function getCookieValue(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return null;
}

if (getCookieValue("idCode") == null) {
    window.location.replace("index.html");
}

$.ajax({
    url: `http://localhost:8000/controller/bookings/getBasketFlights.php?cookie=${getCookieValue("idCode")}`,
    success: function (result) {
        var flights = JSON.parse(result);
        console.log(flights);
        var list = document.querySelector("#checkoutFlights");
        flights.forEach(function (flight) {
            var item = document.createElement("li");
            item.innerHTML = flight.connection.fromLocation.name + " to " + flight.connection.toLocation.name;
            item.innerText += ` (£${flight.connection.cost})`;

            list.appendChild(item);
        });

    }

});

$('#addPassengers').on('click', function (e) {

    e.preventDefault();

    var numberOfPassengers = $('.numberOfPassengers').val();

    if (numberOfPassengers == 0) {
        alert('Add a minimum of one passenger');
    } else {
        var root = document.querySelector(".passengers");
        clearNumberOfPassengers(root);
        createPassengerDetailsSection(numberOfPassengers);
    }
});

$('#validPassengers').on('click', function (e) {

    e.preventDefault();

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
        document.querySelector(".login-modal").classList.toggle("show-modal");
    }
});

function validationPassengersField() {

    var result = $(".passengers input[required]").filter(function () {
        return $.trim($(this).val()).length === 0
    }).length === 0;

    return !result;

}

function clearNumberOfPassengers(root) {
    while (root.firstChild) {
        root.removeChild(root.firstChild);
    }
}

function createPassengerDetailsSection(numberOfPassengers) {

    for (var i = 0; i < numberOfPassengers; i++) {

        var idnum = document.createElement("p");
        idnum.innerText = `Passenger No. ${i + 1}: `;

        var form = document.createElement('form');
        form.setAttribute("class", "singlePassenger");
        form.setAttribute("id", "form" + (i + 1));

        var passengerFirstName = document.createElement("input");
        passengerFirstName.setAttribute("type", "text");
        passengerFirstName.setAttribute("placeholder", "First Name");
        passengerFirstName.setAttribute("name", "fname");
        passengerFirstName.setAttribute("required", "");

        var passengerMiddleName = document.createElement("input");
        passengerMiddleName.setAttribute("type", "text");
        passengerMiddleName.setAttribute("placeholder", "Middle Name");
        passengerMiddleName.setAttribute("name", "mname");
        passengerMiddleName.setAttribute("required", "");

        var passengerLastName = document.createElement("input");
        passengerLastName.setAttribute("type", "text");
        passengerLastName.setAttribute("placeholder", "Last Name");
        passengerLastName.setAttribute("name", "lname");
        passengerLastName.setAttribute("required", "");

        var row1 = document.createElement("div");
        row1.setAttribute("class", "row");

        row1.appendChild(passengerFirstName);
        row1.appendChild(passengerMiddleName);
        row1.appendChild(passengerLastName);

        var passportNumber = document.createElement("input");
        passportNumber.setAttribute("type", "text");
        passportNumber.setAttribute("placeholder", "Passport Number");
        passportNumber.setAttribute("name", "passport_number");
        passportNumber.setAttribute("required", "");

        var seperator = document.createElement("span");
        seperator.innerText = "/";

        var identifyCard = document.createElement("input");
        identifyCard.setAttribute("type", "text");
        identifyCard.setAttribute("placeholder", "ID Card");
        identifyCard.setAttribute("name", "identify_card");
        identifyCard.setAttribute("required", "");

        var row2 = document.createElement("div");
        row2.setAttribute("class", "row");

        row2.appendChild(passportNumber);
        row2.appendChild(seperator);
        row2.appendChild(identifyCard);

        var countryCode = document.createElement("input");
        countryCode.setAttribute("type", "text");
        countryCode.setAttribute("placeholder", "Country Code");
        countryCode.setAttribute("name", "country_code");
        countryCode.setAttribute("required", "");

        var dateOfBirth = document.createElement("input");
        dateOfBirth.setAttribute("type", "date");
        dateOfBirth.setAttribute("name", "dob");
        dateOfBirth.setAttribute("required", "");

        var row3 = document.createElement("div");
        row3.setAttribute("class", "row");

        row3.appendChild(countryCode);
        row3.appendChild(dateOfBirth);

        form.appendChild(idnum);
        form.appendChild(row1);
        form.appendChild(row2);
        form.appendChild(row3);

        document.querySelector(".passengers").appendChild(form);

    }
}

$('#login-modal').on('click', function (e) {

    e.preventDefault();
    document.querySelector(".login-modal").classList.toggle("show-modal");

});

$('#signUp').on('click', function (e) {

    e.preventDefault();
    document.querySelector(".login-modal").classList.toggle("show-modal");
    document.querySelector(".signUp-modal").classList.toggle("show-modal");

});

$('#login').on('click', function (e) {

    e.preventDefault();
    document.querySelector(".signUp-modal").classList.toggle("show-modal");
    document.querySelector(".login-modal").classList.toggle("show-modal");

});

$(".close-button-login").on('click', function () {

    document.querySelector(".login-modal").classList.toggle("show-modal");
});

$(".close-button-signUp").on('click', function () {

    document.querySelector(".signUp-modal").classList.toggle("show-modal");
});

$('#submit-login').on('click', function (e) {

    e.preventDefault();


    var email = $('#email-login').val();
    var password = $('#password-login').val();

    if (email.length < 5) {
        alert("Please ensure that your email is valid");
    }
    else if (password.length === 0) {
        alert("Please enter a password");
    } else {
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
                   var loginAccountDetails = result;

                    if (email === result.email) {

                        // confused what is happening here
                        if($('#finalSubmit').length){ // === 0 ? It's just .length

                        }else{
                            addButtonSubmitToForm();
                        }

                        login(loginAccountDetails);
                    }
                }
            }
        })
    }


});

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


    var formData = JSON.stringify($('#signUp-form').serializeArray());

    $.ajax({
        type: "POST",
        url: `http://localhost:8000/controller/accounts/signUp.php?cookie=${getCookieValue("idCode")}`,
        data: formData,
        dataType: "json",
        contentType: "application/json",

        success: function (result) {

            if(result==='The account already exist, please login to your account'){
                document.querySelector(".signUp-modal").classList.toggle("show-modal");
                document.querySelector(".login-modal").classList.toggle("show-modal");
            }else{

               var  signUpAccount = result;
                document.querySelector(".signUp-modal").classList.toggle("show-modal");
                //document.querySelector(".login-modal").classList.toggle("show-modal");

                // if($('#finalSubmit').length){
                //
                // }else{
                //     addButtonSubmitToForm();
                // }

                if(!$('#finalSubmit').length){
                    addButtonSubmitToForm();
                }
            }

        }
    })

});

function addButtonSubmitToForm() {

    var submitButton = document.createElement('button');
    submitButton.setAttribute('id', 'finalSubmit');
    submitButton.innerHTML = 'pay now';

    $('#validPassengers').after(submitButton);

    submitButton.addEventListener('click', function (e) {

        e.preventDefault();

        var forms = [];
        $(".passengers").each(function () {
            forms = ($(this).find('form')); //<-- Should return all input elements in that specific form.
        });

        var allPassengers = Array();

        for(var i = 0; i < forms.length; i++) {
            var currentForm = forms[i];
            console.log(currentForm);

            var passenger = ({

                "fname": currentForm.fname.value,
                "mname": currentForm.mname.value,
                "lname": currentForm.lname.value,
                "passport_number": currentForm.passport_number.value,
                "identity_card": currentForm.identify_card.value,
                "country_code": currentForm.country_code.value,
                "dob": currentForm.dob.value
            })


            allPassengers.push(passenger);
        }

        var cookie = getCookieValue("idCode");

        var allPassengersJson = {"cookie":cookie,"passengers":allPassengers};

        var data = JSON.stringify(allPassengersJson);

        console.log(data);

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

function login(loginAccountDetails){

    console.log(loginAccountDetails);

    document.cookie = `idCode=${loginAccountDetails.cookie}`;

    console.log(document.cookie);

    var email = loginAccountDetails.email;

    document.querySelector(".login-modal").classList.toggle("show-modal");
    localStorage.setItem("loginState", "true");
    localStorage.setItem("loginEmail", email);
    $(".logout").show();
    $('#validPassengers').remove();

    $('.welcome').html("Welcome " + email);

    //location.reload();

}


