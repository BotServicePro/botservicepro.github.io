<?php
session_start();
@include("config.inc.php");
@include("functions.inc.php");

$max_fields = 15;
$rf_num = 0;        // ID ресурсного поля

if( $_GET['p_rf_id'] <> '' ){
   $rf_id = $_GET['p_rf_id'];
} else die();
 
require_once("config.auth.php");

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

<body>

<div class="resdiv">

<?php

      $fid = $_SESSION['fid'];  // деревня

      // Узнаем сколько производство для этого ресурсного поля текущего левела
      $res = mysql_query("SELECT rlc_cons, rlc_prod, rf_level from res_fields rf inner join res_levels_cost rlc 
                          on rf.rft_id=rlc.rft_id 
                          and rf.rf_level = rlc.rlc_level where fid=$fid and rf_id=$rf_id", $link )
                                 or die("Query failed : " . mysql_error());
      $row = mysql_fetch_array( $res );
      $rlc_cons = $row["rlc_cons"];
      $rlc_prod = $row["rlc_prod"];
      $rf_level = $row["rf_level"];

      // Узнаем сколько ресурсов нужно для след.левела этого ресурсного поля
      $res = mysql_query("SELECT rlc_cons, rlc_prod, rf.rf_id, rf.rf_level+1 new_level,  rlc_grain, rlc_ore, rlc_wood, rlc_clay, rlc_time_upgrade,
                          rft_image, rft_description,rft_name 
                          from res_fields rf
                          inner join res_levels_cost rlc on rf.rft_id=rlc.rft_id 
                          inner join res_fields_types rft on rft.rft_id=rf.rft_id
                          and (rf.rf_level+1) = rlc.rlc_level where fid=$fid and rf_id=$rf_id", $link )
                                 or die("Query failed : " . mysql_error());
      
      $row = mysql_fetch_array( $res );
      $new_level = $row["new_level"];
      $rlc_grain = $row["rlc_grain"];
      $rlc_ore = $row["rlc_ore"];
      $rlc_wood = $row["rlc_wood"];
      $rlc_clay = $row["rlc_clay"];
      $rlc_cons_new = $row["rlc_cons"];
      $rlc_prod_new = $row["rlc_prod"];
      $rft_name =     $row["rft_name"];
      $rft_image =    $row["rft_image"];
      $rft_description = $row["rft_description"];
      $rlc_time_upgrade = $row["rlc_time_upgrade"];
      $rf_id = $row["rf_id"];

      
      echo '<br><img src="'.$rft_image.'" align="right">';      
      echo "<span class='res_header'>".$rft_name." Уровень ".$rf_level."</span><br><br>";
      echo $rft_description."<br><br>";
      
      echo '<table cellpadding="5" cellspacing="1" id="build_value"><tr>
      <td >Производство:</td>
      <td ><b>'.$rlc_prod.'</b> в час</td>
      </tr>
      <tr>
      <td >Производство на уровне '.($rf_level+1).':</td>
      <td ><b>'.$rlc_prod_new.'</b> в час</td>
      </tr>
      </table>';

      echo "<br>Расходы на строительство до уровня $new_level:<br>";
      echo '<img src="img/res/grain.png">'.$rlc_grain.' | <img src="img/res/ore.png">'.$rlc_ore.' | <img src="img/res/wood.png">'.$rlc_wood.' | <img src="img/res/clay.png">'.$rlc_clay.' | <img src="img/res/cons.png">'.$rlc_cons_new.' | <img src="img/res/time.png"> '.$rlc_time_upgrade.'<br><br>';
      if( allow_upgrade_res_field( $rf_id ) ){
         if( !res_upgrade_in_progress( $fid ) )
             echo '<a class="build" href="res.php?p_rf_id='.$rf_id.'">Улучшить до уровня '.($rf_level+1).'</a>'; 
         else echo '<font color="#CCCCCC">Строители сейчас заняты!</font>';
      } else {
        echo '<font color="#CCCCCC">Не хватает ресурсов!</font>';
      }

?>

</div>

<?  show_res( $fid ); ?>

</body>
</html>