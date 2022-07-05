<?php
session_start();
@include("config.inc.php");

$max_fields = 15;
 
 //Необходимо подключиться к БД
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Не могу подключиться" );
// сделать $DB текущей базой данных
mysql_select_db($DB, $link) or die ('Не могу выбрать БД');

$name = $_SESSION['name'];

      // проверим уникальный id сессии сохраненный в таблице
      $result = mysql_query("SELECT u.uniq_id, f.xcoord, f.ycoord FROM users u join fields f on u.usr_id=f.usr_id WHERE nick='$name'") 
                     or die("Query failed : " . mysql_error());
      //Проверка результата запроса
      if(mysql_affected_rows()!=0) {
         $row = mysql_fetch_array( $result );
         $sess_id = $row["uniq_id"];
         $x = $row["xcoord"];
         $y = $row["ycoord"];

         // Отцентрируем карту
         if($x<4) $x=4;
         if($x>($max_fields-3) ) $x = $max_fields-3;
         if($y<4) $y=4;
         if($y>($max_fields-3) ) $y = $max_fields-3;
         // --

         if( $_SESSION['uid'] !== $sess_id ) die ( "Ошибка авторизации!" );
         
      } else { die( "Авторизируйтесь в игре!" ) ; }


?>

<html>
<head>
 <link href="start.css" rel="stylesheet" type="text/css">
 <script src="main.js" type="text/javascript"></script>


<div id="fld_div" style="position:absolute;left:0px;top:0px; z-index:12;z-index:12"></div>

<div id="info_div" style="position:absolute;left:700px;top:100px; z-index:12;z-index:12">
   <table class="info">
   <tr><td colspan="2" class="cellinfo">Данные</td></tr>
   <tr><td class="cellinfo">Игрок:</td><td class="cellinfo"><div id="player"></div><td></tr>
   <tr><td class="cellinfo">Население:</td><td class="cellinfo"><div id="qty"></div></td></tr>
   </table>
</div>

</head>

<body onload="draw_field( <?php echo $x.','.$y; ?> );">


</body>
</html>