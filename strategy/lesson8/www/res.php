<?php
session_start();
include("config.inc.php");
include("functions.inc.php");

$max_fields = 15;
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

<?php

      $fid = $_SESSION['fid'];
      // проверим, есть ли незавершенные апгрейды?
      check_end_upgrade( $fid );

      // задали апгрейд
      if( isset( $_GET['p_rf_id'] ) ){
       if( !res_upgrade_in_progress( $fid ) ){
        // проверим принадлежит ли этот ресурс деревне игрока?
        $p_rf_id = $_GET['p_rf_id'];
        $res = mysql_query("SELECT rf_id FROM res_fields rf
                                 inner join fields f on f.fid = rf.fid
                                 WHERE f.fid=$fid and rf_id=$p_rf_id", $link )
                                 or die("Query failed : " . mysql_error());
         
        $num_rows = mysql_num_rows($res);
        if( $num_rows > 0 ){  // есть такое ресурсное поле в деревне

            $a_res = res_field_upgrade_cost( $p_rf_id );
            $a_grain    = $a_res['grain'];
            $a_ore      = $a_res['ore'];
            $a_wood     = $a_res['wood'];
            $a_clay     = $a_res['clay'];
            $a_time_up  = $a_res['time_upgrade'];

            // Изменим кол-во ресурсов в связи с апгрейдом
            $query = "update fields set f_grain=f_grain-$a_grain,
                                        f_ore=f_ore-$a_ore, 
                                        f_wood=f_wood-$a_wood,
                                        f_clay=f_clay-$a_clay where fid=$fid";
            $result = mysql_query($query) or die("Query failed : " . mysql_error());

            // запишем в очередь апгрейдов 
            $time_e = time()+h2s( $a_time_up );
            // не забываем установить  jr_type = 0 (тип: апгрейд рес. поля)
            $query = "insert into job_upgrade(rf_id,time_s,time_e,jr_type) values($p_rf_id, ".time().",$time_e,0)";
            $result = mysql_query($query) or die("Query failed : " . mysql_error());

        } else { echo 'Ошибка апгрейда поля!'; }
       }   
      }

      show_res( $fid );

      $res = mysql_query("SELECT rf_id, rf_xcoord, rf_ycoord, rf_level, rft_name FROM res_fields rf
                                 inner join fields f on f.fid = rf.fid
                                 inner join res_fields_types rft on rft.rft_id = rf.rft_id
                                 WHERE f.fid = $fid", $link )
                                 or die("Query failed : " . mysql_error());
      
      while ($row = mysql_fetch_array( $res )) {
         $rf_x     = $row["rf_xcoord"];
         $rf_y     = $row["rf_ycoord"];
         $rf_level = $row["rf_level"];
         $rf_id   = $row["rf_id"];
         $rft_name = $row["rft_name"];
         echo '<div style="position:absolute;left:'.$rf_x.'px;top:'.$rf_y.'px;z-index:1" title="'.$rft_name.' Уровень '.$rf_level.'" onclick="res_details('.$rf_id.')" style="cursor:hand">'.$rf_level.'</div>';

      }  
      echo '<div style="position:absolute;left:525px;top:200px;z-index:1">';
         echo '<table class="info"><tr><td class="resinfo"><b>Производство:</b></td></tr>';
         echo '<tr><td class="resinfo"><img src="img/res/grain.png"> Зерно: </td><td class="resinfo"><b>'.(get_prod( $fid, 1 )-get_res_cons( $fid )).'</b> в час</td></tr>';
         echo '<tr><td class="resinfo"><img src="img/res/ore.png"> Руда: </td><td class="resinfo"><b>'.get_prod( $fid, 2 ).'</b> в час</td></tr>';
         echo '<tr><td class="resinfo"><img src="img/res/wood.png"> Дерево: </td><td class="resinfo"><b>'.get_prod( $fid, 3 ).'</b> в час</td></tr>';
         echo '<tr><td class="resinfo"><img src="img/res/clay.png"> Глина: </td><td class="resinfo"><b>'.get_prod( $fid, 4 ).'</b> в час</td></tr>';
      echo '</table></div>';


?>


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

  return {"x":x, "y":y};
}

function mc(e){
var mCur = mousePageXY(e); 
window.status = "X:"+mCur.x+" - Y:"+mCur.y;
}

</script>


</head>

<body onmousemove = "mc()">

<div class="resdiv" style="padding:0px 0px 0px 0px; position:absolute;left:220px;top:170px; z-index:0">
<img src="img/res_map.png"> 

<div class="upgrades" style="padding:0px 0px 0px 0px; position:relative;left:20px;top:20px; z-index:0">
<?php
   show_res_upgrade( $fid );
?>
</div>

</div>



</body>
</html>