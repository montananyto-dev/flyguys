$("#search").click(function () {
    var fromValue = $("#from").val();
    var toValue = $("#to").val();

    var url = `http://localhost:8000/controller/locations/search.php?fromName=${fromValue}&toName=${toValue}`;

    var day = $("#day").val();
    var date = $("#date").val();
    if (day != "Day") {
        url += "&day=" + day;
    }
    if (date) {
        url += "&date=" + date;
    }

    retrieveData(url);
    return false;
})

function retrieveData(requestURL) {


    $.ajax({
        url: requestURL,
        success: function (result) {

            var flights = JSON.parse(result);

            var root = document.getElementById("results")

            removeChildren(root);

            if (flights.length > 0) {
                generateResults(root, flights);
            } else {
                displayNoResults(root);
            }


            return false;
        }

    });
}

function removeChildren(root) {
    while (root.firstChild)
        root.removeChild(root.firstChild);
}

function displayNoResults(root) {

    var title = document.createElement("h2");
    title.innerText = "No Results";

    var apology = document.createElement("h3");
    apology.setAttribute("class", "apology");
    apology.innerText = "Our apologies, we do not service this connection";

    root.appendChild(title);
    root.appendChild(apology);
}

function generateResults(root, flights) {

    var title = document.createElement("h2");
    title.innerHTML = "Results";

    root.appendChild(title);

    for (var i = 0; i < flights.length; i++) {
        generateResult(root, flights[i]);
    }
}

function generateResult(root, flight) {

    var locations = document.createElement("h3");
    var addBtn = document.createElement("button");
    var date = document.createElement("em");
    var times = document.createElement("h4");
    var section = document.createElement("section");

    // Set location text
    var floc = flight.connection.fromLocation;
    var tloc = flight.connection.toLocation;
    var flightDuration = flight.connection.flight_duration;

    locations.innerHTML = `${floc.name} (${floc.region.name}) - ${tloc.name} (${tloc.region.name})`;

    var startDate = new Date(flight.departure_date_time.replace(' ', 'T'));

    var a = flightDuration.split(':'); // split it at the colons
    // Hours are worth 60 minutes.
    var flightDurationToMinutes = (+a[0]) * 60 + (+a[1]);

    var departureToMinute = startDate.getMinutes() + startDate.getHours() * 60;

    var arrivalTime = convertMinutesToHoursMinutes(departureToMinute + flightDurationToMinutes);

    function convertMinutesToHoursMinutes(minutes) {
        let h = Math.floor(minutes / 60);
        let m = minutes % 60;
        h = h < 10 ? '0' + h : h;
        m = m < 10 ? '0' + m : m;
        return `${h}:${m}`;
    }


    var fullDate = days[startDate.getDay()] + " " + startDate.getDate() + " " + months[startDate.getMonth()] + " " + [startDate.getFullYear()];

    date.innerHTML = fullDate;

    // Set button text
    addBtn.innerHTML = `Add flight (£${flight.connection.cost})`;
    addBtn.addEventListener('click', function () {
        addToBasket(flight, fullDate);
    });


    // Set departure and arrival time text
    // var startHours = startDate.getHours();
    // If getMinutes() is less than 10, return a 0, if greater, return an empty string

    times.innerHTML = "Departing at " + startDate.getHours() + ":" + (startDate.getMinutes() < 10 ? '0' : '') + startDate.getMinutes()
        + ", Arriving at " + arrivalTime;

    // Set class for styling
    section.setAttribute("class", "flight");

    section.appendChild(locations);
    section.appendChild(date);
    section.appendChild(times);
    section.appendChild(addBtn);

    root.appendChild(section);


}

function addToBasket(flight, dateStr) {

    if (alreadyAdded(flight.id)) {
        alert("The flight " + flight.id+ " is aready in your basket");

    }else{

        var cookie = getCookieValue("idCode");
        var url = `http://localhost:8000/controller/bookings/addBooking.php?cookie=${cookie}&flightId=${flight.id}`;

        $.ajax({
            url: url,
            success: function (result) {
                console.log("Added flightId: " + flight.id + " to booking of account: " + getCookieValue("idCode"));
                addElemsToBasket(flight, dateStr);
            }
        });
    }
}

function addElemsToBasket(flight, dateStr) {

    var basketItems = document.querySelector('#basket div')

    var divBasket = document.createElement('div');
    divBasket.setAttribute('id',flight.id);

    var dateItem = document.createElement("em");
    dateItem.innerText = dateStr;

    var listItem = document.createElement('li');
    listItem.innerHTML = flight.connection.fromLocation.name + " to " + flight.connection.toLocation.name;

    var hiddenId = document.createElement("input");
    hiddenId.setAttribute("type", "hidden");
    hiddenId.setAttribute("value", flight.id);

    var buttonRemove = document.createElement('button');
    buttonRemove.setAttribute('id','removeFromBasket');
    buttonRemove.innerHTML = 'remove';
    buttonRemove.value = flight.id ;
    buttonRemove.addEventListener('click', function () {
        removeFromBasket(flight, divBasket);
    });

    var lineBreak = document.createElement('hr');


    basketItems.appendChild(divBasket);
    divBasket.appendChild(dateItem);
    divBasket.appendChild(buttonRemove);
    divBasket.appendChild(listItem);
    divBasket.appendChild(hiddenId);
    divBasket.appendChild(lineBreak);

}

function alreadyAdded(id) {
    var toReturn = false;
    var hiddenElems = document.querySelectorAll("#basket div input");
    hiddenElems.forEach(function (elem) {
        if (elem.getAttribute("value") == id) {
            toReturn = true;
        }
    });
    return toReturn;
}

function removeFromBasket(flight,divBasket){

    var cookie = getCookieValue("idCode");

    $.ajax({

        url: url = `http://localhost:8000/controller/bookings/removeBooking.php?cookie=${cookie}&toName=${toValue}`,

        success:function(result){

            alert(flight.id);
            $(divBasket).fadeOut();

        }

    })

}