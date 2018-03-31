$("#search").click(function() {
    var fromValue = $("#from").val();
    var toValue = $("#to").val();

    var url = `http://localhost:8000/controller/locations/search.php?fromName=${fromValue}&toName=${toValue}`

    var day = $("#day").val();
    var date = $("#date").val();
    if(day != "Day") {
        url += "&day="+ day;
    }
    if(date) {
        url += "&date="+ date;
    }

    retriveData(url);
    return false;
})

function retriveData(requestURL) {


    $.ajax({
        url: requestURL ,
        success: function(result) {
            var flights = JSON.parse(result);

            var root = document.getElementById("results")

            removeChildren(root);

            if(flights.length > 0) {
                generateResults(root,flights);
            } else {
                displayNoResults(root);
            }


            return false;
        }

    });
}

function removeChildren(root) {
    while(root.firstChild)
        root.removeChild(root.firstChild);
}

function displayNoResults(root) {
    var title = document.createElement("h2");
    title.innerText= "No Results";

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

    for(var i=0;i<flights.length;i++) {
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
    locations.innerHTML = `${floc.name} (${floc.region.name}) - ${tloc.name} (${tloc.region.name})`;

    var startDate = new Date(flight.departure_date_time);

    var fullDate = days[startDate.getDay()] + " " + startDate.getDate() + " " + months[startDate.getMonth()];

    date.innerHTML = fullDate;

    // Set button text
    addBtn.innerHTML = `Add flight (£${flight.connection.cost})`;
    addBtn.addEventListener('click', function() {
        addToBasket(flight, fullDate);
    });



    // Set departure and arrival time text
    startHours = startDate.getHours();
    times.innerHTML = "Departing at " + startDate.getHours() + ":" + startDate.getMinutes() + ", Arriving at {temp}";

    // Set class for styling
    section.setAttribute("class","flight");

    section.appendChild(locations);
    section.appendChild(addBtn);
    section.appendChild(date);
    section.appendChild(times)

    root.appendChild(section);
}

function addToBasket(flight, dateStr) {

    if(alreadyAdded(flight.id)) {
        console.log("Item already added");
        return;
    }

    var cookie = getCookieValue("idCode");
    var url = `http://localhost:8000/controller/bookings/addBooking.php?cookie=${cookie}&flightId=${flight.id}`;

    $.ajax({
        url: url,
        success: function(result) {
            console.log("Added flightId: "+ flight.id + " to booking of account: " + getCookieValue("idCode"));
        }
    });

    addElemsToBasket(flight, dateStr);
}

function addElemsToBasket(flight, dateStr) {
    var basketItems = document.querySelector('#basket div');

    var dateItem = document.createElement("em");
    dateItem.innerText = dateStr;

    var listItem = document.createElement('li');
    listItem.innerHTML = flight.connection.fromLocation.name + " to " + flight.connection.toLocation.name;

    var hiddenId = document.createElement("input");
    hiddenId.setAttribute("type","hidden");
    hiddenId.setAttribute("value", flight.id);

    basketItems.appendChild(dateItem);
    basketItems.appendChild(listItem);
    basketItems.appendChild(hiddenId);
}

function alreadyAdded(id) {
    var toReturn = false;
    var hiddenElems = document.querySelectorAll("#basket div input");
    hiddenElems.forEach(function(elem) {
        if(elem.getAttribute("value") == id) {
            toReturn = true;
        }
    });
    return toReturn;
}