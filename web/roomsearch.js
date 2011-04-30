// This file is part of the MRBS block for Moodle
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

function RoomSearch(){
//check for force book- if ticked we should be able to select any room

    dayInput=document.getElementsByName('day');
    day=dayInput[0].selectedIndex + 1;

    monthInput=document.getElementsByName('month');
    month=monthInput[0].selectedIndex + 1;

    yearInput=document.getElementsByName('year');
    year=yearInput[0].options[yearInput[0].selectedIndex].value;

    periodInput=document.getElementsByName('period');
    period=periodInput[0].selectedIndex;

    durationInput=document.getElementsByName('duration');
    duration=durationInput[0].value;

    dur_unitsInput=document.getElementsByName('dur_units');
    dur_units=dur_unitsInput[0].options[dur_unitsInput[0].selectedIndex].value;

    mincapInput=document.getElementsByName('mincap');
    mincap=mincapInput[0].value;

    teachingInput=document.getElementsByName('teaching');
    if(teachingInput[0].checked){teaching=1;}else{teaching=0;}

    specialInput=document.getElementsByName('special');
    if(specialInput[0].checked){special=1;}else{special=0;}

    computerInput=document.getElementsByName('computer');
    if(computerInput[0].checked){computer=1;}else{computer=0;}



    searchstring="?day="+day+"&month="+month+"&year="+year+"&period="+period+"&duration="+duration+"&dur_units="+dur_units+"&mincap="+mincap+"&teaching="+teaching+"&special="+special+"&computer="+computer;

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
          var rooms=document.getElementById('rooms');

          //wipe all the old options
          while ( rooms.childNodes.length >= 1 ){
              rooms.removeChild( rooms.firstChild );
          }
          if(xmlHttp.responseText!=''){
              document.getElementById('results').innerHTML=langRoomsFree;
              for (i = 0; i<freeRooms.length;  i++) {
                  room=freeRooms[i].split(",");
                  var newroom = document.createElement('tr');
                  for(j=0;j<room.length;j++){
                      var cell=document.createElement('td');
                      cell.innerHTML=room[j];
                      newroom.appendChild(cell);
                  }
                  rooms.appendChild(newroom);
              }

          }else{
              document.getElementById('results').innerHTML=langNoRooms;
          }

        }
    }
    xmlHttp.open("GET","roomsearch_ss.php"+searchstring,true);
    xmlHttp.send(null);
}

var mrbs_weekdaynames = null;

function SetWeekDayNames(mon, tue, wed, thu, fri, sat, sun) {
    mrbs_weekdaynames=new Array(7);
    mrbs_weekdaynames[1]=mon;
    mrbs_weekdaynames[2]=tue;
    mrbs_weekdaynames[3]=wed;
    mrbs_weekdaynames[4]=thu;
    mrbs_weekdaynames[5]=fri;
    mrbs_weekdaynames[6]=sat;
    mrbs_weekdaynames[0]=sun;
}

function ChangeOptionDays(formObj, prefix, updatefreerooms, roomsearch){

    var DaysObject = eval("formObj." + prefix + "day");
    var currentDay = DaysObject.selectedIndex;
    var MonthObject = eval("formObj." + prefix + "month");
    var YearObject = eval("formObj." + prefix + "year");

    //wipe current list
    for (j = DaysObject.options.length; j >= 0; j--) {
        DaysObject.options[j] = null;
    }
    var day=DaysObject.selectedIndex+1;
    var month=MonthObject.selectedIndex;
    var year=YearObject.options[YearObject.selectedIndex].value;


    var i=new Date();
    i.setDate(1);
    i.setMonth(month);
    i.setYear(year);

    while (i.getMonth()==month){

      DaysObject.options[i.getDate()-1] = new Option(mrbs_weekdaynames[i.getDay()]+" "+i.getDate(),i.getDate());
      i.setTime(i.getTime() + 86400000);
    }
   DaysObject.selectedIndex = currentDay;

    if(updatefreerooms){
        updateFreeRooms();
    }
    if(roomsearch){
        RoomSearch();
    }
}