
<?php


function checkmail($mail) {
   // режем левые символы и крайние пробелы
   $mail=trim($mail); // функцию pregtrim() возьмите выше в примере
   // если пусто - выход
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

// показываем ресурсы для поля
function show_res( $p_fid ){
      global $f_grain;
      global $f_ore;
      global $f_wood;
      global $f_clay;
      global $fid;
      $warehouse_capacity = get_space($fid, 4);   // вместимость склада
      $barn_capacity = get_space($fid, 3);        // вместимость амбара
      $a_res = get_res( $p_fid );
      
      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      echo '<div style="position:absolute left:200px; top:50px">'.'<img src="img/res/grain.png">'.$f_grain.'/'.$barn_capacity.' <img src="img/res/ore.png">'.$f_ore.'/'.$warehouse_capacity.' <img src="img/res/wood.png">'.$f_wood.'/'.$warehouse_capacity.' <img src="img/res/clay.png">'.$f_clay.'/'.$warehouse_capacity.' <img src="img/res/cons.png">'.get_res_cons( $p_fid ).'/'.get_prod( $p_fid, 1 ).'</div>';
}

// какая продукция выбранного ресурса 
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

// какое потребление зерна ресурсными полями?  (без построек в городе)
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
///////////////////  запасы ресурсов для деревни ////////////////////////
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
//  Сколько нужно для апгрейда ресурсного поля
//  $rf_id  - идентификатор ресурсного поля
///////////////////////////////////////////////////////////////////////////
function res_field_upgrade_cost( $rf_id ){
      global $link;
      $fid = $_SESSION['fid'];
      $retv = false;
      // Узнаем сколько ресурсов нужно для след.левела этого ресурсного поля
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
      // это - сколько нужно ресов и времени, чтоб сделать апгрейд                                 
      $row = mysql_fetch_array( $res );
      
      $a_res['grain'] = $row["rlc_grain"];
      $a_res['ore']   = $row["rlc_ore"];
      $a_res['wood']  = $row["rlc_wood"];
      $a_res['clay']  = $row["rlc_clay"];
      $a_res['time_upgrade']  = $row["rlc_time_upgrade"];

return ( $a_res );
}


///////////////////////////////////////////////////////////////////////////
// Функция, проверяет, хватает ли ресурсов для апгрейда ресурсного поля?
//  $rf_id  - идентификатор ресурсного поля
///////////////////////////////////////////////////////////////////////////
function allow_upgrade_res_field( $rf_id ){
      global $link;
      $fid = $_SESSION['fid'];
      $retv = false;
      // Узнаем сколько ресурсов нужно для след.левела этого ресурсного поля
      $query = "SELECT rlc_grain, 
                       rlc_ore, 
                       rlc_wood, 
                       rlc_clay
                       from res_fields rf
                       inner join res_levels_cost rlc on rf.rft_id=rlc.rft_id 
                       and (rf.rf_level+1) = rlc.rlc_level 
                       where fid=$fid and rf_id=$rf_id";
      $res = mysql_query( $query, $link ) or die("Query failed : " .mysql_error());
      
      // это - сколько нужно ресов, чтоб сделать апгрейд                                 
      $row = mysql_fetch_array( $res );
      
      
      $rlc_grain = $row["rlc_grain"];
      $rlc_ore = $row["rlc_ore"];
      $rlc_wood = $row["rlc_wood"];
      $rlc_clay = $row["rlc_clay"];
            
      // А это - сколько у нас есть в наличии
      $a_res = get_res( $fid );

      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      if ( ($rlc_grain <= $f_grain) &&
           ($rlc_ore <= $f_ore)  &&
           ($rlc_wood <= $f_wood) && 
           ($rlc_clay <= $f_clay)  ) {

           $retv = true;     // всех типов ресурсов достаточно для апгрейда

      } else {
           $retv = false;    // не хватает одного или более видов ресурсов....
      }
                  
   return ( $retv );

}


/////////////////////////////////////////////////////////////////////////
////////////////  Рабочие заняты на апгрейде рес.поля? //////////////////
////////////////  Возврат $retv = true - заняты        //////////////////
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
//////////// перевод формата времени 00:00:00 в секунды /////////
/////////////////////////////////////////////////////////////////
function h2s( $timestr ){
  $hms = explode(':', $timestr);
  $sec = $hms[0] * 3600 + $hms[1] * 60 + $hms[2];
  return ( $sec );
}


/////////////////////////////////////////////////////////////////
//////////// перевод секунд в формат времени 00:00:00   /////////
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


/////////// показывает - что в данный момент апгрейдится //////////
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
        echo '<b>Строительство:</b> <img src="img/res/time.png"><br>'.$bt_name.' ( Уровень '.($b_level+1).' )  &nbsp;&nbsp;<span id="restimer'.$cnt.'"></span> &nbsp;&nbsp;Готово в '.date('H:i',$time_e).'<br>';
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

///// Проверим, не пора ли заканчивать апгрейды ресурсных полей или зданий? ////////
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
          if( $time_e <= $curtime ){  // Если время апгрейда завершилось ...
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
//  Сколько нужно для апгрейда здания в поселке
//  $bid  - идентификатор здания
///////////////////////////////////////////////////////////////////////////
function building_upgrade_cost( $bid ){
      global $link;
      $fid = $_SESSION['fid'];   // id поселка
      $retv = false;
      // Узнаем сколько ресурсов нужно для след.левела этого ресурсного поля
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
      // это - сколько нужно ресов и времени, чтоб сделать апгрейд                                 
      $row = mysql_fetch_array( $res );
      
      $a_res['grain'] = $row["blc_grain"];
      $a_res['ore']   = $row["blc_ore"];
      $a_res['wood']  = $row["blc_wood"];
      $a_res['clay']  = $row["blc_clay"];
      $a_res['cons']  = $row["blc_cons"];
      $a_res['time_upgrade']  = $row["blc_time_upgrade"];

return ( $a_res );
}

///// функция возвращает скорость строительства в % //////////
function get_build_speed( $p_level ){
      // это только для главного здания 
      $query = "SELECT blc_build_speed from build_levels_cost
                       where blc_level=$p_level and bt_id=2";
      $res = mysql_query( $query ) or die("Query failed : " .$query);
      $row = mysql_fetch_array( $res );
      return( $row["blc_build_speed"] );
}



///////////////////////////////////////////////////////////////////////////
// Функция, проверяет, хватает ли ресурсов для апгрейда ресурсного поля?
//  $rf_id  - идентификатор ресурсного поля
///////////////////////////////////////////////////////////////////////////
function allow_upgrade_buildings( $bid ){
      global $link;
      $fid = $_SESSION['fid'];
      $retv = false;
      // Узнаем сколько ресурсов нужно для след.левела этого здания
      $query = "SELECT blc_grain, 
                       blc_ore, 
                       blc_wood, 
                       blc_clay
                       from buildings b
                       inner join build_levels_cost blc on b.bt_id=blc.bt_id 
                       and (b.b_level+1) = blc.blc_level 
                       where fid=$fid and bid=$bid";
      $res = mysql_query( $query, $link ) or die("Query failed : " .mysql_error());
      
      // это - сколько нужно ресов, чтоб сделать апгрейд                                 
      $row = mysql_fetch_array( $res );
      
      
      $blc_grain = $row["blc_grain"];
      $blc_ore = $row["blc_ore"];
      $blc_wood = $row["blc_wood"];
      $blc_clay = $row["blc_clay"];
            
      // А это - сколько у нас есть в наличии
      $a_res = get_res( $fid );

      $f_grain = $a_res["grain"];
      $f_ore   = $a_res["ore"];
      $f_wood  = $a_res["wood"];
      $f_clay  = $a_res["clay"];

      if ( ($blc_grain <= $f_grain) &&
           ($blc_ore <= $f_ore)  &&
           ($blc_wood <= $f_wood) && 
           ($blc_clay <= $f_clay)  ) {

           $retv = true;     // всех типов ресурсов достаточно для апгрейда

      } else {
           $retv = false;    // не хватает одного или более видов ресурсов....
      }
                  
   return ( $retv );

}


/////////////////////////////////////////////////////////////////////////
////////////////  Рабочие заняты на апгрейде здания? //////////////////
////////////////  Возврат $retv = true - заняты        //////////////////
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
///////// Строим новое здание ////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
function build_new( $fid, $bnum, $btype ){
      // Узнаем идентификатор стройплощадки
      $query = "SELECT bid
                       from buildings where bnum = $bnum and fid = $fid";
      $res = mysql_query( $query ) or die("Query failed : " .mysql_error());
      $row = mysql_fetch_array( $res );
      $bid = $row["bid"] ; 

      // Узнаем затраты на строительство для здания типа $btype 1 уровня
      $query = "SELECT blc_grain, 
                       blc_ore, 
                       blc_wood, 
                       blc_clay,
                       blc_time_upgrade
                       from build_levels_cost where blc_level = 1
                       and bt_id=$btype";
      $res = mysql_query( $query ) or die("Query failed : " .mysql_error());
      //  сколько нужно ресов? 
      $row = mysql_fetch_array( $res );
      
      $a_grain = $row["blc_grain"];
      $a_ore   = $row["blc_ore"];
      $a_wood  = $row["blc_wood"];
      $a_clay  = $row["blc_clay"];
      $a_time_up  = $row['blc_time_upgrade'];

      // Уменьшим кол-во ресурсов игрока в связи со строительством
      $query = "update fields set f_grain=f_grain-$a_grain,
                                        f_ore=f_ore-$a_ore, 
                                        f_wood=f_wood-$a_wood,
                                        f_clay=f_clay-$a_clay where fid=$fid";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

      // вставим этот тип здания в наш поселок на нужную стройплощадку
      $query = "update buildings set bt_id = $btype, b_level = 0 where bnum = $bnum and fid = $fid";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

      // в очередь на апрейд до 1 уровня
      $time_e = time()+h2s( $a_time_up );
      // не забываем установить  jr_type = 1 (тип: апгрейд здания)
      $query = "insert into job_upgrade(rf_id,time_s,time_e,jr_type) values($bid, ".time().",$time_e,1)";
      $result = mysql_query($query) or die("Query failed : " . mysql_error());

}


///// функция возвращает вместимость склада или амбара указаного уровня //////////
function get_res_space( $p_level, $btype ){
      $query = "SELECT blc_space from build_levels_cost
                       where blc_level=$p_level and bt_id=$btype";
      $res = mysql_query( $query ) or die("Query failed : " .$query);
      $row = mysql_fetch_array( $res );
      return( $row["blc_space"] );
}

///// функция возвращает вместимость склада или амбара в деревне //////////
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


?>
