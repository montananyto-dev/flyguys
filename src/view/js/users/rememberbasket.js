var cookie = getCookieValue("idCode");
var url = `http://localhost:8000/controller/bookings/getBasketFlights.php?cookie=${cookie}`;
$.ajax({
    url: url,
    success: function(result) {
        console.log(result);
        var flights = JSON.parse(result);
        for(var i=0;i<flights.length;i++) {
            var flight = flights[i];

            var startDate = new Date(flight.departure_date_time);
            var fullDate = days[startDate.getDay()] + " " + startDate.getDate() + " " + months[startDate.getMonth()];
            addElemsToBasket(flight, fullDate);
        }
    }
});