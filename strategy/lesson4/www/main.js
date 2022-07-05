var max_fields = 15;
var middle_field
var cur_x, cur_y;

function ajaxobj()
{
   var objXMLHttp = null;
   if (window.XMLHttpRequest)
   {
      objXMLHttp = new XMLHttpRequest();
   }
   else if (window.ActiveXObject)
   {
      objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
   }
   return objXMLHttp;
}

// отрисовка карты с центрированием по координатам x,y
function draw_field( x, y ){
     var r = parseInt(Math.random()*1000000000000000);
     m = ajaxobj();
     m.open('GET', 'fld.php?x='+x+'&y='+y+'&r='+r,false);
     m.send(null);
     if((m.readyState == 4) && (m.status == 200)) {
       fld_div.innerHTML = m.responseText;
       cur_x = x; cur_y = y;
     }
}

// смещение карты с проверкой возможности
function map_go_pos(dx,dy){
  if( ((cur_x-3+dx)>0) && ((cur_x+3+dx)<=15) ) cur_x += dx;
  if( ((cur_y-3+dy)>0) && ((cur_y+3+dy)<=15) ) cur_y += dy;
  draw_field( cur_x, cur_y );
}

function say_owner( s ){
   player.innerHTML = s;
}

function res_details( rf_id ){
   location.href='resb.php?p_rf_id='+rf_id;
}

function updateClock ( )
{
  var currentH = ( currentHours < 10 ? "0" : "" ) + currentHours;
  var currentM = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  var currentS = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
 
  currentTimeString = currentH + ":" + currentM + ":" + currentS;

  //alert( currentTimeString );
  if( currentTimeString == '00:00:00' ){
      location.href = 'res.php';
  }
  document.getElementById("restimer").innerHTML = currentTimeString;

  if( currentSeconds >= 0 ) currentSeconds --;

  if( currentSeconds == -1){
        currentMinutes --;
        currentSeconds = 59;
  }

  if( currentMinutes == -1 ){ 
     if (currentHours > 0) { 
        currentHours --;
        currentMinutes = 59; 
     } else currentMinutes = 0;
  }
}


