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