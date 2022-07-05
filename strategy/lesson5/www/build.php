<?php
session_start();
include("config.inc.php");
include("functions.inc.php");

// ������� ����� ������?
if( $_GET['bnum'] <> '' ){
   $bnum = $_GET['bnum'];
} else die();

require_once("config.auth.php");

$fid = $_SESSION['fid'];
// ��������, ���� �� ������������� ��������?
check_end_upgrade( $fid );

?>

<html>
<head>
 <link href="start.css" rel="stylesheet" type="text/css">
 <script src="main.js" type="text/javascript"></script>

<div id="header">
  <div id="inheader">
    <a href="res.php" id="m1"><img src="img/menu_item1.jpg" class="menu_img" title="����� �������" /></a>
    <a href="village.php" id="m2"><img src="img/menu_item2.jpg" class="menu_img" title="����� �������" /></a>
    <a href="map.php" id="m3"><img src="img/menu_item3.jpg" class="menu_img" title="�����" /></a>
    <a href="game.php" id="m4"><img src="img/menu_item4.jpg" class="menu_img" title="����������" /></a>
    <a href="game.php" id="m5"><img src="img/menu_item5.jpg" class="menu_img" title="������" /></a>
  </div>

</div>

</head>

<body>

<div class="resdiv">

<?
      show_res( $fid ); 

      $res = mysql_query("SELECT b.bid, bt.bt_id, b.bnum, bt.bt_name,bt.bt_image, bt.bt_image_not_ready, 
                                 bt.bt_description, bt.bt_ycoord_dif, b.b_level,bt_template
                                 FROM buildings b
                                 inner join building_types bt on bt.bt_id = b.bt_id
                                 WHERE b.fid = $fid and bnum = $bnum", $link )
                                 or die("Query failed : " . mysql_error());
      
      $num_rows = mysql_num_rows( $result );
      if( $num_rows == 0 ) die("������ ������ ���������!");
      
      $row = mysql_fetch_array( $res );
      $bid  = $row["bid"];
      $bt_id  = $row["bt_id"];
      $bt_name  = $row["bt_name"];
      $b_level  = $row["b_level"];
      $bt_image = $row["bt_image"];
      $bt_description  = $row["bt_description"];
      $bt_template = $row["bt_template"];

     if ($bt_id <> 1){  // �� �������������!
      echo '<br><img src="'.$bt_image.'" align="right">';      
      echo "<span class='res_header'>".$bt_name." ������� ".$b_level."</span><br><br>";
      echo $bt_description."<br><br>";
     } else {
      echo "<br><span class='res_header'>��������� ����� ������</span><br><br>";
     }


      @include("tpl/".$bt_template);


     if ($bt_id <> 1){  // �� �������������!
      // ������ ������� �� �������������
      $a_res = building_upgrade_cost( $bid );
      $a_grain    = $a_res['grain'];
      $a_ore      = $a_res['ore'];
      $a_wood     = $a_res['wood'];
      $a_clay     = $a_res['clay'];
      $a_cons     = $a_res['cons'];
      $a_time_up  = $a_res['time_upgrade'];
      
      echo "<br>������� �� ������������� �� ������ ".($b_level+1).":<br>";
      echo '<img src="img/res/grain.png">'.$a_grain.' | <img src="img/res/ore.png">'.$a_ore.' | <img src="img/res/wood.png">'.$a_wood.' | <img src="img/res/clay.png">'.$a_clay.' | <img src="img/res/cons.png">'.$a_cons.' | <img src="img/res/time.png"> '.$a_time_up.'<br><br>';

      if( allow_upgrade_buildings( $bid ) ){
         if( !build_upgrade_in_progress( $fid ) )
             echo '<a class="build" href="village.php?bid='.$bid.'">�������� �� ������ '.($b_level+1).'</a>'; 
         else echo '<font color="#CCCCCC">��������� ������ ������!</font>';
      } else {
        echo '<font color="#CCCCCC">�� ������� ��������!</font>';
      }
     }

?>

</div>

</body>
</html>