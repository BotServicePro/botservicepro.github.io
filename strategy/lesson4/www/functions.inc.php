
<?php


function checkmail($mail) {
   // ����� ����� ������� � ������� �������
   $mail=trim($mail); // ������� pregtrim() �������� ���� � �������
   // ���� ����� - �����
   if (strlen($mail)==0) return -1;
   if (!preg_match("/^[a-z0-9_-]{1,20}+(\.){0,2}+([a-z0-9_-]){0,5}@(([a-z0-9-]+\.)+(com|net|org|mil|".
   "edu|gov|arpa|info|biz|inc|name|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-".
   "9]{1,3}\.[0-9]{1,3})$/is",$mail))
   return -1;
   return $mail;
}

function sendmail($mail,$subject,$message,$headers) {

if(mail($mail,$subject,$message,$headers)) { return TRUE;}
else {return FALSE;}

}

// ���������� ������� ��� ����
function show_res( $p_fid ){
      global $f_grain;
      global $f_ore;
      global $f_wood;
      global $f_clay;
      $warehouse_capacity = 700;   // ����������� ������
      $barn_capacity = 700;        // ����������� ������
      $a_res = get_res( $p_fid );
      
      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      echo '<div style="position:absolute left:200px; top:50px">'.'<img src="img/res/grain.png">'.$f_grain.'/'.$barn_capacity.' <img src="img/res/ore.png">'.$f_ore.'/'.$warehouse_capacity.' <img src="img/res/wood.png">'.$f_wood.'/'.$warehouse_capacity.' <img src="img/res/clay.png">'.$f_clay.'/'.$warehouse_capacity.' <img src="img/res/cons.png">'.get_res_cons( $p_fid ).'/'.get_prod( $p_fid, 1 ).'</div>';
}

// ����� ��������� ���������� ������� 
function get_prod( $p_fid, $p_res_type ){
          global $link;
          $res = mysql_query("SELECT 
                              sum(rlc_prod) AS sum_prod,
                              rlc.rft_id,
                              rlc.rlc_level
                              FROM
                              res_levels_cost rlc
                              INNER JOIN res_fields rf ON (rf.rft_id = rlc.rft_id)
                              AND (rf.rf_level = rlc.rlc_level)
                              WHERE
                              fid = $p_fid and rf.rft_id = $p_res_type
                              GROUP BY
                              rlc.rft_id, rlc.rlc_level", $link )
                              or die("Query failed : " . mysql_error());         
      $row = mysql_fetch_array( $res );
      return( $row["sum_prod"] );
}

// ����� ����������� ����� ���������� ������?  (��� �������� � ������)
function get_res_cons( $p_fid ){
          global $link;
          $res = mysql_query("SELECT 
                              sum(rlc_cons) AS sum_cons,
                              rlc.rft_id,
                              rlc.rlc_level
                              FROM
                              res_levels_cost rlc
                              INNER JOIN res_fields rf ON (rf.rft_id = rlc.rft_id)
                              AND (rf.rf_level = rlc.rlc_level)
                              WHERE fid = $p_fid", $link )
                              or die("Query failed : " . mysql_error());         
      $row = mysql_fetch_array( $res );
      return( $row["sum_cons"] );
}


/////////////////////////////////////////////////////////////////////////
///////////////////  ������ �������� ��� ������� ////////////////////////
/////////////////////////////////////////////////////////////////////////
function get_res( $p_fid ){
      $result = mysql_query("SELECT f_grain, f_ore, f_wood, f_clay FROM fields where fid = $p_fid") 
                     or die("Query failed : " . mysql_error());
      $row = mysql_fetch_array( $result );
      $a_res['grain'] = $row["f_grain"];
      $a_res['ore']   = $row["f_ore"];
      $a_res['wood']  = $row["f_wood"];
      $a_res['clay']  = $row["f_clay"];
return ( $a_res );
}


///////////////////////////////////////////////////////////////////////////
//  ������� ����� ��� �������� ���������� ����
//  $rf_id  - ������������� ���������� ����
///////////////////////////////////////////////////////////////////////////
function res_field_upgrade_cost( $rf_id ){
      global $link;
      $fid = $_SESSION['fid'];
      $retv = false;
      // ������ ������� �������� ����� ��� ����.������ ����� ���������� ����
      $query = "SELECT rlc_grain, 
                       rlc_ore, 
                       rlc_wood, 
                       rlc_clay,
                       rlc_time_upgrade
                       from res_fields rf
                       inner join res_levels_cost rlc on rf.rft_id=rlc.rft_id 
                       and (rf.rf_level+1) = rlc.rlc_level 
                       where fid=$fid and rf_id=$rf_id";
      $res = mysql_query( $query, $link ) or die("Query failed : " .mysql_error());
      // ��� - ������� ����� ����� � �������, ���� ������� �������                                 
      $row = mysql_fetch_array( $res );
      
      $a_res['grain'] = $row["rlc_grain"];
      $a_res['ore']   = $row["rlc_ore"];
      $a_res['wood']  = $row["rlc_wood"];
      $a_res['clay']  = $row["rlc_clay"];
      $a_res['time_upgrade']  = $row["rlc_time_upgrade"];

return ( $a_res );
}


///////////////////////////////////////////////////////////////////////////
// �������, ���������, ������� �� �������� ��� �������� ���������� ����?
//  $rf_id  - ������������� ���������� ����
///////////////////////////////////////////////////////////////////////////
function allow_upgrade_res_field( $rf_id ){
      global $link;
      $fid = $_SESSION['fid'];
      $retv = false;
      // ������ ������� �������� ����� ��� ����.������ ����� ���������� ����
      $query = "SELECT rlc_grain, 
                       rlc_ore, 
                       rlc_wood, 
                       rlc_clay
                       from res_fields rf
                       inner join res_levels_cost rlc on rf.rft_id=rlc.rft_id 
                       and (rf.rf_level+1) = rlc.rlc_level 
                       where fid=$fid and rf_id=$rf_id";
      $res = mysql_query( $query, $link ) or die("Query failed : " .mysql_error());
      
      // ��� - ������� ����� �����, ���� ������� �������                                 
      $row = mysql_fetch_array( $res );
      
      
      $rlc_grain = $row["rlc_grain"];
      $rlc_ore = $row["rlc_ore"];
      $rlc_wood = $row["rlc_wood"];
      $rlc_clay = $row["rlc_clay"];
            
      // � ��� - ������� � ��� ���� � �������
      $a_res = get_res( $fid );

      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      if ( ($rlc_grain <= $f_grain) &&
           ($rlc_ore <= $f_ore)  &&
           ($rlc_wood <= $f_wood) && 
           ($rlc_clay <= $f_clay)  ) {

           $retv = true;     // ���� ����� �������� ���������� ��� ��������

      } else {
           $retv = false;    // �� ������� ������ ��� ����� ����� ��������....
      }
                  
   return ( $retv );

}


/////////////////////////////////////////////////////////////////////////
////////////////  ������� ������ �� �������� ���.����? //////////////////
////////////////  ������� $retv = true - ������        //////////////////
/////////////////////////////////////////////////////////////////////////
function res_upgrade_in_progress( $p_fid ){
      $retv = false;
      $result = mysql_query("SELECT count(*) as cnt from job_res_upgrade jru
                             inner join res_fields rf on rf.rf_id=jru.rf_id
                             where rf.fid=$p_fid" ) 
                             or die("Query failed : " . mysql_error());
      $row = mysql_fetch_array( $result );
      if ( $row["cnt"] > 0 ){
          $retv = true;
      }
return ( $retv );
}

/////////////////////////////////////////////////////////////////
//////////// ������� ������� ������� 00:00:00 � ������� /////////
/////////////////////////////////////////////////////////////////
function h2s( $timestr ){
  $hms = explode(':', $timestr);
  $sec = $hms[0] * 3600 + $hms[1] * 60 + $hms[2];
  return ( $sec );
}


/////////////////////////////////////////////////////////////////
//////////// ������� ������ � ������ ������� 00:00:00   /////////
/////////////////////////////////////////////////////////////////
function s2h( $p_secs ){
  $a_hrs = 0;
  $a_mnts = 0;
  $a_secs = 0;

  $a_hrs = floor($p_secs/3600);

  if( $a_hrs > 0 ){
     $a_mnts = floor(($p_secs-3600*$a_hrs)/60);
  } else  {
     $a_mnts = floor($p_secs/60);
  }
  $a_secs = $p_secs - ( 3600*$a_hrs + 60*$a_mnts );
  if( strlen($a_hrs.'') ==1 )   $a_hrs  = '0'.$a_hrs;
  if( strlen($a_mnts.'') ==1 )  $a_mnts = '0'.$a_mnts;
  if( strlen($a_secs.'') ==1 )  $a_secs = '0'.$a_secs;
  return( $a_hrs.':'.$a_mnts.':'.$a_secs );
}


/////////// ���������� - ��� � ������ ������ ����������� //////////
function show_res_upgrade( $p_fid ){
      $result = mysql_query("SELECT jru.time_s, jru.time_e, rft.rft_name, rf.rf_level from job_res_upgrade jru
                             inner join res_fields rf on rf.rf_id=jru.rf_id
                             inner join res_fields_types rft on rft.rft_id = rf.rft_id
                             where rf.fid=$p_fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){
      $row = mysql_fetch_array( $result );
      $time_s = $row["time_s"];
      $time_e = $row["time_e"];
      $rft_name = $row["rft_name"];
      $rf_level = $row["rf_level"];
      echo '<b>�������������:</b> <img src="img/res/time.png"><br>'.$rft_name.' ( ������� '.($rf_level+1).' )  &nbsp;&nbsp;<span id="restimer"></span> &nbsp;&nbsp;������ � '.date('H:i',$time_e);
      echo '
            <script>
              var currentTimeString = "'.s2h($time_e-time()).'";
              var aTime = currentTimeString.split(":");
              var currentHours = parseInt(aTime[0]);
              var currentMinutes = parseInt(aTime[1]);  
              var currentSeconds = parseInt(aTime[2]);
              updateClock(); setInterval("updateClock()", 1000 );
            </script>     ';
      }
}

////////// ��������, �� ���� �� ����������� ��������? ////////
function check_end_upgrade( $p_fid ){
      $result = mysql_query("SELECT jru.jr_id, rf.rf_id, jru.time_s, jru.time_e, rf.rf_level from job_res_upgrade jru
                             inner join res_fields rf on rf.rf_id=jru.rf_id
                             where rf.fid=$p_fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){
        $row = mysql_fetch_array( $result );
        $jr_id = $row["jr_id"];
        $rf_id = $row["rf_id"];
        $time_e = $row["time_e"];
        $rf_level = $row["rf_level"];
      
        $curtime = time();
        if( $time_e <= $curtime ){  // ���� ����� �������� ����������� ...
            $result = mysql_query("DELETE from job_res_upgrade where jr_id=$jr_id" ) 
                      or die("Query failed : " . mysql_error());
            $result = mysql_query("update res_fields set rf_level=rf_level+1 where rf_id=$rf_id" ) 
                      or die("Query failed : " . mysql_error());

        } 
        
      }
}


?>
