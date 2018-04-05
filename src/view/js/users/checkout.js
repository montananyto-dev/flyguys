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
    alert("No cookie, wtf!");
    // leave page
}

// $.ajax({
//     url: `http://localhost:8000/controller/accounts/getAccountDetails.php?cookie=${getCookieValue("idCode")}`,
//     success: function (result) {
//         var accountDetails = JSON.parse(result);
//
//         if (accountDetails.email == null) {
//             $("#payBtn").click(function () {
//                 document.querySelector(".signup-modal").classList.toggle("show-modal");
//             });
//             $(".close-button").click(function () {
//                 document.querySelector(".signup-modal").classList.toggle("show-modal");
//             });
//         } else {
//             $("#payBtn").click(function () {
//                 document.querySelector(".login-modal").classList.toggle("show-modal");
//             });
//             $(".close-button").click(function () {
//                 document.querySelector(".login-modal").classList.toggle("show-modal");
//             });
//         }
//     }
//
// });

$("#signupBtn").click(function () {
    //get values in signup form

    //submit to end-point
});

$.ajax({
    url: `http://localhost:8000/controller/bookings/getBasketFlights.php?cookie=${getCookieValue("idCode")}`,
    success: function (result) {
        var flights = JSON.parse(result);

        var list = document.querySelector("#checkoutFlights");
        flights.forEach(function (flight) {
            console.log(flight);
            var item = document.createElement("li");
            item.innerHTML = flight.connection.fromLocation.name + " to " + flight.connection.toLocation.name;

            item.addEventListener("click", function () {
                switchContext(flight.id, getCurrentPassengers());
            });

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
    var checkPassengerDiv = $('.passengers > section').length;

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

    if (result == true) {
        return false;
    } else {
        return true;
    }

}

function clearNumberOfPassengers(root) {
    while (root.firstChild) {
        root.removeChild(root.firstChild);
    }
}

function createPassengerDetailsSection(numberOfPassengers) {

    for (var i = 0; i < numberOfPassengers; i++) {

        var passengerFirstName = document.createElement("input");
        passengerFirstName.setAttribute("type", "text");
        passengerFirstName.setAttribute("placeholder", "firstName");
        passengerFirstName.setAttribute("required", "");

        var passengerMiddleName = document.createElement("input");
        passengerMiddleName.setAttribute("type", "text");
        passengerMiddleName.setAttribute("placeholder", "middleName");
        passengerMiddleName.setAttribute("required", "");

        var passengerLastName = document.createElement("input");
        passengerLastName.setAttribute("type", "text");
        passengerLastName.setAttribute("placeholder", "lastName");
        passengerLastName.setAttribute("required", "");

        var passportNumber = document.createElement("input");
        passportNumber.setAttribute("type", "text");
        passportNumber.setAttribute("placeholder", "passportNumber");
        passportNumber.setAttribute("required", "");

        var identifyCard = document.createElement("input");
        identifyCard.setAttribute("type", "text");
        identifyCard.setAttribute("placeholder", "identifyCard");
        identifyCard.setAttribute("required", "");

        var countryCode = document.createElement("input");
        countryCode.setAttribute("type", "text");
        countryCode.setAttribute("placeholder", "countryCode");
        countryCode.setAttribute("required", "");

        var dateOfBirth = document.createElement("input");
        dateOfBirth.setAttribute("type", "date");
        dateOfBirth.setAttribute("placeholder", "dateOfBirth");
        dateOfBirth.setAttribute("required", "");

        var section = document.createElement("section");
        section.setAttribute("class", "passengerDetails");
        section.setAttribute("id", i + 1);


        section.appendChild(passengerFirstName);
        section.appendChild(passengerMiddleName);
        section.appendChild(passengerLastName);
        section.appendChild(passportNumber);
        section.appendChild(identifyCard);
        section.appendChild(countryCode);
        section.appendChild(dateOfBirth);

        document.querySelector(".passengers").appendChild(section);

    }
}

function getCurrentPassengers() {
    // to resume, related to saving current passenger upon ContextSwtich.
    $("#passengerInfo").children;
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

$(".close-button-login").on('click',function () {

    document.querySelector(".login-modal").classList.toggle("show-modal");
});

$(".close-button-signUp").on('click',function () {

    document.querySelector(".signUp-modal").classList.toggle("show-modal");
});

$('#submit-login').on('click', function (e) {

    e.preventDefault();
    alert('submit login');

});


$('#submit-signUp').on('click', function (e) {

    e.preventDefault();
    alert('submit signUp');

});