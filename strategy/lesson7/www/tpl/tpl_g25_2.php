<?
// Резиденция

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum'>Обучить</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'  class='selected '>Культура</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>Одобрение</a>
 | <a href='build.php?bnum=$bnum&amp;p=4'>Экспансия</a>
      </div>";

echo '<br> Для развития Вашей Империи необходимы единицы культуры. Их количество со временем увеличивается. 
           С развитием Ваших зданий увеличивается прирост единиц культуры.<br>';

echo '<br>Производится в данной деревне: <b>'.get_culture_points( $fid ).'</b> единиц культуры в сутки. <br>';

echo '<br>В общем было произведено <b>'.get_user_cp_all( $_SESSION['usr_id'] ).'</b> единиц культуры. Для основания следующего поселения или захвата деревни требуется <b>2000</b> единиц культуры.<br>';

update_culture_points( $fid );

?>