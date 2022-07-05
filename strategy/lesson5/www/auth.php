<?php
session_start();

@include("config.inc.php");
//@include("functions.inc.php");
 //Необходимо подключиться к БД
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Не могу подключиться" );
// сделать $DB текущей базой данных
mysql_select_db($DB, $link) or die ('Не могу выбрать БД');

if($_SESSION['uid'] =='') { $_SESSION['uid'] = mt_rand(100000,999999); }

// данные отправлены
if( ($_POST['name'] !='') && ($_POST['password'] !='') ) {

      //Создаем запрос к базе для проверки существования Пользователя
      $name = mysql_escape_string( $_POST['name'] );
      $pass = mysql_escape_string( $_POST['password'] );

      $result = mysql_query("SELECT * FROM users WHERE nick='".$name."' and pass='".$pass."'");
      //Проверка результата запроса
      if(mysql_affected_rows()!=0) {
        $row = mysql_fetch_array( $result );
        $usr_id = $row["usr_id"];
        // запомним uid сессии
        $uniq_id = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].mktime());
        mysql_query("update users set uniq_id = '$uniq_id' WHERE nick='".$name."' and pass='".$pass."'");
        $_SESSION['name'] = $name;
        $_SESSION['usr_id'] = $usr_id;
        $_SESSION['uid'] = $uniq_id;

        // выберем 1 поселок по умолчанию  (если у игрока их больше чем 1)   
        $res = mysql_query("SELECT fid FROM fields WHERE usr_id=".$usr_id." limit 1");
        //Проверка результата запроса
        if(mysql_affected_rows()!=0) {
           $str = mysql_fetch_array( $res );
           $fid = $str["fid"];
           $_SESSION['fid'] = $fid;
        }

        header("Location: res.php");
      } else {  echo "Ошибка авторизации!";  }

 } else { echo 'Вы не заполнили логин и/или пароль <br/><a href="index.php"/>назад</a>'; }


?>