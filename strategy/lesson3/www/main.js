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

function map_go_pos(dx,dy){
  if( ((cur_x-3+dx)>0) && ((cur_x+3+dx)<=15) ) cur_x += dx;
  if( ((cur_y-3+dy)>0) && ((cur_y+3+dy)<=15) ) cur_y += dy;
  draw_field( cur_x, cur_y );
}

function say_owner( s ){
   player.innerHTML = s;
}
