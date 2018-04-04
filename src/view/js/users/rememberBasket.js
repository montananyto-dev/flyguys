var cookie = getCookieValue("idCode");

if(cookie == null){

}else{

    console.log(cookie + " is not null and let check basket");

    var url = `http://localhost:8000/controller/bookings/getBasketFlights.php?cookie=${cookie}`;
    $.ajax({
        url: url,
        success: function (result) {

            var flights = JSON.parse(result);
            for (var i = 0; i < flights.length; i++) {
                var flight = flights[i];

                var startDate = new Date(flight.departure_date_time);
                var fullDate = days[startDate.getDay()] + " " + startDate.getDate() + " " + months[startDate.getMonth()] + " "+ startDate.getFullYear();
                addElemsToBasket(flight, fullDate);
            }
        }, error() {

            console.log('nothing');
        }
    });

}



