<?
    // Казарма
echo '<form name="training" method="POST" action="build.php?'.$_SERVER["QUERY_STRING"].'">
      <table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
      <td width="250" class="tabhead">Название</td>
      <td class="tabhead">Количество</td>
      <td class="tabhead">Макс</td>
      </tr>';

     $res = mysql_query("SELECT sa.sa_id, sa_name, sa_image, sa_grain, sa_ore, sa_wood, sa_clay, sa_cons, sa_training_time, sr_qty  
                                from spr_army sa
                                inner join army ar on ar.sa_id = sa.sa_id
                                where bt_id = 5 and fid=$fid" )
                                or die("Query failed : " . mysql_error());

      
     while ($row = mysql_fetch_array( $res )) {
         $btype   = $row["bt_id"];         // какой тип здания?
         $sa_id   = $row["sa_id"];         // какой тип войска
         $max_army = max_army_type( $fid, $row["sa_id"]);
         echo '<tr><td class="armyinfo"><img src="'.$row["sa_image"].'"><a href="#">'.$row["sa_name"].'</a> (Имеется: '.$row["sr_qty"].') <br>';
         echo '<img src="img/res/grain.png">'.$row["sa_grain"].' <img src="img/res/ore.png">'.$row["sa_ore"].' <img src="img/res/wood.png">'.$row["sa_wood"].' <img src="img/res/clay.png">'.$row["sa_clay"].' <img src="img/res/cons.png">'.$row["sa_cons"].' <img src="img/res/time.png"> '.$row["sa_training_time"].'</td>';      
         echo '<td class="armyinfo"> <input type="text" size=5 class="text" name="t'.$sa_id.'" value="0" maxlength="4"> </td>';
         echo '<td class="armyinfo"> <a href="#" onClick="set_qty('.$sa_id.','.$max_army.')">('.$max_army.')</a></td>';
         echo '</tr>';
     }
     echo '</table>';
     echo '<br><img src="img/army/train.png" onclick="init_training()" style="cursor:hand"></br>
           <input type="hidden" name="train">
           </form>';

     show_training_progess( $fid );

?>