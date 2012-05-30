function updateFreeRooms(){
//check for force book- if ticked we should be able to select any room

    dayInput=document.getElementsByName('day');
    day=dayInput[2].selectedIndex + 1;

    monthInput=document.getElementsByName('month');
    month=monthInput[2].selectedIndex + 1;

    yearInput=document.getElementsByName('year');
    year=yearInput[2].options[yearInput[2].selectedIndex].value;

    periodInput=document.getElementsByName('period');
    period=periodInput[0].selectedIndex;

    durationInput=document.getElementsByName('duration');
    duration=durationInput[0].value;

    dur_unitsInput=document.getElementsByName('dur_units');
    dur_units=dur_unitsInput[0].options[dur_unitsInput[0].selectedIndex].value;

    areasInput=document.getElementsByName('areas');
    if (areasInput.length) {
        area=areasInput[0].options[areasInput[0].selectedIndex].value;
    } else {
        area=0;
    }

    //currentroom is put onto edit_entry.php server-side
    searchstring="?day="+day+"&month="+month+"&year="+year+"&period="+period+"&duration="+duration+"&dur_units="+dur_units+"&area="+area+"&currentroom="+currentroom;

    if(canforcebook){
        forcebookInput=document.getElementsByName('forcebook');
        if(forcebookInput[0].checked){
            areasInput=document.getElementsByName('areas');
            area=areasInput[0].options[areasInput[0].selectedIndex].value;

            searchstring="?area="+area;
        }
    }


    //have to trial and error to get right browser code
    var xmlHttp;
    try{
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e){
        // Internet Explorer
        try{
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e){
            try{
                xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e){
                alert("Your browser does not support AJAX!");
                return false;
            }
        }
    }

    xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState==4){
          //We've got a list of rooms from the server
          freeRooms=xmlHttp.responseText.split("\n");
          roomsInput=document.getElementsByName('rooms[]');
          roomsInput=roomsInput[0];

          //remember which room is currently selected
          var currentSelection=new Array();
          if(roomsInput.selectedIndex!=-1){
              for (i=0;i<roomsInput.length;i++){
                  currentSelection[roomsInput.options[i].value]=roomsInput.options[i].selected;
              }
              roomsInput.selectedIndex=-1;
          }
          //wipe all the old options
          for (i = roomsInput.length; i >= 0; i--) {
              roomsInput[i] = null;
          }
          if(xmlHttp.responseText!=''){

              for (i = 0; i<freeRooms.length;  i++) {
                  if (freeRooms[i].search(/^\s*$/) != -1) {
                      continue; // Skip empty lines
                  }
                  room=freeRooms[i].split(",");
                  roomsInput.options[roomsInput.length]=new Option(room[1],room[0]);

                  //if this is the room we had selected, select it again
                  if(currentSelection[room[0]]){
                      roomsInput.options[roomsInput.length-1].selected=true;
                  }
              }

          }
        }
    }
    xmlHttp.open("GET","updatefreerooms.php"+searchstring,true);
    xmlHttp.send(null);



}