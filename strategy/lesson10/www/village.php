<?php
session_start();
include("config.inc.php");
include("functions.inc.php");

require_once("config.auth.php");

$fid = $_SESSION['fid'];
// проверим, есть ли незавершенные апгрейды?
check_end_upgrade( $fid );
// а что там с очередью тренировки воинов?
check_end_training( $fid );
// а не закончились ли исследования?
check_end_research( $fid );
// а не закончились ли улучшения войск?
check_end_army_upgrade( $fid );
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

<body onmousemove = "mc()">

<div class="info" id="coords" style="padding:0px 0px 0px 0px; position:absolute;left:1px;top:1px; z-index:0">
</div>

<?  
      // задали апгрейд
      if( isset( $_GET['bid'] ) ){

        // проверим принадлежит ли это строение деревне игрока?
        $bid = $_GET['bid'];
        $res = mysql_query("SELECT bid FROM buildings b
                                 inner join fields f on f.fid = b.fid
                                 WHERE f.fid=$fid and bid=$bid", $link )
                                 or die("Query failed : " . mysql_error());
         
        $num_rows = mysql_num_rows($res);
        if( $num_rows > 0 ){  // есть такое строение в деревне!

            $a_res = building_upgrade_cost( $bid );
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
            // не забываем установить  jr_type = 1 (тип: апгрейд здания)
            $query = "insert into job_upgrade(rf_id,time_s,time_e,jr_type) values($bid, ".time().",$time_e,1)";
            $result = mysql_query($query) or die("Query failed : " . mysql_error());

        } else { echo 'Ошибка апгрейда здания!'; }
         
      }



      // задали строительство нового здания
      if( isset( $_GET['bnum'] ) && isset( $_GET['bt'] )){
          $bnum = $_GET['bnum'];  // номер стройплощадки
          $bt = $_GET['bt'];      // тип здания
          if( !build_upgrade_in_progress( $fid ) ){
              build_new( $fid, $bnum, $bt ); 
          }
      }



show_res( $fid ); ?>

<div class="resdiv" style="padding:0px 0px 0px 0px; position:absolute;left:220px;top:170px; z-index:0">
<img src="img/village.jpg"> 

<?

      $res = mysql_query("SELECT b.bid, b.bnum, bt.bt_name,bt.bt_image, bt.bt_image_not_ready, bt.bt_description, bt.bt_ycoord_dif,
                                 b.b_xcoord, b.b_ycoord, b.b_level
                                 FROM buildings b
                                 inner join building_types bt on bt.bt_id = b.bt_id
                                 WHERE b.fid = $fid order by bt.bt_id ", $link )
                                 or die("Query failed : " . mysql_error());
      
      while ($row = mysql_fetch_array( $res )) {
         $b_x       = $row["b_xcoord"]-10; // небольшое смещение в Х координате
         $b_y       = $row["b_ycoord"];
         $coord_dif = $row["bt_ycoord_dif"];
         $bt_image = $row["bt_image"];
         $bt_image_not_ready = $row["bt_image_not_ready"];
         $bt_name  = $row["bt_name"];
         $b_level  = $row["b_level"];
         $bnum  = $row["bnum"];
         if ($b_level > 0 )
            echo '<div class="bilding_pos" style="position:absolute;left:'.$b_x.'px;top:'.($b_y-$coord_dif).'px; z-index:0"><img src="'.$bt_image.'" title="'.$bt_name.' уровень '.$b_level.'" onclick="go_build('.$bnum.')"></div>';
         else
            echo '<div class="bilding_pos" style="position:absolute;left:'.$b_x.'px;top:'.($b_y-$coord_dif).'px; z-index:0"><img src="'.$bt_image_not_ready.'" title="'.$bt_name.' уровень '.$b_level.'" onclick="go_build('.$bnum.')"></div>';
      }

?>


<div class="upgrades" style="padding:0px 0px 0px 0px; position:relative;left:20px;top:20px; z-index:0">
<?php
   show_res_upgrade( $fid );
?>
</div>

</div>



</body>
</html>