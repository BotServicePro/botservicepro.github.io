<?
    // Рынок
$ta = false;  // заключена ли сделка?

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum'>Отправить</a>
 | <a href='build.php?bnum=$bnum&amp;p=2' class='selected'>Покупка</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>Продажа</a>
 | <a href='build.php?bnum=$bnum&amp;p=4'>NPC-торговец</a>
      </div>";

// приняли предложение на рынке
if( isset( $_GET["ri"] ) ){
    $ta = init_trade_accept( $fid, $_GET["ri"] );
}


 echo ' <br>
 <table width="450" style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army">
 <tr>
 <td colspan="5" class="trade_bg">Предложения на рынке</td>
 </tr>
 <tr>
 <td class="tabhead">Предлагает</td>
 <td class="tabhead">Ищет</td>
 <td class="tabhead">Игрок</td>
 <td class="tabhead">Время</td>
 <td class="tabhead">Действие</td>
 </tr>';



     $res = mysql_query("SELECT ro_id, ro.fid, u.nick, f.xcoord, f.ycoord,
                                rft1.rft_sm_image im1,
                                rft2.rft_sm_image im2, 
                                rft_id_offer, ro_qty_offer, rft_id_need, ro_qty_need
                                from res_offers ro
                                inner join fields f on f.fid = ro.fid
                                inner join users u on u.usr_id = f.usr_id
                                inner join res_fields_types rft1 on rft1.rft_id = ro.rft_id_offer
                                inner join res_fields_types rft2 on rft2.rft_id = ro.rft_id_need
                                where ro.fid <> $fid" )
                                or die("Query failed : " . mysql_error());

     while ($row = mysql_fetch_array( $res )) {
         $ro_id  = $row["ro_id"];       
         $nick  = $row["nick"];       
         $im1  = $row["im1"];   
         $im2  = $row["im2"];
         $qty_offer = $row["ro_qty_offer"];
         $qty_need = $row["ro_qty_need"];
         $p_x = $row["xcoord"];
         $p_y = $row["ycoord"];

         $distance = distance_btw_villages( $fid, $p_x, $p_y );
         $speed = 10/3600; // торговцы идут 10 полей в час
         $sec = floor( $distance / $speed );
         $time = s2h( $sec );

         echo '<tr><td class="armyinfo"><img src="'.$im1.'">'.$qty_offer.'</td>
                  <td class="armyinfo"><img src="'.$im2.'">'.$qty_need.'</td>
                  <td class="armyinfo">'.$nick.'</td>
                  <td class="armyinfo">'.$time.'</td>
                  <td class="armyinfo">
                    <a href="build.php?bnum='.$bnum.'&amp;p=2&ri='.$ro_id.'">Принять</a>
                  </td><tr>';
     }

  echo '</table>';

?>



