var max_fields = 15;
var middle_field
var cur_x, cur_y;

var atimers = [];

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

 for( i=0; i < atimers.length; i++ ){

   var currentH = ( atimers[i][0] < 10 ? "0" : "" ) + atimers[i][0];
   var currentM = ( atimers[i][1] < 10 ? "0" : "" ) + atimers[i][1];
   var currentS = ( atimers[i][2] < 10 ? "0" : "" ) + atimers[i][2];
 
   currentTimeString = currentH + ":" + currentM + ":" + currentS;

   //alert( currentTimeString );
   if( currentTimeString == '00:00:00' ){
      //document.location.reload()
      //window.location = self.location;
      reload_page();
   }
   document.getElementById("restimer"+i).innerHTML = currentTimeString;

   if( atimers[i][2] >= 0 ) atimers[i][2] --;
   
   if( atimers[i][2] == -1){
        atimers[i][1] --;
        atimers[i][2] = 59;
   }

   if( atimers[i][1] == -1 ){ 
     if (atimers[i][0] > 0) { 
        atimers[i][0] --;
        atimers[i][1] = 59; 
     } else atimers[i][1] = 0;
   }
 }
}

function go_build( bnum ){
   location.href="build.php?bnum="+bnum;
}

function reload_page(){ 
  url=window.location.href;
  if(url.indexOf('?')!=-1){
     newurl = url.split('?')
     url = newurl[0];
  }
  document.location.href=url;
}


function set_qty( elem, qty ){
  document.getElementById("t"+elem).value = qty;
}

function init_training(){
    training.submit();
}

// ╚эшЎшшЁютрЄ№ шёёыхфютрэшх т └ърфхьшш
function do_research( atype ){
  url=window.location.href;
  if(url.indexOf('?')!=-1){
     newurl = url.split('?')
     params = newurl[1];
  }
  location.href="build.php?"+params+"&research="+atype;  
}

// ╚эшЎшшЁютрЄ№ єыєў°хэшх т ъєчэшЎх
function do_upgrade( atype, btype ){
  url=window.location.href;
  if(url.indexOf('?')!=-1){
     newurl = url.split('?')
     params = newurl[1];
  }
  location.href="build.php?"+params+"&upgrade="+atype+"&bt="+btype;  
}

