function getCookieValue(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return null;
}

if (getCookieValue("idCode")) {
    console.log("Already have idCode:" + getCookieValue("idCode"));
} else {
    $.ajax({
        url: "http://localhost:8000/controller/SessionManager.php", success: function (result) {
            var json = JSON.parse(result);

            document.cookie = `idCode=${json.idCode}`;

            console.log("Got myself an idCode:" + getCookieValue("idCode"));

        },error(){

            console.log('nothing in the basket');
        }
    });
}