<?
    // Кузница оружия
$url = $_SERVER["QUERY_STRING"];
$btype = 8;  /* Тип - кузница оружия */

echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
      <td width="300" class="tabhead">Кузница оружия</td>
      <td class="tabhead">Действие</td>
      </tr>';

     $res = mysql_query("SELECT sa.sa_id, sa_name, sa_image,
                                auc_grain, auc_ore, auc_wood, auc_clay, auc_time_upgrade,
                                sr_attack_upgrade
                                from spr_army sa
                                inner join army ar on ar.sa_id = sa.sa_id
                                inner join army_upgrade_cost auc on auc.sa_id = ar.sa_id and auc.auc_level = ar.sr_attack_upgrade+1
                                where sr_enable = 1 and fid=$fid" )
                                or die("Query failed : " . mysql_error());
      
     while ($row = mysql_fetch_array( $res )) {
         $atype   = $row["sa_id"];         // какой тип войска
         echo '<tr><td class="armyinfo"><img src="'.$row["sa_image"].'"><a href="#">'.$row["sa_name"].'</a>  Уровень атаки('.$row[sr_attack_upgrade].')<br>';
         echo '<img src="img/res/grain.png">'.$row["auc_grain"].' <img src="img/res/ore.png">'.$row["auc_ore"].' <img src="img/res/wood.png">'.$row["auc_wood"].' <img src="img/res/clay.png">'.$row["auc_clay"].' <img src="img/res/time.png"> '.$row["auc_time_upgrade"].'</td>';      
         echo '<td class="armyinfo">'; 
         if( !any_upgrade( $fid, $btype ) ){
           if( allow_upgrade( $fid, $atype ) ){
              echo '<a href="#" onClick="do_upgrade('.$atype.','.$btype.')">Улучшить</a>';
           } else {
              echo '<font color="#CCCCCC">Не хватает сырья</font>';
           }
         } else echo '<font color="#CCCCCC">Проводится совершенствование</font>';
         echo '</td>';
         echo '</tr>';
     }
     echo '</table>';
     echo '<br>';
     show_upgrade_progess( $fid, $btype );
?>