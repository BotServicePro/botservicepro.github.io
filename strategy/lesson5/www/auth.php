<?php
session_start();

@include("config.inc.php");
//@include("functions.inc.php");
 //���������� ������������ � ��
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("�� ���� ������������" );
// ������� $DB ������� ����� ������
mysql_select_db($DB, $link) or die ('�� ���� ������� ��');

if($_SESSION['uid'] =='') { $_SESSION['uid'] = mt_rand(100000,999999); }

// ������ ����������
if( ($_POST['name'] !='') && ($_POST['password'] !='') ) {

      //������� ������ � ���� ��� �������� ������������� ������������
      $name = mysql_escape_string( $_POST['name'] );
      $pass = mysql_escape_string( $_POST['password'] );

      $result = mysql_query("SELECT * FROM users WHERE nick='".$name."' and pass='".$pass."'");
      //�������� ���������� �������
      if(mysql_affected_rows()!=0) {
        $row = mysql_fetch_array( $result );
        $usr_id = $row["usr_id"];
        // �������� uid ������
        $uniq_id = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].mktime());
        mysql_query("update users set uniq_id = '$uniq_id' WHERE nick='".$name."' and pass='".$pass."'");
        $_SESSION['name'] = $name;
        $_SESSION['usr_id'] = $usr_id;
        $_SESSION['uid'] = $uniq_id;

        // ������� 1 ������� �� ���������  (���� � ������ �� ������ ��� 1)   
        $res = mysql_query("SELECT fid FROM fields WHERE usr_id=".$usr_id." limit 1");
        //�������� ���������� �������
        if(mysql_affected_rows()!=0) {
           $str = mysql_fetch_array( $res );
           $fid = $str["fid"];
           $_SESSION['fid'] = $fid;
        }

        header("Location: res.php");
      } else {  echo "������ �����������!";  }

 } else { echo '�� �� ��������� ����� �/��� ������ <br/><a href="index.php"/>�����</a>'; }


?>