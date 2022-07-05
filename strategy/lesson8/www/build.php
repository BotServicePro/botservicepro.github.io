<?php
session_start();
include("config.inc.php");
include("functions.inc.php");

$page = "";

// передан номер здания?
if( $_GET['bnum'] <> '' ){
   $bnum = $_GET['bnum'];
} else die();

// есть подменю в здании
if( $_GET['p'] <> '' ){
   $page = "_".$_GET['p'];
}

require_once("config.auth.php");

$fid = $_SESSION['fid'];
// проверим, есть ли незавершенные апгрейды?
check_end_upgrade( $fid );

// задали тренировку войск
if( isset( $_POST["train"] ) ){
   for( $i=1; $i<10; $i++ ){
      if( isset( $_POST["t".$i])){
         begin_training( $fid, $_POST["t".$i], $i );
      }
   }
}

// задали исследование в академии
if( isset( $_GET["research"] ) ){
   if( !any_research( $fid ) ){
       begin_research( $fid, $_GET["research"] );
   }
}
// задали улучшение в кузнице 
if( ( isset( $_GET["upgrade"] )) && (isset( $_GET["bt"]) ) ){
   if( !any_upgrade( $fid, $_GET["bt"]) ) {
       begin_upgrade( $fid, $_GET["upgrade"], $_GET["bt"] );
   }
}


// задали отправку ресурсов в другой поселок
if( isset( $_POST["send"] ) ){
   $p_wood = $_POST["r1"];
   $p_clay = $_POST["r2"];
   $p_ore  = $_POST["r3"];
   $p_grain = $_POST["r4"];
   $p_x = $_POST["x"];
   $p_y = $_POST["y"];
   $hash = $_POST["hash"];
   init_send_res( $fid, $p_wood, $p_clay, $p_ore, $p_grain, $p_x, $p_y, $hash );
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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


<script>

function mousePageXY(e)
{
  var x = 0, y = 0;

  if (!e) e = window.event;

  if (e.pageX || e.pageY)
  {
    x = e.pageX;
    y = e.pageY;
  }
  else if (e.clientX || e.clientY)
  {
    x = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
    y = e.clientY + (document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
  }

  x = x - 220;
  y = y - 170;

  return {"x":x, "y":y};
}

function mc(e){
//alert("!");
var mCur = mousePageXY(e); 
coords.innerHTML = "X:"+mCur.x+" - Y:"+mCur.y;
}

</script>


</head>

<body>

<div class="resdiv">

<?
       $res = mysql_query("SELECT b.bid, bt.bt_id, b.bnum, bt.bt_name,bt.bt_image, bt.bt_image_not_ready, 
                                 bt.bt_description, bt.bt_ycoord_dif, b.b_level,bt_template
                                 FROM buildings b
                                 inner join building_types bt on bt.bt_id = b.bt_id
                                 WHERE b.fid = $fid and bnum = $bnum", $link )
                                 or die("Query failed : " . mysql_error());
      
      $num_rows = mysql_num_rows( $result );
      if( $num_rows == 0 ) die("Ошибка номера постройки!");
      
      $row = mysql_fetch_array( $res );
      $bid  = $row["bid"];
      $bt_id  = $row["bt_id"];
      $bt_name  = $row["bt_name"];
      $b_level  = $row["b_level"];
      $bt_image = $row["bt_image"];
      $bt_description  = $row["bt_description"];
      $bt_template = $row["bt_template"];

     if ($bt_id == 1){  // стройплощадка!
       echo "<br><span class='res_header'>Построить новое здание</span><br><br>";
     } elseif( $bt_id == 99 ) {  // площадка под пункт сбора

     } else {
       echo '<br><img src="'.$bt_image.'" align="right">';      
       echo "<span class='res_header'>".$bt_name." Уровень ".$b_level."</span><br><br>";
       echo $bt_description."<br><br>";
     }
                                    
      include("tpl/".$bt_template.$page.'.php');

     if (($bt_id <> 1) && ($bt_id <> 99)){  // не стройплощадка и не площадка под пункт сбора!
      // узнаем расходы на строительство
      $a_res = building_upgrade_cost( $bid );
      $a_grain    = $a_res['grain'];
      $a_ore      = $a_res['ore'];
      $a_wood     = $a_res['wood'];
      $a_clay     = $a_res['clay'];
      $a_cons     = $a_res['cons'];
      $a_time_up  = $a_res['time_upgrade'];
      
      echo "<br>Расходы на строительство до уровня ".($b_level+1).":<br>";
      echo '<img src="img/res/grain.png">'.$a_grain.' | <img src="img/res/ore.png">'.$a_ore.' | <img src="img/res/wood.png">'.$a_wood.' | <img src="img/res/clay.png">'.$a_clay.' | <img src="img/res/cons.png">'.$a_cons.' | <img src="img/res/time.png"> '.$a_time_up.'<br><br>';

      if( allow_upgrade_buildings( $bid ) ){
         if( !build_upgrade_in_progress( $fid ) )
             echo '<a class="build" href="village.php?bid='.$bid.'">Улучшить до уровня '.($b_level+1).'</a>'; 
         else echo '<font color="#CCCCCC">Строители сейчас заняты!</font>';
      } else {
        echo '<font color="#CCCCCC">Не хватает ресурсов!</font>';
      }
     }

?>

</div>

<?  show_res( $fid ); ?>

</body>
</html>