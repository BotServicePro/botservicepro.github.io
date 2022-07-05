<?php
session_start();
@include("config.inc.php");


$f_grain = 0;
$f_ore   = 0;
$f_wood  = 0;
$f_clay  = 0;
$f_cons  = 0;

$max_fields = 15;

require_once("config.auth.php");
 
// Координаты карты
      $result = mysql_query("SELECT f.xcoord, f.ycoord FROM users u join fields f on u.usr_id=f.usr_id WHERE nick='$name'") 
                     or die("Query failed : " . mysql_error());
      //Проверка результата запроса
      if(mysql_affected_rows()!=0) {
         $row = mysql_fetch_array( $result );
         $x = $row["xcoord"];
         $y = $row["ycoord"];

         // Отцентрируем карту
         if($x<4) $x=4;
         if($x>($max_fields-3) ) $x = $max_fields-3;
         if($y<4) $y=4;
         if($y>($max_fields-3) ) $y = $max_fields-3;
         // --

      } else  die( "Ошибка!" ) ; 


?>

<html>
<head>
 <link href="start.css" rel="stylesheet" type="text/css">
 <script src="main.js" type="text/javascript"></script>

<div id="header">
  <div id="inheader">
    <a href="res.php" id="m1"><img src="img/menu_item1.jpg" class="menu_img" title="Обзор деревни" /></a>
    <a href="village.php" id="m2"><img src="img/menu_item2.jpg" class="menu_img" title="Центр деревни" /></a>
    <a href="map.php" id="m3"><img src="img/menu_item3.jpg" class="menu_img" title="Карта" /></a>
    <a href="game.php" id="m4"><img src="img/menu_item4.jpg" class="menu_img" title="Статистика" /></a>
    <a href="game.php" id="m5"><img src="img/menu_item5.jpg" class="menu_img" title="Отчеты" /></a>
  </div>

</div>


</head>

<body onload="draw_field( <?php echo $x.','.$y; ?> );">


<div class="flddiv" id="fld_div"></div>

<div id="info_div" style="position:absolute;left:700px;top:100px; z-index:12;z-index:12">
   <table class="info">
   <tr><td colspan="2" class="cellinfo">Данные</td></tr>
   <tr><td class="cellinfo">Игрок:</td><td class="cellinfo"><div id="player"></div><td></tr>
   <tr><td class="cellinfo">Население:</td><td class="cellinfo"><div id="qty"></div></td></tr>
   </table>
</div>


</body>
</html>