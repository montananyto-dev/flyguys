$("#checkout").click(function () {

    var bookingNumber = $("#check > div").length;

    if (bookingNumber <= 0) {
        alert("Your basket is empty, Please add a flight before check out");
    } else {
        window.location.replace("http://localhost:8000/view/users/checkout.html");
    }
})

