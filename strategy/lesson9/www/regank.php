<?php
session_start();

@include("config.inc.php");
@include("functions.inc.php");
 //���������� ������������ � ��
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("�� ���� ������������" );
// ������� $DB ������� ����� ������
mysql_select_db($DB, $link) or die ('�� ���� ������� ��');

if($_SESSION['uid'] =='') { $_SESSION['uid'] = mt_rand(100000,999999); }
?>

<html>
<head>
    <title>����������� � ����</title>
    <meta http-equiv="content-type" content="text/html; charset=windows-1251">
    <link href="start.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div id="header" class="header"></div>
    <div id="text" style="{background-color:#BCD09B}">
    <img class="bild1" src="img/bld21.gif" >

<?php  

if(( !$_POST['do'] OR $_POST['do'] =='') AND $_GET['activation'] == '' ) {

?>

        <h1>&nbsp;����� ���������� � ��� Travgame</h1>
        <p class="desc">��� ������ ���� ���������� ������ ���, ������ � ����� e-mail � ������� �������� ���������.</p>
        <form name="registerForm" action="#" onsubmit="changeAction('register');" method="post">
          <input type="hidden" name="function" value="createAvatar" />
            <p class="desc">
              <table cellpadding="3" cellspacing="0" id="logindata">
                 <td><label for="login" class="labellogin">��� ������</label></td>
                 <td><input type='text' name='name' class="startinput"  size='30'></td>
              </tr>
              <tr>
                 <td><label for="login" class="labellogin">������</label></td>
                 <td><input type='pass' name='pass' class="startinput" size='30'></td>
              </tr>
              <tr>
                 <td><label for="login" class="labellogin">e-mail</label></td>
                 <td><input type='text' name='email' class="startinput" size='30'></td>
              </tr>
              <tr>
                 <td><img src="img/capcha.php?sid=<? echo $_SESSION['uid'] ?>"></td>
                 <td><input name="sid" class="startinput" type="text" size="30" value=""></td>
              </tr>
              <tr>
                 <td></td>
                 <td ><input type=checkbox name="agb"><label class="labellogin">� �������� �������� ��������� ���� Travgame.</label></td>
              </tr>
              <tr>
                 <td></td>
                 <td></td>
              </tr>
          </table>
          </p>&nbsp;
          <input type="submit" name="do" class="button" value="�����������" />
          <p>
                            
        </form>

<?php

}

// ������ ����������
if($_POST['do'] !='') {
  if($_POST['agb'] !='') {
   //�������� ��������� �������� ������
   if($_POST['sid'] == $_SESSION['uid']) {

      //������� ������ � ���� ��� �������� ������������� ������������
      $name = $_POST['name'];
      mysql_query("SELECT * FROM users WHERE nick='".strtolower($name)."'");
   
      //�������� ���������� �������
      if(mysql_affected_rows()==0) {
      //�������� ���������� �������

         if( $_POST['pass'] !='' ){

            //������������ ������������
            $uniq_id = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].mktime());
            $pass = $_POST['pass'];
            $email = $_POST['email'];
            //������� ������ ��� ������ ������ � ��
            $query = "INSERT INTO users (nick,pass,email,regdate,uniq_id) VALUES('".strtolower($name)."','$pass','$email', Now(), '$uniq_id')";
            $r = mysql_query($query,$link) or die("Query failed : " . mysql_error());
            if($r) {
              // ����� ��������������� ���� ��� ������
              $new_id = mysql_insert_id();
              $result = mysql_query("SELECT fid from fields where usr_id = 0 order by RAND() LIMIT 1",$link) or die("Query failed : " . mysql_error());
              $row = mysql_fetch_array( $result );
              $fid = $row["fid"];
              mysql_query("UPDATE fields SET usr_id = $new_id where fid = $fid;",$link) or die("Query failed : " . mysql_error());

              // ��� �������� e-mail � ���� HTML ������������� ����������� mime-��� � ���������
              $headers  = 'MIME-Version: 1.0' . "\r\n";
              $headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
              // ������ ������
              $headers .= 'From: Travgame <game@travgame.org>'."\r\n";

              //����� ������� ����������� �����, ���� ����� ������� ���������
              $subject = "������������� ����������� �� �����";
              $message = '��� ��������� �������� �������� �� ��������� ������ <a href="http://travgame/regank.php?activation='.$uniq_id.'" target="_blank">http://travgame/regank.php?activation='.$uniq_id.'</a>';
              $message .= ' ��� ���������� ������ � ���� ����� ������ �������� � ������� enter.';
              //���������� ���������
              if(sendmail($email,$subject,$message,$headers) !== FALSE) {
                 echo '����������� ���������, ��� ��������� ��������� ��� �� ����������� �����!';
              }

            }

         } else { echo '����������� ����������: ��������� ������ ������ <br><a href="regank.php"/>�����</a>';}

      } else { echo '����������� ����������: ������������ � ����� ������ ��� ����������<br/><a href="regank.php"/>�����</a>';}
      session_destroy();

   } else { echo '����������� ����������: ��� ������������� ������ �� �����<br/><a href="regank.php"/>�����</a>';}

 } else { echo '�� ������ ������� �������� ��������� <br/><a href="regank.php"/>�����</a>'; }

}

//�������� ���������� �� ��������� ��������
if($_GET['activation'] AND $_GET['activation']!='') {

   $uniq_id = $_GET['activation'];
   //������� ������
   $r=@mysql_query("UPDATE users SET stat=1 WHERE uniq_id='".$uniq_id."' AND stat=0");
   if($r) {
      if( mysql_affected_rows() != 0) {   
          echo '<h2>���� ������� ������ ������������.</h2><br/> ������ �� ������ <a href="index.php">����� �� ����</a> ��������� ������
                 ��������� ��� �����������';

      } else { echo '������ ���������!'; }
   } else { echo '������ ���������!'; }
}
//////////////////


?>

    </div>
  
</body>
</html>