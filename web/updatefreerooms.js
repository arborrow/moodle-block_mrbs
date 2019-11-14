function updateFreeRooms() {
//check for force book- if ticked we should be able to select any room

    var instanceInput = document.getElementsByName('instance');
    var instance_id = instanceInput[0].value;
    
    var dayInput = document.getElementsByName('day');
    var day = dayInput[2].selectedIndex + 1;

    var monthInput = document.getElementsByName('month');
    var month = monthInput[2].selectedIndex + 1;

    var yearInput = document.getElementsByName('year');
    var year = yearInput[2].options[yearInput[2].selectedIndex].value;

    var periodInput = document.getElementsByName('period');
    var period = periodInput[0].selectedIndex;

    var durationInput = document.getElementsByName('duration');
    var duration = durationInput[0].value;

    var dur_unitsInput = document.getElementsByName('dur_units');
    var dur_units = dur_unitsInput[0].options[dur_unitsInput[0].selectedIndex].value;

    var areasInput = document.getElementsByName('areas');
    var area = 0;
    if (areasInput.length) {
        area = areasInput[0].options[areasInput[0].selectedIndex].value;
    }

    //currentroom is put onto edit_entry.php server-side
    var searchstring = "?instance=" + instance_id + "&day=" + day + "&month=" + month + "&year=" + year + "&period=" + period + "&duration=" + duration + "&dur_units=" + dur_units + "&area=" + area + "&currentroom=" + currentroom;

    if (canforcebook) {
        var forcebookInput = document.getElementsByName('forcebook');
        if (forcebookInput[0].checked) {
            areasInput = document.getElementsByName('areas');
            area = areasInput[0].options[areasInput[0].selectedIndex].value;

            searchstring = "?area=" + area;
        }
    }

    //have to trial and error to get right browser code
    var xmlHttp;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    }
    catch (e) {
        // Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
            try {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {
                window.alert("Your browser does not support AJAX!");
                return false;
            }
        }
    }

    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4) {
            //We've got a list of rooms from the server
            var freeRooms = xmlHttp.responseText.split("\n");
            var roomsInput = document.getElementsByName('rooms[]');
            roomsInput = roomsInput[0];

            //remember which room is currently selected
            var currentSelection = [];
            var i;
            var room;
            if (roomsInput.selectedIndex !== -1) {
                for (i = 0; i<roomsInput.length; i++) {
                    currentSelection[roomsInput.options[i].value] = roomsInput.options[i].selected;
                }
                roomsInput.selectedIndex = -1;
            }
            //wipe all the old options
            for (i = roomsInput.length; i>=0; i--) {
                roomsInput[i] = null;
            }
            if (xmlHttp.responseText !== '') {

                for (i = 0; i<freeRooms.length; i++) {
                    if (freeRooms[i].search(/^\s*$/) !== -1) {
                        continue; // Skip empty lines
                    }
                    room = freeRooms[i].split(/,(.*)/);
                    roomsInput.options[roomsInput.length] = new Option(room[1], room[0]);

                    //if this is the room we had selected, select it again
                    if (currentSelection[room[0]]) {
                        roomsInput.options[roomsInput.length - 1].selected = true;
                    }
                }

            }
        }
    };
    xmlHttp.open("GET", "updatefreerooms.php" + searchstring, true);
    xmlHttp.send(null);

}
