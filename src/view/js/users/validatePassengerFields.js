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