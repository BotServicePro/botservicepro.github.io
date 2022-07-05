<?
    // Рынок

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum'>Отправить</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'>Покупка</a>
 | <a href='build.php?bnum=$bnum&amp;p=3' class='selected'>Продажа</a>
 | <a href='build.php?bnum=$bnum&amp;p=4'>NPC-торговец</a>
      </div>";


// задали торговое предложение
if( isset( $_POST["sell"] ) ){
   $res1 = $_POST["res1"];
   $res2 = $_POST["res2"];
   $qty1 = $_POST["m1"];
   $qty2 = $_POST["m2"];
   $tmchk = $_POST["d1"];
   $tm    = $_POST["d2"];
   $hash = $_POST["hash"];
   $time =  ( $tmchk <> "" ? $tm : 0 );

   create_trade_offer( $fid, $res1, $qty1, $res2, $qty2, $time, $hash );

}

if( isset( $_GET["d"] ) ){
  $del = $_GET["d"];
  $res = mysql_query("DELETE from res_offers
                               where fid = $fid and ro_hash = '$del'" )
                               or die("Query failed : " . mysql_error());
}


?>
        <br>
        <form name="selling" method="POST" action="build.php?bnum=<? echo $bnum ?>&amp;p=3">
	<table id="sell" cellpadding="1" cellspacing="1">
		<tr><td class="resinfo">Предлагаю</td>
                <td class="resinfo">
                  <input class="text" tabindex="1" size="6" name="m1" value="" maxlength="6">
                </td>
                <td class="resinfo">
                <select name="res1" tabindex="2" class="dropdown">
                  <option value="3" selected="selected">Древесина</option>
		  <option value="4">Глина</option>
		  <option value="2">Железо</option>
		  <option value="1">Зерно</option>
		</select>
		</td>
		<td class="resinfo">
		  <input class="check" type="checkbox" tabindex="5" name="d1" value="1">
  		  Макс. время трансп.: <input class="text" tabindex="6" size="1" name="d2" value="2" maxlength="2" /> ч.			
                </td>
		</tr>
		<tr><td class="resinfo">Ищу</td>
		<td class="resinfo">
  		  <input class="text" tabindex="3" size="6" name="m2" value="" maxlength="6">
		</td>
		<td class="resinfo">
		<select name="res2" tabindex="4" class="dropdown">
		  <option value="3">Древесина</option>
		  <option value="4" selected="selected">Глина</option>
  		  <option value="2">Железо</option>
   		  <option value="1">Зерно</option>				
                </select>
 	        </td>
		<td class="resinfo"></td>
		</tr>
	</table>
        <br><img src="img/vill/ok.png" onclick="init_sell()" style="cursor:hand"></br>
           <input type="hidden" name="sell">
           <input type="hidden" name="hash" value="<? echo md5(mktime()) ?>" >
        </form>

<?
    echo '<br>Каждый Ваш торговец может переносить до 500 единиц сырья.<br>';
    echo 'Сейчас у Вас есть: <b>'.traders_ready($fid).'/'.num_traders($fid).'</b> торговцев. <br><br>';

    $res = mysql_query("SELECT ro_id, ro.fid, ro_hash,  
                               rft_id_offer, ro_qty_offer, rft_id_need, ro_qty_need,
                               ro_hash, ro_max_time,
                               rft1.rft_sm_image im1,
                               rft2.rft_sm_image im2 
                               from res_offers ro
                               inner join res_fields_types rft1 on rft1.rft_id = ro.rft_id_offer
                               inner join res_fields_types rft2 on rft2.rft_id = ro.rft_id_need
                               where ro.fid = $fid" )
                               or die("Query failed : " . mysql_error());

      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){
        
          echo ' <br>
            <table width="450" style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army">
            <tr>
            <td colspan="5" class="trade_bg">Собственные предложения</td>
            </tr>
            <tr>
            <td class="tabhead"></td>
            <td class="tabhead">Предлагаю</td>
            <td class="tabhead">Ищу</td>
            <td class="tabhead">Торговцы</td>
            <td class="tabhead">Время</td>
            </tr>';

            while ($row = mysql_fetch_array( $res )) {
              $ro_id  = $row["ro_id"];    
              $hash   = $row["ro_hash"];
              $rft_id_offer = $row["rft_id_offer"];
              $qty_offer = $row["ro_qty_offer"];
              $rft_id_need = $row["rft_id_need"];
              $qty_need = $row["ro_qty_need"];
              $im1  = $row["im1"];   
              $im2  = $row["im2"];
              $time = ( $row["ro_max_time"] == 0 ? '-' : $row["ro_max_time"].' ч.' );

              $num_traders = ceil( $qty_offer/500 );

              echo '<tr><td class="armyinfo"><a href="build.php?bnum='.$bnum.'&amp;p=3&amp;d='.$hash.'"><img src="img/delete.gif" border="0" title="Удалить?"></a></td>
                    <td class="armyinfo"><img src="'.$im1.'">'.$qty_offer.'</td>
                    <td class="armyinfo"><img src="'.$im2.'">'.$qty_need.'</td>
                    <td class="armyinfo">'.$num_traders.'</td>
                    <td class="armyinfo">'.$time.'</td><tr>';       
            }
     }

  echo '</table>';


?>