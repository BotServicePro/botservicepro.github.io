<?php
  $retStatus = 0;

  $mysql_host = 'localhost';
  $mysql_user = 'root';
  $mysql_password = '';
  $my_database = 'mmclub';

  if ( !empty($_GET['NickName'] ) )
  {
    $aNickName = $_GET['NickName'];

    $link = mysql_connect($mysql_host, $mysql_user, $mysql_password)
            or die("Could not connect : " . mysql_error());
            mysql_select_db($my_database) or die("Could not select database");

    $query = "SELECT USER_ID, Town FROM users where Nick_Name='$aNickName'";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    $aRow = mysql_fetch_array( $result);
    $aUSER_ID  = $aRow["USER_ID"];
    $aTown  = $aRow["Town"];
    
    $curdate=date("Ymd H:i");

    // поищем в билетах у игрока в рюкзаке и узнаем время отправления
    $query = "SELECT i.Item_DateTime, i.Item_TID, t.Town FROM items i inner join tickets t on i.Item_TID = t.TK_ID where i.Item_Owner='$aUSER_ID' and date_format(i.Item_DateTime,'%Y%m%d %H:%i') = '$curdate'";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
    while ($aRow = mysql_fetch_array($result)) {
        $aItemTID  = $aRow["Item_TID"];
        $retStatus = $aItemTID;
    }
    echo $retStatus;
 }
?>

