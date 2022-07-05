<?
    // Академия
echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
      <td width="300" class="tabhead">Акдемия</td>
      <td class="tabhead">Действие</td>
      </tr>';

     $res = mysql_query("SELECT sa.sa_id, sa_name, sa_image,
                                arc_grain, arc_ore, arc_wood, arc_clay, arc_research_time
                                from spr_army sa
                                inner join army ar on ar.sa_id = sa.sa_id
                                inner join army_research_cost arc on arc.sa_id = ar.sa_id
                                where sr_enable = 0 and fid=$fid" )
                                or die("Query failed : " . mysql_error());
      
     while ($row = mysql_fetch_array( $res )) {
         $atype   = $row["sa_id"];         // какой тип войска
         echo '<tr><td class="armyinfo"><img src="'.$row["sa_image"].'"><a href="#">'.$row["sa_name"].'</a><br>';
         echo '<img src="img/res/grain.png">'.$row["arc_grain"].' <img src="img/res/ore.png">'.$row["arc_ore"].' <img src="img/res/wood.png">'.$row["arc_wood"].' <img src="img/res/clay.png">'.$row["arc_clay"].' <img src="img/res/time.png"> '.$row["arc_research_time"].'</td>';      
         echo '<td class="armyinfo">'; 
         if( !any_research( $fid ) ){
           if( allow_research( $fid, $atype ) ){
              echo '<a href="#" onClick="do_research('.$atype.')">Исследовать</a>';
           } else {
              echo '<font color="#CCCCCC">Не хватает сырья</font>';
           }
         } else echo '<font color="#CCCCCC">Проводятся исследования</font>';
         echo '</td>';
         echo '</tr>';
     }
     echo '</table>';
     echo '<br>';
     show_research_progess( $fid );
?>