<?
// ����������

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum'>�������</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'  class='selected '>��������</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>���������</a>
 | <a href='build.php?bnum=$bnum&amp;p=4'>���������</a>
      </div>";

echo '<br> ��� �������� ����� ������� ���������� ������� ��������. �� ���������� �� �������� �������������. 
           � ��������� ����� ������ ������������� ������� ������ ��������.<br>';

echo '<br>������������ � ������ �������: <b>'.get_culture_points( $fid ).'</b> ������ �������� � �����. <br>';

echo '<br>� ����� ���� ����������� <b>'.get_user_cp_all( $_SESSION['usr_id'] ).'</b> ������ ��������. ��� ��������� ���������� ��������� ��� ������� ������� ��������� <b>2000</b> ������ ��������.<br>';

update_culture_points( $fid );

?>