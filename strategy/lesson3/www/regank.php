<?php
session_start();

@include("config.inc.php");
@include("functions.inc.php");
 //Необходимо подключиться к БД
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Не могу подключиться" );
// сделать $DB текущей базой данных
mysql_select_db($DB, $link) or die ('Не могу выбрать БД');

if($_SESSION['uid'] =='') { $_SESSION['uid'] = mt_rand(100000,999999); }
?>

<html>
<head>
    <title>Регистрация в игре</title>
    <meta http-equiv="content-type" content="text/html; charset=windows-1251">
    <link href="start.css" rel="stylesheet" type="text/css">
</head>

<body>


    <div id="register" style="{background-color:#BCD09B}">
    <div id="text">

<?php  

if(( !$_POST['do'] OR $_POST['do'] =='') AND $_GET['activation'] == '' ) {

?>

        <h1>Добро пожаловать в мир Travgame</h1>
        <p class="desc">Для начала игры необходимо ввести имя, пароль и адрес e-mail и принять Основные Положения.</p>
        <form name="registerForm" action="regank.php" method="post">
            <p class="desc">
              <table cellpadding="3" cellspacing="0" id="logindata">
                 <td><label>Имя игрока</label></td>
                 <td><input type='text' name='name' class="startinput"  size='30'></td>
              </tr>
              <tr>
                 <td><label>Пароль</label></td>
                 <td><input type='pass' name='pass' class="startinput" size='30'></td>
              </tr>
              <tr>
                 <td><label>e-mail</label></td>
                 <td><input type='text' name='email' class="startinput" size='30'></td>
              </tr>
              <tr>
                 <td><img src="img/capcha.php?sid=<? echo $_SESSION['uid'] ?>"></td>
                 <td><input name="sid" class="startinput" type="text" size="30" value=""></td>
              </tr>
              <tr>
                 <td></td>
                 <td ><input type=checkbox name="agb"><label class="labellogin">Я принимаю Основные Положения игры Travgame.</label></td>
              </tr>
              <tr>
                 <td></td>
                 <td></td>
              </tr>
          </table>
          </p>
          <div id="infotext"></div>
          <input type="submit" name="do" class="button" value="Регистрация" />
          <p>
                            
        </form>

<?php

}

// данные отправлены
if($_POST['do'] !='') {
   //Начинаем проверять входящие данные
   if($_POST['sid'] == $_SESSION['uid']) {

      //Создаем запрос к базе для проверки существования Пользователя
      $name = $_POST['name'];
      mysql_query("SELECT * FROM users WHERE nick='".strtolower($name)."'");
   
      //Проверка результата запроса
      if(mysql_affected_rows()==0) {
      //Проверка ввведенных паролей

         if( $_POST['pass'] !='' ){

            //Осуществляем регистарацию
            $uniq_id = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].mktime());
            $pass = $_POST['pass'];
            $email = $_POST['email'];
            //Создаем запрос для записи данных в БД
            $query = "INSERT INTO users (nick,pass,email,regdate,uniq_id) VALUES('".strtolower($name)."','$pass','$email', Now(), '$uniq_id')";
            $r = mysql_query($query,$link) or die("Query failed : " . mysql_error());
            if($r) {

              // Для отправки e-mail в виде HTML устанавливаем необходимый mime-тип и кодировку
              $headers  = 'MIME-Version: 1.0' . "\r\n";
              $headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
              // Откуда пришло
              $headers .= 'From: Travgame <game@travgame.org>'."\r\n";
              //Здесь укажите электронный адрес, куда будут уходить сообщения
              $subject = "Подтверждение регистрaции на сайте";
              $message = 'Для активации аккаунта пройдите по следующей ссылке <a href="http://travgame/regank.php?activation='.$uniq_id.'" target="_blank">http://travgame/regank.php?activation='.$uniq_id.'</a>';
              $message .= 'или скопируйте ссылку в окно ввода адреса браузера и нажмите enter.';
              //Отправляем сообщение
              if(sendmail($email,$subject,$message,$headers) !== FALSE) {
                 echo 'Регистрация завершена, код активации отправлен Вам на электронный адрес!';
              }

            }

         } else { echo 'Регистрация невозможна: Введенные пароль пустой <br><a href="regank.php"/>назад</a>';}

      } else { echo 'Регистрация невозможна: Пользователь с таким именем уже существует<br/><a href="regank.php"/>назад</a>';}
      session_destroy();

   } else { echo 'Регистрация невозможна: код подтверждения введен не верно<br/><a href="regank.php"/>назад</a>';}

}

//Фрагмент отвечающий за активацию аккаунта
if($_GET['activation'] AND $_GET['activation']!='') {

   $uniq_id = $_GET['activation'];
   //Создаем запрос
   $r=@mysql_query("UPDATE users SET stat=1 WHERE uniq_id='".$uniq_id."' AND stat=0");
   if($r) {
      if( mysql_affected_rows() != 0) {   
          echo '<h2>Ваша учетная запись активирована.</h2><br/> Теперь вы можете <a href="index.php">войти на сайт</a> используя данные
                 указанные при регистрации';
      } else { echo 'Ошибка активации!'; }
   } else { echo 'Ошибка активации!'; }
}
//////////////////


?>

    </div>
    </div>
  
</body>
</html>