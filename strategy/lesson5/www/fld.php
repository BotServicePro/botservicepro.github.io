<?php

session_start();

@include("config.inc.php");
 //Необходимо подключиться к БД
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Не могу подключиться" );
// сделать $DB текущей базой данных
mysql_select_db($DB, $link) or die ('Не могу выбрать БД');
   
  if( ( $_GET['x'] != '' ) && ( $_GET['y'] != '' ) ){
      $middle_x = $_GET['x'];
      $middle_y = $_GET['y'];

      $left_x = $middle_x - 3;
      $top_y = $middle_y - 3;

      $res = mysql_query("SELECT fid, nick, xcoord, ycoord, fid_type, f.usr_id FROM fields f
                                                           left join users u on u.usr_id = f.usr_id
                                                           WHERE xcoord>=$left_x 
                                                           and xcoord<$left_x+7 
                                                           and ycoord>=$top_y 
                                                           and ycoord<$top_y+7",$link ) ;
      
      $x_coord = 0;
      $y_coord = 0;

      $x_coord_start = 315;
      $y_coord_start = 288;
      
      $x = 1;
      $y = 1;
      
      $x_coord = $x_coord_start;
      $y_coord = $y_coord_start;

      //echo '<MAP Name="FPMap1">';

      while ($row = mysql_fetch_array( $res )) {
         $usr_id = $row["usr_id"];
         $fid = $row["fid"];
         $nick = $row["nick"];
         $fid_type = $row["fid_type"];
         $xcoord = $row["xcoord"];
         $ycoord = $row["ycoord"];

         $x1 = 0;  $y1 = 20;
         $x2 = 36; $y2 = 0;
         $x3 = 73; $y3 = 20;
         $x4 = 36; $y4 = 41;

         if ( $usr_id !=0 ){
            if ( $usr_id == $_SESSION['usr_id'] ){
               //     
               echo "<MAP Name='FPMap1$fid'>";
               echo "<AREA Shape='Polygon' coords = '$x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4' onmouseover=\"say_owner('".$nick."')\"></MAP>";
               echo '<div style="position:absolute;left:'.$x_coord.'px;top:'.$y_coord.'px;width:73px; height:41px; z-index:12;z-index:12"><IMG SRC="img/fld200.png" border="0" USEMAP="#FPMap1'.$fid.'" ISMAP"></div>';
               //echo "<script> alert([$x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4]); </script>";
               //echo "<AREA Shape='Polygon' coords = '100,50, 150,0, 200,50, 150,100' HREF='#' title='test'>";
            } else
               echo "<MAP Name='FPMap1$fid'>";
               echo "<AREA Shape='Polygon' coords = '$x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4' onmouseover=\"say_owner('".$nick."')\"></MAP>";
               echo '<div style="position:absolute;left:'.$x_coord.'px;top:'.$y_coord.'px;width:73px; height:41px; z-index:12;z-index:12"><IMG SRC="img/fld100.png" border="0" USEMAP="#FPMap1'.$fid.'" ISMAP"></div>';

         } else {
               echo "<MAP Name='FPMap1$fid'>";
               echo "<AREA Shape='Polygon' coords = '$x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4' onmouseover=\"say_owner('".$nick."')\"></MAP>";
               echo '<div style="position:absolute;left:'.$x_coord.'px;top:'.$y_coord.'px;width:73px; height:41px; z-index:12;z-index:12"><IMG SRC="img/fld'.$fid_type.'.png" border="0" USEMAP="#FPMap1'.$fid.'" ISMAP"></div>';
         }
         $x_coord += 40;
         $y_coord -= 22;         
         if ($x++ >= 7 ){ $x = 1; 
                          $y++; 
                          $y_coord_start += 22; 
                          $y_coord = $y_coord_start; 
                          $x_coord_start += 40; 
                          $x_coord = 
                          $x_coord_start;
         }        
      }

      $x_coord = 325;
      $y_coord = 280;
      
      // Отрисуем номера полей
      for($i=1; $i<=7; $i++){
          // номера по горизонтали
         echo '<div style="position:absolute;left:'.$x_coord.'px;top:'.$y_coord.'px;width:73px; height:41px; z-index:12;z-index:12">'.$left_x++.'</div>';
         $x_coord += 40;
         $y_coord -= 22;         
         
      }

      $x_coord  = 320;
      $y_coord = 319;
      
      for($i=1; $i<=7; $i++){
          // номера по вертикали
         echo '<div style="position:absolute;left:'.$x_coord.'px;top:'.$y_coord.'px;width:73px; height:41px; z-index:12;z-index:12">'.$top_y++.'</div>';
         $x_coord += 40;
         $y_coord += 22;         
      }
      
  } else echo 'error!';

  // КНОПКИ
  echo '<div style="position:absolute;left:390px;top:180px;width:73px; height:41px; z-index:12;z-index:12"><IMG SRC="img/ar_up.png" onclick="map_go_pos(0,-1)"></div>';
  echo '<div style="position:absolute;left:735px;top:385px;width:73px; height:41px; z-index:12;z-index:12"><IMG SRC="img/ar_dn.png" onclick="map_go_pos(0,1)"></div>';
  echo '<div style="position:absolute;left:740px;top:180px;width:73px; height:41px; z-index:12;z-index:12"><IMG SRC="img/ar_right.png" onclick="map_go_pos(1,0)"></div>';
  echo '<div style="position:absolute;left:385px;top:385px;width:73px; height:41px; z-index:12;z-index:12"><IMG SRC="img/ar_left.png" onclick="map_go_pos(-1,0)"></div>';


?>
