<?
// �����

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum' class='selected '>���������</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'>�������</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>�������</a>
 | <a href='build.php?bnum=$bnum&amp;p=4'>NPC-��������</a>
      </div>";


echo '<form name="sending" method="POST" action="build.php?'.$_SERVER["QUERY_STRING"].'">
      <table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>

      <td class="resinfo"><img src="img/res/wood.png"> ���������: </td>
      <td class="resinfo"><input type="text" size=5 class="text" id="r1" name="r1" value="0" maxlength="4" onKeyUp="upd_res(1)" ></td>
      <td class="resinfo"><a href="#" onClick="set_res_qty(1,500)">(500)</a></td>
      <td class="resinfo"></td>
      </tr><tr>
      <td class="resinfo"><img src="img/res/clay.png"> �����: </td>
      <td class="resinfo"><input type="text" size=5 class="text" id="r2" name="r2" value="0" maxlength="4" onKeyUp="upd_res(2)" ></td>
      <td class="resinfo"><a href="#" onClick="set_res_qty(2,500)">(500)</a></td>
      <td class="resinfo">���������� ��������:</td>
      </tr><tr>
      <td class="resinfo"><img src="img/res/ore.png"> ������: </td>
      <td class="resinfo"><input type="text" size=5 class="text" id="r3" name="r3" value="0" maxlength="4" onKeyUp="upd_res(3)" ></td>
      <td class="resinfo"><a href="#" onClick="set_res_qty(3,500)">(500)</a></td>
      <td class="resinfo">
      X:<input type="text" size=5 class="text" id="x" name="x" value="0" maxlength="4">&nbsp; 
      Y:<input type="text" size=5 class="text" id="y" name="y" value="0" maxlength="4">
      </td>
      </tr><tr>
      <td class="resinfo"><img src="img/res/grain.png"> �����: </td>
      <td class="resinfo"><input type="text" size=5 class="text" id="r4" name="r4" value="0" maxlength="4" onKeyUp="upd_res(4)" ></td>
      <td class="resinfo"><a href="#" onClick="set_res_qty(4,500)">(500)</a></td>
      <td class="resinfo"></td>
      </tr>';
     echo '</table>';
     echo '<br><img src="img/vill/ok.png" onclick="init_send()" style="cursor:hand"></br>
           <input type="hidden" name="send">
           <input type="hidden" name="hash" value="'.md5(mktime()).'" >
           </form>';
  
echo '<br>������ ��� �������� ����� ���������� �� 500 ������ �����.<br>';
echo '������ � ��� ����: <b>'.traders_ready($fid).'/'.num_traders($fid).'</b> ���������. <br><br>';

update_traders_moving( $fid );
show_traders_moving( $fid );


?>