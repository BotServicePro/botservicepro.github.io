<?
// Резиденция

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum'>Обучить</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'>Культура</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>Одобрение</a>
 | <a href='build.php?bnum=$bnum&amp;p=4' class='selected'>Экспансия</a>
      </div>";

 echo '<br><table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
      <td width="450" colspan="5" class="tabhead">Деревни, основанные поселенцами или захваченные воинами этой деревни</td>
      <tr>
      <td class="armyinfo">Деревня</td>
      <td class="armyinfo">Игроки</td>
      <td class="armyinfo">Население</td>
      <td class="armyinfo">Координаты</td>
      <td class="armyinfo">Дата</td>
      </tr>
      <tr>
      <td width="450" colspan="5" class="armyinfo"><font color="#CCCCCC">Из этой деревни еще не проводились захваты/основания других деревень.</font></td>
      <tr>
      </table>';

?>