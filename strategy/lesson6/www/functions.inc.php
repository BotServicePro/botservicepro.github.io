
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
      global $fid;
      $warehouse_capacity = get_space($fid, 4);   // ����������� ������
      $barn_capacity = get_space($fid, 3);        // ����������� ������
      $a_res = get_res( $p_fid );
      
      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      echo '<div style="position:absolute left:200px; top:50px">'.'<img src="img/res/grain.png"> '.$f_grain.'/'.$barn_capacity.' <img src="img/res/ore.png"> '.$f_ore.'/'.$warehouse_capacity.' <img src="img/res/wood.png"> '.$f_wood.'/'.$warehouse_capacity.' <img src="img/res/clay.png"> '.$f_clay.'/'.$warehouse_capacity.' <img src="img/res/cons.png"> '.get_res_cons( $p_fid ).'/'.get_prod( $p_fid, 1 ).'</div>';
}

// ����� ��������� ���������� ������� 
function get_prod( $p_fid, $p_res_type ){
      global $link;
      $res = mysql_query("SELECT 
                          sum(rlc_prod) AS sum_prod
                          FROM
                          res_levels_cost rlc
                          INNER JOIN res_fields rf ON (rf.rft_id = rlc.rft_id)
                          AND (rf.rf_level = rlc.rlc_level)
                          WHERE
                          fid = $p_fid and rf.rft_id = $p_res_type
                          GROUP BY
                          rlc.rft_id", $link )
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
      $result = mysql_query("SELECT count(*) as cnt from job_upgrade jru
                             inner join res_fields rf on rf.rf_id=jru.rf_id
                             where rf.fid=$p_fid and jr_type = 0" ) 
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
      $cnt = 0;
      $result = mysql_query("SELECT jru.time_s, jru.time_e, rft.rft_name as name, rf.rf_level as level from job_upgrade jru
                             inner join res_fields rf on rf.rf_id=jru.rf_id
                             inner join res_fields_types rft on rft.rft_id = rf.rft_id
                             where jr_type=0 and rf.fid=$p_fid

                             union   

                             SELECT jru.time_s, jru.time_e, bt.bt_name as name, b.b_level as level from job_upgrade jru
                             inner join buildings b on b.bid=jru.rf_id
                             inner join building_types bt on bt.bt_id = b.bt_id
                             where jr_type=1 and b.fid=$p_fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){

      $script = "";
      while ($row = mysql_fetch_array( $result )) {
        $time_s = $row["time_s"];
        $time_e = $row["time_e"];
        $bt_name = $row["name"];
        $b_level = $row["level"];
        echo '<b>�������������:</b> <img src="img/res/time.png"><br>'.$bt_name.' ( ������� '.($b_level+1).' )  &nbsp;&nbsp;<span id="restimer'.$cnt.'"></span> &nbsp;&nbsp;������ � '.date('H:i',$time_e).'<br>';
        $rest = s2h($time_e-time());
        $hms = explode(':', $rest);        
        $script .= "atimers[$cnt] = [ $hms[0], $hms[1], $hms[2] ]; "; 
        $cnt ++;
              
      }
      echo '<script>';
      echo $script;
      echo 'updateClock(); setInterval("updateClock()", 1000 );';
      echo '</script>';
      }
}

///// ��������, �� ���� �� ����������� �������� ��������� ����� ��� ������? ////////
function check_end_upgrade( $p_fid ){
      $result = mysql_query("SELECT jru.jr_id, rf.rf_id as id, jru.time_s, jru.time_e, rf.rf_level as level, jru.jr_type from job_upgrade jru
                             inner join res_fields rf on rf.rf_id=jru.rf_id
                             where jr_type=0 and rf.fid=$p_fid

                             union   

                             SELECT jru.jr_id, b.bid as id, jru.time_s, jru.time_e, b.b_level as level, jru.jr_type from job_upgrade jru
                             inner join buildings b on b.bid=jru.rf_id
                             where jr_type=1 and b.fid=$p_fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){
        while ($row = mysql_fetch_array( $result )) {
          $jr_id = $row["jr_id"];
          $id = $row["id"];
          $time_e = $row["time_e"];
          $rf_level = $row["level"];
          $jr_type = $row["jr_type"];
      
          $curtime = time();
          if( $time_e <= $curtime ){  // ���� ����� �������� ����������� ...
              $res = mysql_query("DELETE from job_upgrade where jr_id=$jr_id" ) 
                        or die("Query failed : " . mysql_error());
              if ($jr_type == 0){
                  $res = mysql_query("update res_fields set rf_level=rf_level+1 where rf_id=$id" ) 
                         or die("Query failed : " . mysql_error());
              } else {
                  $res = mysql_query("update buildings set b_level=b_level+1 where bid=$id" ) 
                         or die("Query failed : " . mysql_error());
              }

          } 
        }  
      }
}



///////////////////////////////////////////////////////////////////////////
//  ������� ����� ��� �������� ������ � �������
//  $bid  - ������������� ������
///////////////////////////////////////////////////////////////////////////
function building_upgrade_cost( $bid ){
      global $link;
      $fid = $_SESSION['fid'];   // id �������
      $retv = false;
      // ������ ������� �������� ����� ��� ����.������ ����� ���������� ����
      $query = "SELECT blc_grain, 
                       blc_ore, 
                       blc_wood, 
                       blc_clay,
                       blc_cons,
                       blc_time_upgrade
                       from buildings b
                       inner join build_levels_cost blc on b.bt_id=blc.bt_id 
                       and (b.b_level+1) = blc.blc_level 
                       where fid=$fid and bid=$bid";
      $res = mysql_query( $query, $link ) or die("Query failed : " .mysql_error());
      // ��� - ������� ����� ����� � �������, ���� ������� �������                                 
      $row = mysql_fetch_array( $res );
      
      $a_res['grain'] = $row["blc_grain"];
      $a_res['ore']   = $row["blc_ore"];
      $a_res['wood']  = $row["blc_wood"];
      $a_res['clay']  = $row["blc_clay"];
      $a_res['cons']  = $row["blc_cons"];
      $a_res['time_upgrade']  = $row["blc_time_upgrade"];

return ( $a_res );
}

///// ������� ���������� �������� ������������� � % //////////
function get_build_speed( $p_level ){
      // ��� ������ ��� �������� ������ 
      $query = "SELECT blc_build_speed from build_levels_cost
                       where blc_level=$p_level and bt_id=2";
      $res = mysql_query( $query ) or die("Query failed : " .$query);
      $row = mysql_fetch_array( $res );
      return( $row["blc_build_speed"] );
}



///////////////////////////////////////////////////////////////////////////
// �������, ���������, ������� �� �������� ��� �������� ���������� ����?
//  $rf_id  - ������������� ���������� ����
///////////////////////////////////////////////////////////////////////////
function allow_upgrade_buildings( $bid ){
      global $link;
      $fid = $_SESSION['fid'];
      $retv = false;
      // ������ ������� �������� ����� ��� ����.������ ����� ������
      $query = "SELECT blc_grain, 
                       blc_ore, 
                       blc_wood, 
                       blc_clay
                       from buildings b
                       inner join build_levels_cost blc on b.bt_id=blc.bt_id 
                       and (b.b_level+1) = blc.blc_level 
                       where fid=$fid and bid=$bid";
      $res = mysql_query( $query, $link ) or die("Query failed : " .mysql_error());
      
      // ��� - ������� ����� �����, ���� ������� �������                                 
      $row = mysql_fetch_array( $res );
      
      
      $blc_grain = $row["blc_grain"];
      $blc_ore = $row["blc_ore"];
      $blc_wood = $row["blc_wood"];
      $blc_clay = $row["blc_clay"];
            
      // � ��� - ������� � ��� ���� � �������
      $a_res = get_res( $fid );

      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      if ( ($blc_grain <= $f_grain) &&
           ($blc_ore <= $f_ore)  &&
           ($blc_wood <= $f_wood) && 
           ($blc_clay <= $f_clay)  ) {

           $retv = true;     // ���� ����� �������� ���������� ��� ��������

      } else {
           $retv = false;    // �� ������� ������ ��� ����� ����� ��������....
      }
                  
   return ( $retv );

}


/////////////////////////////////////////////////////////////////////////
////////////////  ������� ������ �� �������� ������? //////////////////
////////////////  ������� $retv = true - ������        //////////////////
/////////////////////////////////////////////////////////////////////////
function build_upgrade_in_progress( $p_fid ){
      $retv = false;
      $result = mysql_query("SELECT count(*) as cnt from job_upgrade jru
                             inner join buildings b on b.bid=jru.rf_id
                             where b.fid=$p_fid and jr_type = 1" ) 
                             or die("Query failed : " . mysql_error());
      $row = mysql_fetch_array( $result );
      if ( $row["cnt"] > 0 ){
          $retv = true;
      }
return ( $retv );
}


//////////////////////////////////////////////////////////////////////////
///////// ������ ����� ������ ////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
function build_new( $fid, $bnum, $btype ){
      // ������ ������������� �������������
      $query = "SELECT bid
                       from buildings where bnum = $bnum and fid = $fid";
      $res = mysql_query( $query ) or die("Query failed : " .mysql_error());
      $row = mysql_fetch_array( $res );
      $bid = $row["bid"] ; 

      // ������ ������� �� ������������� ��� ������ ���� $btype 1 ������
      $query = "SELECT blc_grain, 
                       blc_ore, 
                       blc_wood, 
                       blc_clay,
                       blc_time_upgrade
                       from build_levels_cost where blc_level = 1
                       and bt_id=$btype";
      $res = mysql_query( $query ) or die("Query failed : " .mysql_error());
      //  ������� ����� �����? 
      $row = mysql_fetch_array( $res );
      
      $a_grain = $row["blc_grain"];
      $a_ore   = $row["blc_ore"];
      $a_wood  = $row["blc_wood"];
      $a_clay  = $row["blc_clay"];
      $a_time_up  = $row['blc_time_upgrade'];

      // �������� ���-�� �������� ������ � ����� �� ��������������
      $query = "update fields set f_grain=f_grain-$a_grain,
                                        f_ore=f_ore-$a_ore, 
                                        f_wood=f_wood-$a_wood,
                                        f_clay=f_clay-$a_clay where fid=$fid";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

      // ������� ���� ��� ������ � ��� ������� �� ������ �������������
      $query = "update buildings set bt_id = $btype, b_level = 0 where bnum = $bnum and fid = $fid";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

      // � ������� �� ������ �� 1 ������
      $time_e = time()+h2s( $a_time_up );
      // �� �������� ����������  jr_type = 1 (���: ������� ������)
      $query = "insert into job_upgrade(rf_id,time_s,time_e,jr_type) values($bid, ".time().",$time_e,1)";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

}


///// ������� ���������� ����������� ������ ��� ������ ��������� ������ //////////
function get_res_space( $p_level, $btype ){
      $query = "SELECT blc_space from build_levels_cost
                       where blc_level=$p_level and bt_id=$btype";
      $res = mysql_query( $query ) or die("Query failed : " .$query);
      $row = mysql_fetch_array( $res );
      return( $row["blc_space"] );
}

///// ������� ���������� ����������� ������ ��� ������ � ������� //////////
function get_space( $fid, $btype ){

$query = "SELECT blc_space from build_levels_cost blc 
          inner join buildings b on blc.bt_id=b.bt_id and b.b_level = blc.blc_level
          where b.fid=$fid and b.bt_id=$btype";
      $res = mysql_query( $query ) or die("Query failed : " .$query);
      $num_rows = mysql_num_rows( $res );
      if( $num_rows > 0 ){      
         $row = mysql_fetch_array( $res );
         $space = $row["blc_space"];
      }
      else $space = 800;
      return( $space );
}

////// ������� ������� MAX ���-�� ������, ������� ����� ���������� ///////
function max_army_type( $fid, $atype ){
      $a_res = get_res( $fid );
      $query = "SELECT sa_grain, sa_ore, sa_wood, sa_clay from spr_army where sa_id = $atype";
      $res = mysql_query( $query ) or die("Query failed : " .$query);
      $row = mysql_fetch_array( $res );
      $arr = array( floor($a_res["grain"] / $row["sa_grain"]),floor($a_res["ore"] / $row["sa_ore"]),floor($a_res["wood"] / $row["sa_wood"]),floor($a_res["clay"] / $row["sa_clay"]) );
      sort($arr,SORT_NUMERIC);
return( $arr[0]);
}


/////////  ���������� ����� ���������� ���������� �������� ////////////
function get_last_train_end_time( $fid ){
      $result = mysql_query("SELECT jt_end_time from job_training_army
                             where fid=$fid order by jt_end_time DESC limit 1" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){      
          $row = mysql_fetch_array( $result );
          $max_end_time = $row["jt_end_time"]-time();
      } else $max_end_time = 0;
return( $max_end_time );
}   


////// ������� ���������� � ������� ���������� ����� ////////////
function begin_training( $fid, $qty, $army_type ){

 if( $qty > 0 ){
 // �������� �������� ���������� ���-�� ������?
 if( $qty <= max_army_type( $fid, $army_type ) ){

      // ����������� ���������� �������
      $query = "SELECT sa_grain, sa_ore, sa_wood, sa_clay, sa_training_time from spr_army where sa_id = $army_type";
      $res = mysql_query( $query ) or die("Query failed : " .$query);
      $row = mysql_fetch_array( $res );

      $grain_all = $row["sa_grain"] * $qty;
      $ore_all   = $row["sa_ore"] * $qty; 
      $wood_all  = $row["sa_wood"] * $qty;
      $clay_all  = $row["sa_clay"] * $qty;
      $training_time = $row["sa_training_time"];

      $query = "update fields set f_grain=f_grain-$grain_all,
                                        f_ore=f_ore-$ore_all, 
                                        f_wood=f_wood-$wood_all,
                                        f_clay=f_clay-$clay_all where fid=$fid";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

      $ltet = get_last_train_end_time( $fid );
      $start_time = time() + $ltet ;
      $end_time = $start_time+h2s( $training_time )*$qty;
      // �������� � ������� ���������� ������
      $query = "insert into job_training_army(sa_id,fid,jt_start_time,jt_end_time,jt_qty) 
                                       values($army_type,$fid,$start_time,$end_time,$qty)";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());
 }
 }
}


/////////// ���������� - ��� � ������ ������ ����������� //////////
function show_training_progess( $p_fid ){
      $cnt = 0;
      $result = mysql_query("SELECT sa_name, sa_image, jt_start_time, jt_end_time, jt_qty from job_training_army jta 
                             inner join spr_army a on a.sa_id = jta.sa_id
                             where jta.fid=$p_fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){

      $script = "";
      echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
      <td width="262" class="tabhead">��������</td>
      <td class="tabhead">��������</td>
      <td class="tabhead">������ �</td>
      </tr>';

      while ($row = mysql_fetch_array( $result )) {
        $time_s = $row["jt_start_time"];
        $time_e = $row["jt_end_time"];
        $sa_name = $row["sa_name"];
        $sa_image = $row["sa_image"];
        $qty = $row["jt_qty"];
        echo '<tr><td class="armyinfo"><img src="'.$sa_image.'">'.$qty.' '.$sa_name.' </td>
                  <td class="armyinfo"><span id="restimer'.$cnt.'"></span> </td>
                  <td class="armyinfo"> '.date('H:i',$time_e).'</td></tr>';
        $rest = s2h($time_e-time());
        $hms = explode(':', $rest);        
        $script .= "atimers[$cnt] = [ $hms[0], $hms[1], $hms[2] ]; "; 
        $cnt ++;
              
      }
      echo '</table>';
      echo '<script>';
      echo $script;
      echo 'updateClock(); setInterval("updateClock()", 1000 );';
      echo '</script>';
      }
}

///////////////// �������� - ������� ������ ��� ������ //////////////
function check_end_training( $fid ){
      // ��� � ��� � ������� �������������? 
      $res = mysql_query("SELECT sa.sa_id, sa_training_time, jt_id, jt_start_time, jt_end_time, jt_qty from job_training_army jta 
                             inner join spr_army sa on sa.sa_id = jta.sa_id
                             where jta.fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $res );
      if( $num_rows > 0 ){

          $cur_time = time();

          while ($row = mysql_fetch_array( $res )) {
             $army_type = $row["sa_id"] ;
             $jt_id = $row["jt_id"];
             $qty = $row["jt_qty"];
             $time_s = $row["jt_start_time"];
             $time_e = $row["jt_end_time"];
             $training_time = $row["sa_training_time"];

             if( $time_e <= $cur_time ){  // ��� ������� ���������
                     // ������� �� ������� 
                     $result = mysql_query("delete from job_training_army 
                               where jt_id=$jt_id" ) 
                               or die("Query failed : " . mysql_error());
                     // ��������� � ������� �����
                     $result = mysql_query("update army set sr_qty = sr_qty + $qty
                               where sa_id=$army_type and fid=$fid" )
                               or die("Query failed : " . mysql_error());               

             } elseif( ($time_e > $cur_time) && ($time_s < $cur_time) ){

               if( $qty > 1 ){   // ��������� ������ ������ ����
                  $units_ready = floor( ($cur_time - $time_s) / h2s($training_time) );
                  // ��������� � ������� �����
                  $result = mysql_query("update army set sr_qty = sr_qty + $units_ready
                               where sa_id=$army_type and fid=$fid" )
                               or die("Query failed : " . mysql_error());               
                  // ������� �������
                  $new_start_time = $time_s + $units_ready*h2s( $training_time );
                  $result = mysql_query("update job_training_army 
                               set jt_start_time = $new_start_time,
                               jt_qty = jt_qty - $units_ready
                               where sa_id=$army_type and fid=$fid" )
                               or die("Query failed : " . mysql_error());                   
               }
                     
             } 

          }
      }
}

////// ���������� �� �������� ��� ������������ ���������� ���� ����� /////
function allow_research( $fid, $atype ){

      $retv = false;
      // ������ ������� �������� ����� ��� ������������ ����������� ���� �����
      $query = "SELECT arc_grain, 
                       arc_ore, 
                       arc_wood, 
                       arc_clay
                       from army_research_cost
                       where sa_id=$atype";
      $res = mysql_query( $query ) or die("Query failed: " .mysql_error());
      
      // ��� - ������� ����� �����, ���� ������� ������������
      $row = mysql_fetch_array( $res );
      
      
      $arc_grain = $row["arc_grain"];
      $arc_ore = $row["arc_ore"];
      $arc_wood = $row["arc_wood"];
      $arc_clay = $row["arc_clay"];

      // � ��� - ������� � ��� ���� � �������
      $a_res = get_res( $fid );

      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      if ( ($arc_grain <= $f_grain) &&
           ($arc_ore <= $f_ore)  &&
           ($arc_wood <= $f_wood) && 
           ($arc_clay <= $f_clay)  ) {

           $retv = true;     // ���� ����� �������� ���������� ��� ������������

      } else {
           $retv = false;    // �� ������� ������ ��� ����� ����� ��������....
      }
                  
   return ( $retv );
}


///// ���������� �� �����-�� ������������? /////////////////
function any_research( $fid ){
      $result = mysql_query("SELECT jra_id from job_research_army
                             where fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ) return true; 
      else return false;
}

////// ������� ���������� � ������� ������������ ////////////
function begin_research( $fid, $atype ){
      // ����������� ���������� �������
      $query = "SELECT arc_grain, 
                       arc_ore, 
                       arc_wood, 
                       arc_clay,
                       arc_research_time
                       from army_research_cost
                       where sa_id=$atype";
      $res = mysql_query( $query ) or die("Query failed 1: " .mysql_error());
      
      $row = mysql_fetch_array( $res );
      $arc_grain = $row["arc_grain"];
      $arc_ore = $row["arc_ore"];
      $arc_wood = $row["arc_wood"];
      $arc_clay = $row["arc_clay"];
      $arc_research_time = $row["arc_research_time"];

      $query = "update fields set f_grain=f_grain-$arc_grain,
                                        f_ore=f_ore-$arc_ore, 
                                        f_wood=f_wood-$arc_wood,
                                        f_clay=f_clay-$arc_clay where fid=$fid";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

      $start_time = time();
      $end_time = $start_time+h2s( $arc_research_time );
      // �������� � ������� ���������� ������
      $query = "insert into job_research_army(sa_id,fid,jra_start_time,jra_end_time) 
                                       values($atype,$fid,$start_time,$end_time)";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());
 }


/////////// ���������� - ��� � ������ ������ ����������� //////////
function show_research_progess( $p_fid ){
      $cnt = 0;
      $result = mysql_query("SELECT sa_name, sa_image, jra_start_time, jra_end_time from job_research_army jra 
                             inner join spr_army a on a.sa_id = jra.sa_id
                             where jra.fid=$p_fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){

      $script = "";
      echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
      <td width="291" class="tabhead">��������</td>
      <td class="tabhead">��������</td>
      <td class="tabhead">������ �</td>
      </tr>';

      $row = mysql_fetch_array( $result );
        $time_s = $row["jra_start_time"];
        $time_e = $row["jra_end_time"];
        $sa_name = $row["sa_name"];
        $sa_image = $row["sa_image"];
        echo '<tr><td class="armyinfo"><img src="'.$sa_image.'">'.$sa_name.' </td>
                  <td class="armyinfo"><span id="restimer'.$cnt.'"></span> </td>
                  <td class="armyinfo"> '.date('H:i',$time_e).'</td></tr>';
        $rest = s2h($time_e-time());
        $hms = explode(':', $rest);        
        $script .= "atimers[$cnt] = [ $hms[0], $hms[1], $hms[2] ]; "; 
        $cnt ++;
              
      }
      echo '</table>';
      echo '<script>';
      echo $script;
      echo 'updateClock(); setInterval("updateClock()", 1000 );';
      echo '</script>';
}


///////////////// �������� - ���������� �� ������������? //////////////
function check_end_research( $fid ){
      // ��� � ��� � ������� �������������? 
      $res = mysql_query("SELECT sa.sa_id, jra_id, jra_start_time, jra_end_time from job_research_army jra 
                             inner join spr_army sa on sa.sa_id = jra.sa_id
                             where jra.fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $res );
      if( $num_rows > 0 ){

          $cur_time = time();

          while ($row = mysql_fetch_array( $res )) {
             $army_type = $row["sa_id"] ;
             $jra_id = $row["jra_id"];
             $time_s = $row["jra_start_time"];
             $time_e = $row["jra_end_time"];

             if( $time_e <= $cur_time ){  // ��� ������� ���������
                     // ������� �� ������� 
                     $result = mysql_query("delete from job_research_army 
                               where jra_id=$jra_id" ) 
                               or die("Query failed : " . mysql_error());
                     // ������������� ������� �����������
                     $result = mysql_query("update army set sr_enable = 1
                               where sa_id=$army_type and fid=$fid" )
                               or die("Query failed : " . mysql_error());               
             }
          }
      }
}


// ������ ���� �����-�� ���������?
function any_upgrade( $fid, $btype ){
      $result = mysql_query("SELECT jua_id from job_upgrade_army
                             where fid=$fid and jua_type = $btype" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ) return true; 
      else return false;
}

// ������� �� �������� �� ���������
function allow_upgrade( $fid, $atype ){
      $retv = false;
      // ������ ������� �������� ����� ��� ������������ ����������� ���� �����
      $query = "SELECT auc_grain, 
                       auc_ore, 
                       auc_wood, 
                       auc_clay
                       from army_upgrade_cost
                       where sa_id=$atype";
      $res = mysql_query( $query ) or die("Query failed: " .mysql_error());
      
      // ��� - ������� ����� �����, ���� ������� �������                                 
      $row = mysql_fetch_array( $res );
      
      
      $auc_grain = $row["auc_grain"];
      $auc_ore = $row["auc_ore"];
      $auc_wood = $row["auc_wood"];
      $auc_clay = $row["auc_clay"];

      // � ��� - ������� � ��� ���� � ������� ��������
      $a_res = get_res( $fid );

      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      if ( ($auc_grain <= $f_grain) &&
           ($auc_ore <= $f_ore)  &&
           ($auc_wood <= $f_wood) && 
           ($auc_clay <= $f_clay)  ) {

           $retv = true;     // ���� ����� �������� ���������� ��� ���������

      } else {
           $retv = false;    // �� ������� ������ ��� ����� ����� ��������....
      }
                  
   return ( $retv );
}

// ��������� � ������� ��������� �����
function begin_upgrade( $fid, $atype, $btype ){
      // ����������� ���������� �������
      $query = "SELECT auc_grain, 
                       auc_ore, 
                       auc_wood, 
                       auc_clay,
                       auc_time_upgrade
                       from army_upgrade_cost
                       where sa_id=$atype";
      $res = mysql_query( $query ) or die("Query failed 1: " .mysql_error());
      
      $row = mysql_fetch_array( $res );
      $auc_grain = $row["auc_grain"];
      $auc_ore = $row["auc_ore"];
      $auc_wood = $row["auc_wood"];
      $auc_clay = $row["auc_clay"];
      $auc_time_upgrade = $row["auc_time_upgrade"];

      $query = "update fields set f_grain=f_grain-$auc_grain,
                                        f_ore=f_ore-$auc_ore, 
                                        f_wood=f_wood-$auc_wood,
                                        f_clay=f_clay-$auc_clay where fid=$fid";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

      $start_time = time();
      $end_time = $start_time+h2s( $auc_time_upgrade );
      // �������� � ������� ���������� ������
      $query = "insert into job_upgrade_army(sa_id,fid,jua_start_time,jua_end_time,jua_type) 
                                       values($atype,$fid,$start_time,$end_time,$btype)";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());
}

// ���������� ��� ��������� � ��������� �������($fid) � ���� ������ ($btype)
function show_upgrade_progess( $fid, $btype ){
      $cnt = 0;
      $result = mysql_query("SELECT sa_name, sa_image, jua_start_time, jua_end_time from job_upgrade_army jua 
                             inner join spr_army a on a.sa_id = jua.sa_id
                             where jua.fid=$fid and jua_type = $btype" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){

      $script = "";
      echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
      <td width="300" class="tabhead">���������</td>
      <td class="tabhead">��������</td>
      <td class="tabhead">���������</td>
      </tr>';

      $row = mysql_fetch_array( $result );
        $time_s = $row["jua_start_time"];
        $time_e = $row["jua_end_time"];
        $sa_name = $row["sa_name"];
        $sa_image = $row["sa_image"];
        echo '<tr><td class="armyinfo"><img src="'.$sa_image.'">'.$sa_name.' </td>
                  <td class="armyinfo"><span id="restimer'.$cnt.'"></span> </td>
                  <td class="armyinfo"> '.date('H:i',$time_e).'</td></tr>';
        $rest = s2h($time_e-time());
        $hms = explode(':', $rest);        
        $script .= "atimers[$cnt] = [ $hms[0], $hms[1], $hms[2] ]; "; 
        $cnt ++;
              
      }
      echo '</table>';
      echo '<script>';
      echo $script;
      echo 'updateClock(); setInterval("updateClock()", 1000 );';
      echo '</script>';
}


///////////////// �������� - ����������� �� ��������� � ����� �������? //////////////
function check_end_army_upgrade( $fid ){
      // ��� � ��� � ������� �������������? 
      $res = mysql_query("SELECT sa.sa_id, jua_id, jua_start_time, jua_end_time, jua_type from job_upgrade_army jua 
                             inner join spr_army sa on sa.sa_id = jua.sa_id
                             where jua.fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $res );
      if( $num_rows > 0 ){

          $cur_time = time();

          while ($row = mysql_fetch_array( $res )) {
             $army_type = $row["sa_id"] ;
             $jua_type = $row["jua_type"] ;    // ����� ��� 8 ��� 9 ?
             $jua_id = $row["jua_id"];
             $time_s = $row["jua_start_time"];
             $time_e = $row["jua_end_time"];

             if( $time_e <= $cur_time ){  // ��� ������� ���������
                     // ������� �� ������� 
                     $result = mysql_query("delete from job_upgrade_army 
                               where jua_id=$jua_id" ) 
                               or die("Query failed : " . mysql_error());
                     // ����������� ������� ��� ������
                     if( $jua_type == 8 )  {   // + 1 � �����
                         $result = mysql_query("update army set sr_attack_upgrade = sr_attack_upgrade + 1
                                   where sa_id=$army_type and fid=$fid" )
                                   or die("Query failed : " . mysql_error());               
                     } else {                 // +1 � ������
                         $result = mysql_query("update army set sr_defence_upgrade = sr_defence_upgrade + 1
                                   where sa_id=$army_type and fid=$fid" )
                                   or die("Query failed : " . mysql_error());               
                     }
             }
          }
      }
}



?>
