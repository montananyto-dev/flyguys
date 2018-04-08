

$('#submit-login').on('click', function (e) {

    e.preventDefault();


    var email = $('#email-login').val();
    var password = $('#password-login').val();

    if (email.length < 5) {
        alert("Please ensure that your email is valid");
    }
    else if (password.length === 0) {
        alert("Please enter a password");
    } else {
        var formData = JSON.stringify($('#login-form').serializeArray());

        $.ajax({

            type: "POST",
            url: `http://localhost:8000/controller/accounts/login.php?cookie=${getCookieValue("idCode")}`,
            data: formData,
            dataType: "json",
            contentType: "application/json",

            success: function (result) {

                if (result === 'The account does not exist, please sign up') {
                    alert(result);

                } else if (result === 'The password does not match the email account') {
                    alert(result);
                } else {
                   var loginAccountDetails = result;

                    if (email === result.email) {

                        // confused what is happening here
                        if($('#finalSubmit').length){ // === 0 ? It's just .length

                        }else{
                            addButtonSubmitToForm();
                        }

                        login(loginAccountDetails);
                    }
                }
            }
        })
    }

});

$('#submit-signUp').on('click', function (e) {

    e.preventDefault();

    var email = $('#email-signUp').val();
    var password = $('#password-signUp').val();
    var passwordConfirmation = $('#passwordConfirmation-signUp').val();

    if (password != passwordConfirmation) {
        alert("Please ensure that the passwords are the same");
        return;
    }

    if (email.length < 5) {
        alert("Please ensure that your email is valid");
        return;
    }

    if (password.length === 0 || passwordConfirmation === 0) {
        alert("Please enter a password");
        return;
    }


    var formData = JSON.stringify($('#signUp-form').serializeArray());

    $.ajax({
        type: "POST",
        url: `http://localhost:8000/controller/accounts/signUp.php?cookie=${getCookieValue("idCode")}`,
        data: formData,
        dataType: "json",
        contentType: "application/json",

        success: function (result) {

            if(result==='The account already exist, please login to your account'){
                document.querySelector(".signUp-modal").classList.toggle("show-modal");
                document.querySelector(".login-modal").classList.toggle("show-modal");
            }else{

               var  signUpAccount = result;
                document.querySelector(".signUp-modal").classList.toggle("show-modal");

                if(!$('#finalSubmit').length){
                    addButtonSubmitToForm();
                }
            }
        }
    })

});

function addButtonSubmitToForm() {

    var submitButton = document.createElement('button');
    submitButton.setAttribute('id', 'finalSubmit');
    submitButton.innerHTML = 'pay now';

    $('#validPassengers').after(submitButton);

    submitButton.addEventListener('click', function (e) {

        e.preventDefault();

        var forms = [];
        $(".passengers").each(function () {
            forms = ($(this).find('form'));
        });

        var allPassengers = [];

        for(var i = 0; i < forms.length; i++) {
            var currentForm = forms[i];
            console.log(currentForm);

            var passenger = ({

                "fname": currentForm.fname.value,
                "mname": currentForm.mname.value,
                "lname": currentForm.lname.value,
                "passport_number": currentForm.passport_number.value,
                "identity_card": currentForm.identify_card.value,
                "country_code": currentForm.country_code.value,
                "dob": currentForm.dob.value
            });


            allPassengers.push(passenger);
        }

        var cookie = getCookieValue("idCode");
        var allPassengersJson = {"cookie":cookie,"passengers":allPassengers};
        var data = JSON.stringify(allPassengersJson);

        console.log(data);

        if (confirm('Would you like to pay now')) {

            $.ajax({
                type: "POST",
                url: `http://localhost:8000/controller/makePayment.php`,
                data: data,
                dataType: "json",
                contentType: "application/json",

                success: function (result) {

                    console.log("Sent, result: " + result);

                },
                error: function (err) {
                    console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                }
            });
        }

    });
}

function login(loginAccountDetails){

    console.log(loginAccountDetails);

    document.cookie = `idCode=${loginAccountDetails.cookie}`;

    console.log(document.cookie);

    var email = loginAccountDetails.email;

    document.querySelector(".login-modal").classList.toggle("show-modal");
    localStorage.setItem("loginState", "true");
    localStorage.setItem("loginEmail", email);
    $(".logout").show();
    $('#validPassengers').remove();

    $('.welcome').html("Welcome " + email);

}