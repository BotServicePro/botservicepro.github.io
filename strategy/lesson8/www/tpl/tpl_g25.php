<?
// ����������

echo "<div id='textmenu'>
   <a href='build.php?bnum=$bnum' class='selected '>�������</a>
 | <a href='build.php?bnum=$bnum&amp;p=2'>��������</a>
 | <a href='build.php?bnum=$bnum&amp;p=3'>���������</a>
 | <a href='build.php?bnum=$bnum&amp;p=4'>���������</a>
      </div>";

if ($b_level < 10 ) { 
   echo '<br>��� ��������� ���������� ��������� ��� ������� ������� ��������� ���������� � ������� 10.<br>';
}

?>