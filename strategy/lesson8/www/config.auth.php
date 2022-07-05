<?
 //Необходимо подключиться к БД
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Не могу подключиться" );
// сделать $DB текущей базой данных
mysql_select_db($DB, $link) or die ('Не могу выбрать БД');

$name = $_SESSION['name'];

      // проверим уникальный id сессии сохраненный в таблице
      $result = mysql_query("SELECT u.uniq_id, f.xcoord, f.ycoord FROM users u join fields f on u.usr_id=f.usr_id WHERE nick='$name'",$link) 
                     or die("Query failed : " . mysql_error());
      //Проверка результата запроса
      if(mysql_affected_rows()==0) {
         die( "<a href='http://travgame/'>Авторизируйтесь</a> в игре!" ) ; 
      } else {
        $row = mysql_fetch_array( $result );
        $sess_id = $row["uniq_id"];
        if( $_SESSION['uid'] !== $sess_id ) die ( "Ошибка <a href='http://travgame/'>авторизации!</a>" );
      }
?>
