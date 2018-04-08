$('.logout').on('click', function (e) {
    e.preventDefault();
    $(".logout").hide();
    localStorage.setItem("loginState", "false");
    document.cookie = 'idCode=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    window.location.replace("index.html");

});