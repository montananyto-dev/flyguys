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

