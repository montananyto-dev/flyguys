// $('#login-modal').on('click', function (e) {
//     e.preventDefault();
//     document.querySelector(".login-modal").classList.toggle("show-modal");
//
// });


//when clicking button "Or sign up option"
$('#signUp').on('click',function(e){
    e.preventDefault();
    document.querySelector(".login-modal").classList.toggle("show-modal");
    document.querySelector(".signUp-modal").classList.toggle("show-modal");
});

//when clicking button "Or login option"
$('#login').on('click',function(e){
    e.preventDefault();
    document.querySelector(".signUp-modal").classList.toggle("show-modal");
    document.querySelector(".login-modal").classList.toggle("show-modal");
});

$(".close-button-login").on('click', function () {
    document.querySelector(".login-modal").classList.toggle("show-modal");
});

$(".close-button-signUp").on('click', function () {
    document.querySelector(".signUp-modal").classList.toggle("show-modal");
});