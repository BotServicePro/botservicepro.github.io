<?
// Пункт сбора

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum'>Обзор</a>
 | <a href='build.php?bnum=$bnum&amp;p=2' class='selected'>Отправка войск</a>
      </div>";


echo '<form name="sendarmy" method="POST" action="build.php?bnum='.$bnum.'">';
echo '<h1>Послать войска</h1>';
     $a_cnt = 1; 
     $res = mysql_query("SELECT ar.sa_id, sr_qty, sa_name, sa_image
                                from army ar
                                inner join spr_army sa on ar.sa_id = sa.sa_id
                                where fid = $fid" )
                                or die("Query failed : " . mysql_error());

     echo '<table width="450" style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>';

     while ($row = mysql_fetch_array( $res )) {
         $qty    = $row["sr_qty"];       
         $sa_id  = $row["sa_id"];   
         $img    = $row["sa_image"];   
         $name   = $row["sa_name"];   
         echo '<td class="armyinfo">';
            echo '<img src="'.$img.'" title="'.$name.'">';
            if( $qty == 0 ){
              echo ' <input type="text" size="2" class="text disabled" id="r'.$sa_id.'" name="r'.$sa_id.'" value="0" maxlength="4">';
              echo ' <font color="#CCCCCC">('.$qty.')</font>';
            } else {
              echo ' <input type="text" size="2" class="text" id="r'.$sa_id.'" name="r'.$sa_id.'" value="0" maxlength="4">';
              echo ' <a href="#" onclick=set_a_qty('.$sa_id.','.$qty.')>('.$qty.')</a>';
            }
         echo '</td>';
         if( ++$a_cnt > 5){ $a_cnt = 1; echo '</tr><tr>'; }
     }
     
     echo '<td></td><td></td><td></td><td></td></tr></table>';
?>
<br>
<table style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army">
	<tr>
	<td class="sel">
	<label><input type="radio" class="radio" name="c" value="1" checked="checked">
  	Атака: набег</label>
	</td>
	<td class="vil"> </td>
	</tr>
	<tr>
	<td class="sel">
	<label><input type="radio" class="radio" name="c" value="2">
	Атака: обычная</label>
	</td>
	<td class="or"> </td>
	</tr>
	<tr>
	<td class="sel">
	<label><input type="radio" class="radio" name="c" value="3">
	Подкрепление</label>
	</td>
	<td class="target">
            <span>X:</span><input type="text" class="text" name="x" size="3" value="" maxlength="4">
  	    <span>Y:</span><input type="text" class="text" name="y" size="3" value="" maxlength="4">
	</td>
	</tr>
</table>

<br><img src="img/vill/ok.png" onclick="init_send_army()" style="cursor:hand"></br>
   <input type="hidden" name="send_army">
   <input type="hidden" name="hash" value="<? echo md5(mktime()) ?>" >
</form>


