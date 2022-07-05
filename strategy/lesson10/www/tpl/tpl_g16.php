<?
// Пункт сбора

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum' class='selected '>Обзор</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'>Отправка войск</a>
      </div><br>";

// задали отправку войск
if( isset( $_POST["send_army"] ) ){
   $qty1  = $_POST["r1"];
   $qty2  = $_POST["r2"];
   $qty3  = $_POST["r3"];
   $qty4  = $_POST["r4"];
   $qty5  = $_POST["r5"];
   $qty6  = $_POST["r6"];
   $qty7  = $_POST["r7"];
   $qty8  = $_POST["r8"];
   $qty9  = $_POST["r9"];
   $qty10 = $_POST["r10"];
   $qty11 = $_POST["r11"];
   $type  = $_POST["c"];
   $p_x = ( $_POST["x"] == '' ? 0 : $_POST["x"] );
   $p_y = ( $_POST["y"] == '' ? 0 : $_POST["y"] );
   $hash = $_POST["hash"];

   init_send_army( $fid,$qty1,$qty2,$qty3,$qty4,$qty5,$qty6,$qty7,$qty8,$qty9,$qty10,$qty11,$type,$p_x,$p_y,$hash );
}

/// что с движущимися армиями?
update_army_moving( $fid );

show_enemy_army_moving( $fid );

echo '<br>';
echo '<table class="info" cellpadding="0" cellspacing="0" id="build_value"><tr>
      <td class="tabhead">Деревня</td><td colspan="11" class="tabhead">Собственные войска</td>
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
      <td class="armyinfo"><img src="img/army/11.gif"></td>            
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
     <td class="tabhead">Содержание</td><td  class="tabhead" colspan="11">'.$all_cons.' <img src="img/res/grain.png"> в час</td>
     </table>';                            

?>