<?
// Резиденция

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum' class='selected '>Обучить</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'>Культура</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>Одобрение</a>
 | <a href='build.php?bnum=$bnum&amp;p=4'>Экспансия</a>
      </div>";

if ($b_level < 10 ) { 
   echo '<br>Для основания следующего поселения или захвата деревни требуется резиденция с уровнем 10.<br>';
}

?>