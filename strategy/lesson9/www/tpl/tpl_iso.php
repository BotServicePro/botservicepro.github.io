<?
 // Стройплощадка!
  
     $res = mysql_query("SELECT  bt.bt_id,bt.bt_name,bt.bt_image,bt_description,
                                 blc_grain, blc_ore, blc_wood, blc_clay, blc_cons, blc_time_upgrade
                                 FROM building_types bt
                                 inner join build_levels_cost blc on blc.bt_id = bt.bt_id
                                 WHERE blc_level = 1 and bt.bt_id <> 10 and bt.bt_id not in (select bt_id from
                                 buildings b WHERE b.fid = $fid) and bt.bt_id <> 1", $link )
                                 or die("Query failed : " . mysql_error());

      
     while ($row = mysql_fetch_array( $res )) {
         $btype   = $row["bt_id"];         // какой тип здания?
         $bt_name   = $row["bt_name"];
         $bt_image  = $row["bt_image"];
         $bt_description = $row["bt_description"];
         $a_grain   = $row["blc_grain"];
         $a_ore     = $row["blc_ore"];
         $a_wood    = $row["blc_gwood"];
         $a_clay    = $row["blc_clay"];
         $a_cons    = $row["blc_cons"];
         $a_time_up = $row["blc_time_upgrade"];

         if ( allow_tree_build( $fid, $btype) ){ // проверим дерево построек?

           echo '<br><img src="../'.$bt_image.'" align="right">';      
           echo "<span class='res_header'>".$bt_name." </span><br><br>";
           echo $bt_description."<br><br>";

           echo '<img src="img/res/grain.png">'.$a_grain.' | <img src="img/res/ore.png">'.$a_ore.' | <img src="img/res/wood.png">'.$a_wood.' | <img src="img/res/clay.png">'.$a_clay.' | <img src="img/res/cons.png">'.$a_cons.' | <img src="img/res/time.png"> '.$a_time_up.'<br>';
           if( !build_upgrade_in_progress( $fid ) )
               echo '<a class="build" href="village.php?bnum='.$bnum.'&bt='.$btype.'">Построить здание </a><br><br>'; 
           else echo '<font color="#CCCCCC">Строители заняты</font>';          
         }

     }
?>