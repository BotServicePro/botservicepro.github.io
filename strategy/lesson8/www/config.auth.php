<?
 //���������� ������������ � ��
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("�� ���� ������������" );
// ������� $DB ������� ����� ������
mysql_select_db($DB, $link) or die ('�� ���� ������� ��');

$name = $_SESSION['name'];

      // �������� ���������� id ������ ����������� � �������
      $result = mysql_query("SELECT u.uniq_id, f.xcoord, f.ycoord FROM users u join fields f on u.usr_id=f.usr_id WHERE nick='$name'",$link) 
                     or die("Query failed : " . mysql_error());
      //�������� ���������� �������
      if(mysql_affected_rows()==0) {
         die( "<a href='http://travgame/'>���������������</a> � ����!" ) ; 
      } else {
        $row = mysql_fetch_array( $result );
        $sess_id = $row["uniq_id"];
        if( $_SESSION['uid'] !== $sess_id ) die ( "������ <a href='http://travgame/'>�����������!</a>" );
      }
?>
