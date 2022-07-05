
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

      echo '<div style="position:absolute; left:230px; top:90px">   <img src="img/res/wood.png" title="������"> <span id="dr1">'.$f_wood.'</span>/'.$warehouse_capacity.
                                                                 ' <img src="img/res/clay.png" title="�����"> <span id="dr2">'.$f_clay.'</span>/'.$warehouse_capacity.
                                                                 ' <img src="img/res/ore.png" title="������"> <span id="dr3">'.$f_ore.'</span>/'.$warehouse_capacity.
                                                                 ' <img src="img/res/grain.png" title="�����"> <span id="dr4">'.$f_grain.'</span>/'.$barn_capacity.
                                                                 ' <img src="img/res/cons.png" title="�����������"> '.get_res_cons( $p_fid ).'/'.get_prod( $p_fid, 1 ).'</div>';
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

/////// ��������� ���-�� ������ �������� � ����� //////////////
function get_culture_points( $fid ){
  $culture = 0;
      $res = mysql_query("SELECT b_level from buildings where fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
          while ($row = mysql_fetch_array( $res )) {
             $culture += $row["b_level"] * 2 + $row["b_level"];
          } 
return ( $culture );
}

// ����� ���������� ���������� ������� ����
function get_user_time_up( $user_id ){
     $res = mysql_query("SELECT time_up from users where usr_id=$user_id" ) 
                         or die("Query failed : " . mysql_error());
     $row = mysql_fetch_array( $res );
     return ( $row["time_up"] );
}


// ����������� � ��������� ������� �������� //
function update_culture_points( $fid ){

  $cpsec = get_culture_points( $fid )/86400;
  $timedif = time() - get_user_time_up( $_SESSION['usr_id'] );
  $gencp = $cpsec*$timedif;
  if( $gencp > 1 ) {
      $gencp = ceil($gencp);
      $res = mysql_query("update users set culture_points = culture_points + $gencp, time_up = ".time()." where usr_id=".$_SESSION['usr_id']  ) 
                             or die("Query failed : " . mysql_error());
  }                 
}

// ������� ����� ������ �������� ��� ���������?
function get_user_cp_all( $user_id ){
     $res = mysql_query("SELECT culture_points from users where usr_id=$user_id" ) 
                         or die("Query failed : " . mysql_error());
     $row = mysql_fetch_array( $res );
     return ( $row["culture_points"] );
}

/////// ���� �� � ������� ����� ������ � ������ ������? ////////
function is_building_level_exists( $fid, $btype, $st_level ){
     $res = mysql_query("SELECT bid from buildings where fid=$fid and bt_id=$btype and b_level=$st_level" ) 
                         or die("Query failed : " . mysql_error());
     return ( mysql_num_rows( $res ) > 0 );
}

////  ��������� �� ������� ������ ������ �� ������ ��������? ///////
function allow_tree_build( $fid, $btype ){
      $res = mysql_query("SELECT st_level,bt_id_parent from spr_tree where bt_id=$btype" ) 
                             or die("Query failed : " . mysql_error());
          while ($row = mysql_fetch_array( $res )) {
             $bt_id_parent = $row["bt_id_parent"];
             $st_level = $row["st_level"];
             if( !is_building_level_exists( $fid,$bt_id_parent,$st_level ) )
                 return ( false );
          }                                  
return ( true );
}

// ������ ������� � ��� ��������� (���-�� ��������� = ������ �����)?
function num_traders( $fid ){
     $btype = 12;   // ������������� ����� �� ������� building_types
     $res = mysql_query("SELECT b_level from buildings where fid=$fid and bt_id=$btype" ) 
                         or die("Query failed : " . mysql_error());
     $row = mysql_fetch_array( $res );
     return ( $row["b_level"] );
}

// ���������� ����� ���������
function distance_btw_villages( $fid, $dest_x, $dest_y ){
  
        $res = mysql_query("SELECT xcoord, ycoord from fields where fid=$fid" ) 
                         or die("Query failed : " . mysql_error());
        $row = mysql_fetch_array( $res );
        $x_s = $row["xcoord"];
        $y_s = $row["ycoord"];

   $distance = sqrt( pow(($x_s-$dest_x),2)+pow(($y_s-$dest_y),2) );
   return( $distance );
}


// �������� �� ���, ��� �� ��� ������������ ���������? (F5 � ��������)
function is_trade_hash( $fid, $hash ){
        $res = mysql_query("SELECT jtm_id from job_traders_move where fid=$fid and jtm_hash='$hash'" ) 
                         or die("Query failed : " . mysql_error());
        return ( mysql_num_rows( $res ) > 0 );
}

// ���������� ��������� � ������� � ������� ����������
function init_send_res( $fid, $p_wood, $p_clay, $p_ore, $p_grain, $p_x, $p_y, $hash ){
    if( !is_trade_hash( $fid, $hash ) ){
      $max_traders_capacity = num_traders( $fid )*500;
      $max_res = $p_wood+$p_clay+$p_ore+$p_grain;
      $traders_needed =  ceil( $max_res/500 );
      if( $max_traders_capacity >= $max_res ){
        // �������� ������������� �������, ���� ������������ ��������!
        $res = mysql_query("SELECT fid, usr_id, fid_name from fields where xcoord=$p_x and ycoord=$p_y and usr_id<>0" ) 
                         or die("Query failed : " . mysql_error());
        if (mysql_num_rows( $res ) > 0){
        $row = mysql_fetch_array( $res );
        $fid_to = $row["fid"];

        $distance = distance_btw_villages( $fid, $p_x, $p_y );
        $speed = 10/3600; // 10 ����� � ���
        $sec = floor( $distance / $speed );

        $start_time = time();
        $end_time1 = $start_time + $sec;  
        $end_time2 = $end_time1 + $sec;  

        $res = mysql_query("insert into job_traders_move(fid,fid_to,jtm_start_time,jtm_end_time1,jtm_end_time2,jtm_direction,jtm_hash,jtm_wood,jtm_clay,jtm_ore,jtm_grain,jtm_traders_num)
                            values ($fid,$fid_to,$start_time,$end_time1,$end_time2,1,'$hash',$p_wood, $p_clay, $p_ore, $p_grain, $traders_needed)") or die("Query failed : " . mysql_error());
        // �������� ���� ������� (�.�. �������� ������� ��)
        $result = mysql_query("update fields set f_wood=f_wood-$p_wood,
                                                    f_clay=f_clay-$p_clay,
                                                       f_ore=f_ore-$p_ore,
                                                 f_grain=f_grain-$p_grain
                                                              where fid = $fid" ) 
                         or die("Query failed : " . mysql_error());
        } else echo "<br>������� � ������ ������������ �� ����������!<br>";
      } else echo "<br>�� ������� ���������!<br>";
    }
}


function show_traders_moving( $fid ){
      $cnt = 0;
      // ��� ���� ��������
      $result = mysql_query("SELECT f.fid_name,jtm_start_time,jtm_end_time1,jtm_end_time2, 
                             jtm_direction, jtm_wood,jtm_clay,jtm_ore,jtm_grain
                             from job_traders_move jtm
                             inner join fields f on f.fid = jtm.fid_to
                             where jtm.fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){

      $script = "";

      while( $row = mysql_fetch_array( $result )){
        $time_s = $row["jtm_start_time"];
        $time_e1 = $row["jtm_end_time1"];
        $time_e2 = $row["jtm_end_time2"];
        $fid_name = $row["fid_name"];
        $direction = $row["jtm_direction"];

        echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
        <td class="tabhead"></td>
        <td width="300" class="tabhead">'.($direction==1 ? "��������������� � ":"����������� �� ").$fid_name.'</td>
        <td class="tabhead">��������</td>
        </tr>';

        // ���� ��� �������?
        $time_e = ($direction==1 ? $time_e1 : $time_e2 );

        echo '<tr><td class="armyinfo">��������</td>
                  <td class="armyinfo"><span id="restimer'.$cnt.'"></span> </td>
                  <td class="armyinfo"> '.date('H:i',$time_e).'</td></tr>';
        $rest = s2h($time_e-time());
        $hms = explode(':', $rest);        
        $script .= "atimers[$cnt] = [ $hms[0], $hms[1], $hms[2] ]; "; 
        $cnt ++;
        echo '<tr><td class="armyinfo">�����</td>
                  <td class="armyinfo">
                  <img src="img/res/wood.png">'.$row["jtm_wood"].' | 
                  <img src="img/res/clay.png">'.$row["jtm_clay"].' |
                  <img src="img/res/ore.png">'.$row["jtm_ore"].' |
                  <img src="img/res/grain.png">'.$row["jtm_grain"].'
                  </td>
                  <td class="armyinfo"></td></tr>';

        echo '</table>';
      }
      }

      // ��� �� ���� ��������, �� ����� � ��� (���������� ������ � jtm_direction = 1)
      $result = mysql_query("SELECT f.fid_name,jtm_start_time,jtm_end_time1,jtm_end_time2, 
                             jtm_direction, jtm_wood,jtm_clay,jtm_ore,jtm_grain
                             from job_traders_move jtm
                             inner join fields f on f.fid = jtm.fid_to
                             where jtm.fid_to=$fid and jtm_direction = 1" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){

      while( $row = mysql_fetch_array( $result )){
        $time_s = $row["jtm_start_time"];
        $time_e1 = $row["jtm_end_time1"];
        $time_e2 = $row["jtm_end_time2"];
        $fid_name = $row["fid_name"];
        $direction = $row["jtm_direction"];

        echo '<br><table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
        <td class="tabhead"></td>
        <td width="300" class="tabhead">'.($direction==1 ? "��������������� � ":"����������� �� ").$fid_name.'</td>
        <td class="tabhead">��������</td>
        </tr>';

        // ���� ��� �������?
        $time_e = ($direction==1 ? $time_e1 : $time_e2 );

        echo '<tr><td class="armyinfo">��������</td>
                  <td class="armyinfo"><span id="restimer'.$cnt.'"></span> </td>
                  <td class="armyinfo"> '.date('H:i',$time_e).'</td></tr>';
        $rest = s2h($time_e-time());
        $hms = explode(':', $rest);        
        $script .= "atimers[$cnt] = [ $hms[0], $hms[1], $hms[2] ]; "; 
        $cnt ++;
        echo '<tr><td class="armyinfo">�����</td>
                  <td class="armyinfo">
                  <img src="img/res/wood.png">'.$row["jtm_wood"].' | 
                  <img src="img/res/clay.png">'.$row["jtm_clay"].' |
                  <img src="img/res/ore.png">'.$row["jtm_ore"].' |
                  <img src="img/res/grain.png">'.$row["jtm_grain"].'
                  </td>
                  <td class="armyinfo"></td></tr>';

        echo '</table>';

      }
      }
      echo '<script>';
      echo $script;
      echo 'updateClock(); setInterval("updateClock()", 1000 );';
      echo '</script>';

}


/////////  �������� ����������� ���������  //////////////
function update_traders_moving( $fid ){
      // ��� � ��� � ������� ����������� ���������? 
      $res = mysql_query("SELECT jtm_id, fid_to,jtm_start_time,jtm_end_time1,jtm_end_time2, 
                             jtm_direction, jtm_wood,jtm_clay,jtm_ore,jtm_grain
                             from job_traders_move jtm
                             where jtm.fid=$fid")
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $res );
      if( $num_rows > 0 ){

          $cur_time = time();

          while ($row = mysql_fetch_array( $res )) {
             $jtm_id = $row["jtm_id"];
             $fid_to = $row["fid_to"];
             $time_s = $row["jtm_start_time"];
             $time_e1 = $row["jtm_end_time1"];
             $time_e2 = $row["jtm_end_time2"];
             $direction = $row["jtm_direction"];
             $a_wood  = $row["jtm_wood"];
             $a_clay  = $row["jtm_clay"];
             $a_ore   = $row["jtm_ore"];
             $a_grain = $row["jtm_grain"];

             if( $time_e2 <= $cur_time ){  // ��� ������� � ���������!
               if( $direction == 1 ){   // ��� �� ���������� ��������
                     // ������� ����� ���� ���� ����� 
                     $result = mysql_query("update fields set f_wood=f_wood+$a_wood,
                                                              f_clay=f_clay+$a_clay,
                                                              f_ore=f_ore+$a_ore,
                                                              f_grain=f_grain+$a_grain
                                                              where fid = $fid_to" ) 
                               or die("Query failed : " . mysql_error());
                     // ������� �� ������� 
                     $result = mysql_query("delete from job_traders_move 
                               where jtm_id=$jtm_id" ) 
                               or die("Query failed : " . mysql_error());
               } else {
                     // ������� �� ������� 
                     $result = mysql_query("delete from job_traders_move 
                               where jtm_id=$jtm_id" ) 
                               or die("Query failed : " . mysql_error());
               }    
             }  else {

                if( $time_e1 <= $cur_time ){
                    // ��� �������  
                     // ������� ����� ���� ���� ����� 
                     $result = mysql_query("update fields set f_wood=f_wood+$a_wood,
                                                              f_clay=f_clay+$a_clay,
                                                              f_ore=f_ore+$a_ore,
                                                              f_grain=f_grain+$a_grain
                                                              where fid = $fid_to" ) 
                               or die("Query failed : " . mysql_error());
                     // �������� ������ ����������� - �� �������
                     $result = mysql_query("update job_traders_move 
                               set jtm_direction=2, jtm_wood=0,jtm_clay=0,jtm_ore=0,jtm_grain=0
                               where jtm_id=$jtm_id" ) 
                               or die("Query failed : " . mysql_error());   
                }
             }
          }
      }
}


///// ������� � ��� �������� ���������?
function traders_ready( $fid ){
      // ������, ���� �� � ��� �������� � ����?
      $total_traders = 0;
      $result = mysql_query("SELECT jtm_traders_num
                             from job_traders_move jtm
                             where jtm.fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
      $num_rows = mysql_num_rows( $result );
      if( $num_rows > 0 ){
        while ($row = mysql_fetch_array( $result )) {
           $total_traders += $row["jtm_traders_num"];
        }
        return( num_traders( $fid ) - $total_traders );
      } else {
        return ( num_traders( $fid ) );      
      } 
}


// ��������� �������� ������ - �������� ���-�� �����������
function init_trade_accept( $fid, $ro_id ){

    // ������� �������� ��������� �����������

    echo '<br>
       <table width="450" style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army">
       <tr>
       <td colspan="2" class="trade_bg">�����</td>
       </tr>';

       $res = mysql_query("SELECT ro_id, ro.fid, u.nick, f.xcoord, f.ycoord,
                                rft1.rft_sm_image im1,
                                rft2.rft_sm_image im2, 
                                rft_id_offer, ro_qty_offer, rft_id_need, ro_qty_need
                                from res_offers ro
                                inner join fields f on f.fid = ro.fid
                                inner join users u on u.usr_id = f.usr_id
                                inner join res_fields_types rft1 on rft1.rft_id = ro.rft_id_offer
                                inner join res_fields_types rft2 on rft2.rft_id = ro.rft_id_need
                                where ro.ro_id = $ro_id" )
                                or die("Query failed : " . mysql_error());

     $row = mysql_fetch_array( $res );
     $fid_from = $row["fid"];  // �� ���� ���������
     $nick  = $row["nick"];       
     $im1  = $row["im1"];   
     $im2  = $row["im2"];

     $rft_id_offer = $row["rft_id_offer"];
     $qty_offer = $row["ro_qty_offer"];

     $rft_id_need = $row["rft_id_need"];
     $qty_need = $row["ro_qty_need"];

     $p_x = $row["xcoord"];
     $p_y = $row["ycoord"];

     echo '<tr>
           <td colspan="2" class="tabhead">����������� �� '.$nick.' �������</td>
           </tr>';

     echo '<tr><td class="armyinfo"><img src="'.$im1.'">'.$qty_need.'</td>
                  <td class="armyinfo">���������� ���</td></tr>
           <tr><td class="armyinfo"><img src="'.$im2.'">'.$qty_offer.'</td>
                  <td class="armyinfo">��������� ���� ��������</td><tr>';
     echo '</table>';


     // ������� �������� ��������� � ��� � �� ���!
     init_trades_moving($fid_from, $fid, $rft_id_offer, $qty_offer );
     init_trades_moving($fid, $fid_from, $rft_id_need, $qty_need );

     // � ������ ������ ��� �����������
     $res = mysql_query("DELETE from res_offers 
                               where ro_id = $ro_id" )
                               or die("Query failed : " . mysql_error());


}


// ������� ������� �������� ��������� 
function init_trades_moving( $fid_from, $fid_to, $rft_id, $qty ){
  // ���������� ���� ��������:
  $res = mysql_query("SELECT xcoord, ycoord from fields where fid=$fid_to" ) 
                     or die("Query failed : " . mysql_error());
  $row = mysql_fetch_array( $res );
  $p_x = $row["xcoord"];
  $p_y = $row["ycoord"];

  // �� ������ res_fields_types
  $p_wood  =  ( $rft_id == 3 ?  $qty : 0 );
  $p_clay  =  ( $rft_id == 4 ?  $qty : 0 );
  $p_ore   =  ( $rft_id == 2 ?  $qty : 0 );
  $p_grain =  ( $rft_id == 1 ?  $qty : 0 );

  // hash
  $hash = md5(mktime());

  init_send_res( $fid_from, $p_wood, $p_clay, $p_ore, $p_grain, $p_x, $p_y, $hash );

}

//////////// ������ ������ �� ����� �������� ////////////////
function create_trade_offer( $fid, $res1, $qty1, $res2, $qty2, $time, $hash ){

  if( !is_offer_hash( $fid, $hash )){

  // ������ �����, ������� �� �������� ��� �����������?
  // �� ������ res_fields_types
  $p_wood  =  ( $res1 == 3 ?  $qty1 : 0 );
  $p_clay  =  ( $res1 == 4 ?  $qty1 : 0 );
  $p_ore   =  ( $res1 == 2 ?  $qty1 : 0 );
  $p_grain =  ( $res1 == 1 ?  $qty1 : 0 );

  // � ������� � ��� ���� � �������
  $a_res = get_res( $fid );

  $f_grain = $a_res["grain"] -  how_offer_res( $fid, 1 );
  $f_ore   = $a_res["ore"]   -  how_offer_res( $fid, 2 );
  $f_wood  = $a_res["wood"]  -  how_offer_res( $fid, 3 );
  $f_clay  = $a_res["clay"]  -  how_offer_res( $fid, 4 );

  if ( ($p_grain <= $f_grain) &&
       ($p_ore <= $f_ore)  &&
       ($p_wood <= $f_wood) && 
       ($p_clay <= $f_clay)  ) {

       $res = mysql_query( "insert into res_offers (fid, rft_id_offer, ro_qty_offer, rft_id_need, ro_qty_need, ro_max_time, ro_hash) 
              values ( $fid, $res1, $qty1, $res2, $qty2, $time, '$hash') " )
              or die("Query failed : " . mysql_error());  

  } else {
  echo '<font color="#FF0000">��� ����� ����������� � ��� �� ������� ��������!</font>';
  }
  }
     
}

// �������� �� ���, ��� �� ��� ������ �����������? (F5 � ��������)
function is_offer_hash( $fid, $hash ){
        $res = mysql_query("SELECT ro_id from res_offers where fid=$fid and ro_hash='$hash'" ) 
                         or die("Query failed : " . mysql_error());
        return ( mysql_num_rows( $res ) > 0 );
}


// ��������, ��� � ��� ������������� ��� �������?
function how_offer_res( $fid, $res_type ){
        $res = mysql_query("SELECT ro_qty_offer from res_offers where fid=$fid and rft_id_offer = $res_type" ) 
                        or die("Query failed : " . mysql_error());
        if( mysql_num_rows( $res ) > 0 ){
            $row = mysql_fetch_array( $res );
            $qty = $row["ro_qty_offer"];
        } else $qty = 0;
        return ( $qty );   
}

/////// ������ ������������� �������� � ������� fields //////////
function create_portions( $fid, $wood, $clay, $ore, $grain ){
        $res = mysql_query("UPDATE fields set f_grain=$grain,
                                              f_ore=$ore,
                                              f_wood=$wood,
                                              f_clay=$clay where fid=$fid" ) 
                        or die("Query failed : " . mysql_error());

}

?>
