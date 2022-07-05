<?

echo '<table class="info" cellpadding="0" cellspacing="0" id="build_value"><tr>
      <td class="armyinfo">Деревня</td><td colspan="10" class="armyinfo">Собственные войска</td>
      <tr>
      <td class="armyinfo">&nbsp;</td>
      <td class="armyinfo"><img src="img/army/1.gif"></td>
      <td class="armyinfo"><img src="img/army/2.gif"></td>
      <td class="armyinfo"><img src="img/army/3.gif"></td>
      <td class="armyinfo"><img src="img/army/4.gif"></td>
      <td class="armyinfo"><img src="img/army/5.gif"></td>
      <td class="armyinfo"><img src="img/army/6.gif"></td>
      <td class="armyinfo"><img src="img/army/7.gif"></td>
      <td class="armyinfo"><img src="img/army/8.gif"></td>
      <td class="armyinfo"><img src="img/army/9.gif"></td>
      <td class="armyinfo"><img src="img/army/10.gif"></td>            
      </tr>
      <tr>
      <td class="armyinfo">Войска</td>';


     $res = mysql_query("SELECT sr_qty, sa_cons  
                                from army ar
                                inner join spr_army sa on ar.sa_id = sa.sa_id
                                where fid = $fid" )
                                or die("Query failed : " . mysql_error());

     $all_cons = 0;
     while ($row = mysql_fetch_array( $res )) {
         $qty   = $row["sr_qty"];       
         $cons  = $row["sa_cons"];   
         echo '<td class="armyinfo">'.$qty.'</td>';
         $all_cons += $cons*$qty;
     }
     echo '</tr>
     <td class="armyinfo">Содержание</td><td  class="armyinfo" colspan="10">'.$all_cons.' <img src="img/res/grain.png"> в час</td>
     </table>';                            

?>