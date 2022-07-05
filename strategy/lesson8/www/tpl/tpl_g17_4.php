<?
    // Рынок

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum'>Отправить</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'>Покупка</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>Продажа</a>
 | <a href='build.php?bnum=$bnum&amp;p=4' class='selected'>NPC-торговец</a>
      </div>";


// задали распределение ресурсов
if( isset( $_POST["port"] ) ){
   $wood = $_POST["r3"];
   $clay = $_POST["r4"];
   $ore  = $_POST["r2"];
   $grain = $_POST["r1"];

   create_portions( $fid, $wood, $clay, $ore, $grain );
}

  $a_res = get_res( $fid );

  $f_grain = $a_res["grain"] -  how_offer_res( $fid, 1 );
  $f_ore   = $a_res["ore"]   -  how_offer_res( $fid, 2 );
  $f_wood  = $a_res["wood"]  -  how_offer_res( $fid, 3 );
  $f_clay  = $a_res["clay"]  -  how_offer_res( $fid, 4 );
  $summ = $f_grain + $f_ore + $f_wood + $f_clay;

  echo "<script>";
     echo "res1 = ".$f_grain.";";
     echo "res2 = ".$f_ore.";";
     echo "res3 = ".$f_wood.";";
     echo "res4 = ".$f_clay.";";
     echo "summ = ".$summ.";";
     echo "cur_summ = 0;";
     echo "rest = ".$summ.";";
?>
   action1 = '<font color="#CCCCCC">Применить распределение</font>';
   action2 = '<a href="#" onClick="acceptPortions()">Применить распределение</a>';   
   </script>



   <br>
            <form name="portions" method="POST" action="build.php?bnum=<? echo $bnum ?>&amp;p=4">
            <table width="450" style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army">
            <tr>
            <td colspan="5" class="trade_bg">NPC-торговец</td>
            </tr>
            <tr>
            <td class="tabhead"><img src="img/res/1.gif" title="Древесина"><? echo $f_wood; ?></td>
            <td class="tabhead"><img src="img/res/2.gif" title="Глина"><? echo $f_clay; ?></td>
            <td class="tabhead"><img src="img/res/3.gif" title="Желео"><? echo $f_ore; ?></td>
            <td class="tabhead"><img src="img/res/4.gif" title="Зерно"><? echo $f_grain; ?></td>
            <td class="tabhead">Сумма : <span id="summ"><? echo $summ; ?></span></td>
            </tr>
            <tr>
            <td class="armyinfo"><input type="text" size=5 class="text" id="r3" name="r3" value="0" maxlength="4" onKeyUp="upd_res_npc(3)" ></td>
            <td class="armyinfo"><input type="text" size=5 class="text" id="r4" name="r4" value="0" maxlength="4" onKeyUp="upd_res_npc(4)" ></td>
            <td class="armyinfo"><input type="text" size=5 class="text" id="r2" name="r2" value="0" maxlength="4" onKeyUp="upd_res_npc(2)" ></td>
            <td class="armyinfo"><input type="text" size=5 class="text" id="r1" name="r1" value="0" maxlength="4" onKeyUp="upd_res_npc(1)" ></td>
            <td class="armyinfo">Сумма : <span id="summ2">0</span></td>
            </tr>
            <tr>
            <td class="armyinfo"><span id="s3"><? echo -$f_wood; ?></span></td>
            <td class="armyinfo"><span id="s4"><? echo -$f_clay; ?></span></td>
            <td class="armyinfo"><span id="s2"><? echo -$f_ore; ?></span></td>
            <td class="armyinfo"><span id="s1"><? echo -$f_grain; ?></span></td>
            <td class="armyinfo">Остаток : <span id="rest"><? echo $summ;?></span></td>
            </tr>
            </table>  

            <input type="hidden" name="port">
            </form>

            <br><span id="action"><font color="#CCCCCC">Применить распределение</font></span></br>

<br>Здесь Вы можете вручную распределить ресурсы (Распределение считатся завершенным, когда остаток станет равным нулю).<br> <br>
Первая строка отражает содержимое Вашего хранилища. Во второй строке Вы можете 
указать нужное Вам распределение. Третья строка показывает разницу между двумя 
первыми строками. <br>

