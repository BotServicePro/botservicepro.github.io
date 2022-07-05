var max_fields = 15;
var middle_field
var cur_x, cur_y;

var atimers = [];
var url_reload = "";

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

// ®ваЁб®ўЄ  Є авл б жҐ­ваЁа®ў ­ЁҐ¬ Ї® Є®®а¤Ё­ в ¬ x,y
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

// б¬ҐйҐ­ЁҐ Є авл б Їа®ўҐаЄ®© ў®§¬®¦­®бвЁ
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
     document.location.href=url+url_reload;
}


function set_qty( elem, qty ){
  document.getElementById("t"+elem).value = qty;
}

function init_training(){
    training.submit();
}

// Инициировать исследование в Академии
function do_research( atype ){
  url=window.location.href;
  if(url.indexOf('?')!=-1){
     newurl = url.split('?')
     params = newurl[1];
  }
  location.href="build.php?"+params+"&research="+atype;  
}

// Инициировать улучшение в кузнице
function do_upgrade( atype, btype ){
  url=window.location.href;
  if(url.indexOf('?')!=-1){
     newurl = url.split('?')
     params = newurl[1];
  }
  location.href="build.php?"+params+"&upgrade="+atype+"&bt="+btype;  
}

// проверка при добавлении по 500  ресурсов
function set_res_qty( elem, qty ){
  resvalue =  parseInt( document.getElementById("r"+elem).value );
  maxvalue = document.getElementById("dr"+elem).innerHTML;

  if ( (resvalue+qty) <= maxvalue ) 
     document.getElementById("r"+elem).value = resvalue+qty;
  else 
     document.getElementById("r"+elem).value = maxvalue;
}


// проверка при вводе вручную кол-ва ресурсов
function upd_res( elem ){
  resvalue =  parseInt( document.getElementById("r"+elem).value );
  if (resvalue > 500) document.getElementById("r"+elem).value = 
    document.getElementById("dr"+elem).innerHTML;
}

function init_send(){
    sending.submit();
}

function init_sell(){
    selling.submit();
}

// Окончательное распределение сырья!
function acceptPortions(){
    portions.submit();     
}

function upd_res_npc( elem ){
  resvalue =  parseInt( document.getElementById("r"+elem).value );
  totalSumm = 0;  
  if (resvalue > summ ) document.getElementById("r"+elem).value = summ;
  rest =  resvalue - eval("res"+elem);
  rest = rest <= 0 ? rest : '+'+rest;
  document.getElementById("s"+elem).innerHTML = rest;
  for(i=1;i<=4;i++) totalSumm += parseInt( document.getElementById("r"+i).value );
  document.getElementById("summ2").innerHTML = totalSumm; 
  document.getElementById("rest").innerHTML = summ -totalSumm; 
  if ( (summ - totalSumm) == 0 )
     document.getElementById("action").innerHTML = action2;
  else document.getElementById("action").innerHTML = action1;
}    


function set_a_qty( elem, qty ){
  document.getElementById("r"+elem).value = qty;
}

function init_send_army(){
    sendarmy.submit();
}

// Создаем или восстанавливаем героя
function do_resurect( atype ){
  url=window.location.href;
  if(url.indexOf('?')!=-1){
     newurl = url.split('?')
     params = newurl[1];
  }
  location.href="build.php?"+params+"&hero="+atype;  
}
