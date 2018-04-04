$.ajax({url: "http://localhost:8000/controller/locations/names.php", success: function(result) {
    var fromLocations = JSON.parse(result);
    // For From Locations - Generate DataList and set valid inputs
    setDataList(document.querySelector("#fromlist"), fromLocations);
    setValidInputs(document.querySelector("#from"), fromLocations);

    $("#from").focusout(function() {
        var selectedFromLocation = document.getElementById("from").value;
        $.ajax({url: `http://localhost:8000/controller/locations/getConnectedLocations.php?name=${selectedFromLocation}`, success: function(result) {

            var toLocations = JSON.parse(result);
            deleteChildItems(document.querySelector("#tolist"));
            setDataList(document.querySelector("#tolist"), toLocations);
            setValidInputs(document.querySelector("#to"), fromLocations);
        }});

    })
}});

function deleteChildItems(elem) {
    while (elem.firstChild) {
        elem.removeChild(elem.firstChild);
    }
}

function setDataList(dataListElem, locations) {
    for(var i=0; i< locations.length; i++) {
        var elem = document.createElement("option");
        elem.setAttribute("value", locations[i]);
        dataListElem.appendChild(elem);
    }
}

function setValidInputs(elem, arr) {
    elem.addEventListener("change", function() {
        if(arr.indexOf(elem.value) < 0) {
            elem.removeAttribute("class");
            elem.setAttribute("class", "wrong");
        } else {
            elem.removeAttribute("class");
            elem.setAttribute("class","right");
        }
    });  
}