<?php 
session_start();
session_destroy(); 
?>

<html>
<head>
    <title>������� ���� NewBk</title>
    <meta http-equiv="content-type" content="text/html; charset=windows-1251">
    <link href="main.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="header" class="header"></div>
<div class=""style="{background-color:#BCD09B}">

    <img class="bild1" src="img/bld22.gif" >
    <h1>&nbsp;��������� Travgame!</h1>
    <p class="desc">Travgame-�������� ���� Blitz-School. ������ � ����� ��������� ��������
    �� ��������� ��������� �������������� ���� � ����� Travian!<div class="joinbutton"><a href="regank.php" title="�����! ����� ����!">������ ��������� ������!</a></div>
    <form id="loginForm" name="loginForm" action="auth.php" method="post"> 
        <div id="formz">
            <table cellpadding="0" cellspacing="0" id="logindata" width="392">
                <tr>
                    <td width="148"><label for="login" class="labellogin">��� ������<br></label>
                        <input id="login" name="name" type="text" class="login" /></td>
                    <td width="152"><label for="pwd" class="labelpwd">������<br></label>
                        <input id="pwd"  name="password" type="password" class="pass" /></td>
                    <td width="145">
                         <input type="submit" class="button" value="����" name="loginMode">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>


  
</body>
</html>