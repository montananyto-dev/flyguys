

$(function () {
    retrieveAllFlights('');
});

function retrieveAllFlights(regionName) {
    $.ajax({

        url: 'http://localhost:8000/controller/flights/getFlights.php' + regionName,
        success: function (result) {

            var allFlights = JSON.parse(result);
            var root = document.getElementById('main');
            clearTable(root);
            generateTable(allFlights, root);
            populateTable(allFlights, root);


        },
        error: function () {
        }
    })
}

function clearTable(root) {

    while (root.firstChild) {
        root.removeChild(root.firstChild);
    }

}

function generateTable(data, root) {

    var table = document.createElement('table');
    table.setAttribute('id', 'flight-table');

    var tr = document.createElement('tr');
    var th0 = document.createElement('th');
    th0.innerHTML = "Flight ID";
    var th1 = document.createElement('th');
    th1.innerHTML = "Departure";
    var th2 = document.createElement('th');
    th2.innerHTML = "Arrival";
    var th7 = document.createElement('th');
    th7.innerHTML = "Departure Time";
    var th3 = document.createElement('th');
    th3.innerHTML = "Capacity";
    var th4 = document.createElement('th');
    th4.innerHTML = "Cost";
    var th5 = document.createElement('th');
    th5.innerHTML = "Duration";
    var th6 = document.createElement('th');
    th6.innerHTML = "Region";

    tr.appendChild(th0);
    tr.appendChild(th1);
    tr.appendChild(th2);
    tr.appendChild(th7);
    tr.appendChild(th3);
    tr.appendChild(th4);
    tr.appendChild(th5);
    tr.appendChild(th6);

    table.appendChild(tr);


    root.appendChild(table);
}

function populateTable(data, root) {

    var td6 = "";

    var result = [];
    var departureTimeHtml = "";
    var capacityHtml = "";


    for (var i = 0; i < data.length; i++) {

        var tr = document.createElement('tr');
        tr.setAttribute('id', 'tr');

        var flightId = document.createElement('td');
        flightId.innerHTML = data[i].id;
        var locationFrom = document.createElement('td');
        locationFrom.innerHTML = data[i].connection.fromLocation.name;
        var locationTo = document.createElement('td');
        locationTo.innerHTML = data[i].connection.toLocation.name;
        var departureDateTime = document.createElement('td');
        departureDateTime.setAttribute('class', 'departure');
        departureDateTime.innerHTML = data[i].departure_date_time;
        var capacity = document.createElement('td');
        capacity.innerHTML = data[i].capacity;
        var cost = document.createElement('td');
        cost.innerHTML = data[i].connection.cost;
        var duration = document.createElement('td');
        duration.innerHTML = data[i].connection.flight_duration;
        var regionName = document.createElement('td');


        if (data[i].connection.toLocation.region.name == "Europe" || data[i].connection.fromLocation.region.name == "Europe") {

            regionName.innerHTML = "Europe";
        } else {
            regionName.innerHTML = "Domestic"
        }


        var buttonSave = document.createElement('button');
        buttonSave.innerHTML = 'save';
        buttonSave.setAttribute('class', 'save');
        buttonSave.setAttribute('id', 'edit' + 'Id' + i);
        buttonSave.addEventListener('click', function () {

            editFlights(this);


        });


        var buttonCancel = document.createElement('button');
        buttonCancel.innerHTML = 'cancel';
        buttonCancel.setAttribute('class', 'cancel');
        buttonCancel.setAttribute('id', 'edit' + data[i].id);
        buttonCancel.addEventListener('click', function () {

            editFlights(this, departureTimeHtml, capacityHtml);


        })


        var editButton = document.createElement('button');
        editButton.innerHTML = 'edit';
        editButton.setAttribute('class', 'edit');
        editButton.setAttribute('id', data[i].id);
        editButton.addEventListener('click', function () {

            result = editFlights(this);
            departureTimeHtml = result[0];
            capacityHtml = result[1];

        })


        var deleteButton = document.createElement('button');
        deleteButton.innerHTML = 'delete';
        deleteButton.setAttribute('class', 'delete');
        deleteButton.setAttribute('id', data[i].id);
        deleteButton.setAttribute('onclick', 'deleteFlight(this.id);');

        tr.appendChild(flightId);
        tr.appendChild(locationFrom);
        tr.appendChild(locationTo);
        tr.appendChild(departureDateTime);
        tr.appendChild(capacity);
        tr.appendChild(cost);
        tr.appendChild(duration);
        tr.appendChild(regionName);
        tr.appendChild(editButton);
        tr.appendChild(deleteButton);
        tr.appendChild(buttonSave);
        tr.appendChild(buttonCancel);
        root.appendChild(tr);

        $(buttonCancel).hide();
        $(buttonSave).hide();
    }
}

function editFlights(element, departureTimeHtml, capacityHtml) {

    var tr = element.closest('tr');

    var flightId = (tr).children.item(0).innerHTML;

    var departureTimeElement = (tr).children.item(3);
    var capacityElement = (tr).children.item(4);

    var editButton = (tr).children.item(8);
    var deleteButton = (tr).children.item(9);
    var saveButton = (tr).children.item(10);
    var cancelButton = (tr).children.item(11);

    var insideTD = element.closest('tr').children;

    if (element.className == "edit") {

        var departureTimeHtml = (tr).children.item(3).innerHTML;
        var capacityHtml = (tr).children.item(4).innerHTML;

        insideTD[3].contentEditable = true;
        insideTD[4].contentEditable = true;

        $('.edit').attr('disabled', true);
        $('.delete').attr('disabled', true);

        $(editButton).hide();
        $(deleteButton).hide();
        $(cancelButton).show();
        $(saveButton).show();

        return [departureTimeHtml, capacityHtml];


    } else if (element.className == 'cancel') {

        departureTimeElement.innerHTML = departureTimeHtml;
        capacityElement.innerHTML = capacityHtml;

        insideTD[3].contentEditable = false;
        insideTD[4].contentEditable = false;

        $('.edit').attr('disabled', false);
        $('.delete').attr('disabled', false);
        $(saveButton).hide();
        $(editButton).show();

    } else {


        if (confirm('Are you sure you want to save the changes for the Flight: ' + flightId + '?')) {

            var departureTime = (tr).children.item(3).innerHTML;
            var capacity = (tr).children.item(4).innerHTML;

            insideTD[3].contentEditable = false;
            insideTD[4].contentEditable = false;

            $('.edit').attr('disabled', false);
            $('.delete').attr('disabled', false);
            $(saveButton).hide();
            $(cancelButton).hide();
            $(editButton).show();
            $(deleteButton).show();

            $.ajax({

                url: `http://localhost:8000/controller/flights/editFlights.php?flightId=${flightId}&departureTime=${departureTime}&capacity=${capacity}`,
                success: function (result) {

                    alert(result);
                }
            })
        } else {
            // Do nothing!
        }
    }
}

function deleteFlight(id) {

    if (confirm('Are you sure you want to delete the Flight: ' + id + '?')) {
        document.getElementById(id).parentElement.remove();
        deleteFlightFromDatabase(id);
    } else {
        // Do nothing!
    }

}

function deleteFlightFromDatabase(flightNumber) {

    $.ajax({
        url: 'http://localhost:8000/controller/flights/deleteFlights.php' + '?flight_id=' + flightNumber,
        success: function (result) {
            alert(result);
        },
        error: function () {
        }
    })
}

function generateForm() {

    var root = document.getElementById('main');
    clearTable(root);

    var form = document.createElement('form');
    form.setAttribute('id', 'addDestination');

    var locationFromLabel = document.createElement('label');
    locationFromLabel.innerHTML = 'Departure';

    var locationFromSelect = document.createElement('select');
    locationFromSelect.setAttribute('id', 'locationFrom');
    locationFromSelect.name = 'locationFrom';
    var optionDefaultLocationFrom = document.createElement('option');
    optionDefaultLocationFrom.id = 'defaultLocationFrom';
    optionDefaultLocationFrom.innerHTML = 'Select Departure';

    var locationToLabel = document.createElement('label');
    locationToLabel.innerHTML = 'Arrival';

    var locationToSelect = document.createElement('select');
    locationToSelect.setAttribute('id', 'locationTo');
    locationToSelect.name = 'locationTo';
    var optionDefaultLocationTo = document.createElement('option');
    optionDefaultLocationTo.id = 'defaultLocationTo';
    optionDefaultLocationTo.innerHTML = 'Select Arrival';

    var regionLabel = document.createElement('label');
    regionLabel.innerHTML = 'region';
    var selectRegion = document.createElement('select');
    selectRegion.setAttribute('id', 'selectRegion');
    selectRegion.name = 'region';

    var flightDuration = document.createElement('label');
    flightDuration.innerHTML = 'Flight Duration';
    var flightDurationInput = document.createElement('input');
    flightDurationInput.id = 'flightDuration';
    flightDurationInput.name = 'flightDuration';

    flightDurationInput.setAttribute('readonly', 'readonly');

    var cost = document.createElement('label');
    cost.innerHTML = 'Cost';
    var costInput = document.createElement('input');
    costInput.setAttribute('id', 'cost');
    costInput.name = 'cost';
    costInput.setAttribute('readonly', 'readonly');

    var capacity = document.createElement('label');
    capacity.innerHTML = 'Capacity';
    var capacityInput = document.createElement('input');
    capacityInput.setAttribute('name', 'Capacity');
    capacityInput.setAttribute('min', '50');


    var departureDateLabel = document.createElement('label');
    departureDateLabel.innerHTML = 'Departure date';
    var departureDateInput = document.createElement('input');
    departureDateInput.setAttribute('name', 'departureDate');
    departureDateInput.setAttribute('type', 'date');


    var submitButton = document.createElement("button");
    submitButton.innerHTML = 'submit';
    submitButton.setAttribute('id', 'submit');

    $(function () {

        $('#addDestination').on('submit', function (e) {
            e.preventDefault();

            if(confirm('Would you like to add the flight to the system')){

                var formData = JSON.stringify($('#addDestination').serializeArray());

                $.ajax({

                    type: "POST",
                    url: 'http://localhost:8000/controller/flights/addFlights.php',
                    data: formData,
                    dataType: "json",
                    contentType: "application/json",
                    success: function (result) {

                        alert(result);

                    }, error: function () {
                    },
                });

            }else{
                //do nothing
            }

        });
    });

    form.appendChild(locationFromLabel);
    form.appendChild(locationFromSelect);
    form.appendChild(locationToLabel);
    form.appendChild(locationToSelect);
    form.appendChild(regionLabel);
    form.appendChild(selectRegion);
    form.appendChild(flightDuration);
    form.appendChild(flightDurationInput);
    form.appendChild(cost);
    form.appendChild(costInput);
    form.appendChild(capacity);
    form.appendChild(capacityInput);
    form.appendChild(departureDateLabel);
    form.appendChild(departureDateInput);
    form.appendChild(submitButton);

    locationFromSelect.appendChild(optionDefaultLocationFrom);
    locationToSelect.appendChild(optionDefaultLocationTo);

    root.appendChild(form);
    getAllLocationTo(locationFromSelect);

};

function getAllLocationTo(locationFromSelect) {

    $.ajax({

        url: "http://localhost:8000/controller/locations/names.php",
        success: function (result) {

            var locationFrom = JSON.parse(result);
            setOptionForSelectLocationFrom(locationFromSelect, locationFrom);

        }, error: function () {

        }
    });

};

function setOptionForSelectLocationFrom(locationFromSelect, locationFrom) {

    locationFrom.forEach(function (data) {
        var element = document.createElement('option');
        element.innerHTML = data;
        locationFromSelect.appendChild(element);

    });

};

$(document).on('change', '#locationFrom', function () {


    $('#defaultLocationFrom').remove();
    var selectedFromLocation = this.value;

    $.ajax({

        url: `http://localhost:8000/controller/locations/getConnectedLocations.php?name=${selectedFromLocation}`,

        success: function (result) {

            setOptionForSelectLocationTo(result);
            getFlightDurationAndCost();
        }
    })
})

$(document).on('change', '#locationTo', function () {

    updateRegion();
    getFlightDurationAndCost();

})

function getFlightDurationAndCost() {

    var locationTo = $('#locationTo').find(":selected").text();
    var locationFrom = $('#locationFrom').find(":selected").text();

    $.ajax({

        url: `http://localhost:8000/controller/connections/getConnectionFromTwoLocations.php?locationFrom=${locationFrom}&locationTo=${locationTo}`,

        success: function (result) {

            console.log(result);
            var data = JSON.parse(result);
            updateFlightDurationAndCost(data);
        }, error: function () {


        }
    })
}

function updateFlightDurationAndCost(data) {

    var flightDuration = data.flight_duration;
    var cost = data.cost;

    var flightDurationInput = $('#flightDuration');
    var costInput = $('#cost');

    if ($('#flightDuration').val().length === 0) {

        flightDurationInput.val(flightDurationInput.val() + flightDuration);
        costInput.val(costInput.val() + cost);
    } else {

        flightDurationInput.val("");
        costInput.val("");
        flightDurationInput.val(flightDurationInput.val() + flightDuration);
        costInput.val(costInput.val() + cost);
    }
}

function setOptionForSelectLocationTo(data) {

    var root = $('#locationTo')[0];
    clearDropDownArrival(root);

    $('#defaultLocationTo').remove();

    var toLocations = JSON.parse(data);

    if (toLocations.length > 1) {

        toLocations.forEach(function (data) {
            var element = document.createElement('option');
            element.innerHTML = data;
            root.append(element);

        })
    } else {
        var element = document.createElement('option');
        element.innerHTML = toLocations[0];
        root.append(element);
    }

    updateRegion();


}

function clearDropDownArrival(root) {
    while (root.firstChild) {
        root.removeChild(root.firstChild);
    }
}

function updateRegion() {

    if ($('#selectRegion option').length == 0) {

        console.log('empty');
    } else {

        $('#selectRegion option:first').remove();
    }
    var domestic = ['Stansted', 'Manchester', 'Glasgow', 'Dublin'];

    var locationTo = $('#locationTo').find(":selected").text();
    var locationFrom = $('#locationFrom').find(":selected").text();


    if (domestic.includes(locationTo) && domestic.includes(locationFrom)) {

        var element = document.createElement('option');
        element.innerHTML = 'Domestic';
        $('#selectRegion').append(element);
    } else {

        var element = document.createElement('option');
        element.innerHTML = 'Europe';
        $('#selectRegion').append(element);
    }

    $('#selectRegion')[0].lastChild;

}

