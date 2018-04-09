$( document ).ready(function() {

    var loginState = localStorage.getItem('loginState');
    var email = localStorage.getItem('loginEmail');

    if(loginState === "true"){

        console.log("You are logged in");

        $('.welcome').html("Welcome " + email);

    }else{
        $('.welcome').html("Welcome, newcomer ");
        $(".logout").hide();
    }

});