<?   // �������

 // ���� ����� ��������� ��� ����������������� - ������� ���� �������:
 update_hero_resurect( $fid );
 show_resurect_progress( $fid );


 if( !hero_exists( $fid ) ){
     $res = mysql_query("SELECT sa.sa_id, sa_name, sa_image,
                                hrs_grain, hrs_ore, hrs_wood, hrs_clay, hrs_training_time
                                from spr_army sa
                                inner join army ar on ar.sa_id = sa.sa_id
                                inner join hero_resurection hrs on hrs.sa_id = ar.sa_id 
                                where sr_qty > 0 and sr_enable = 1 and hrs.hrs_level = 0 and fid=$fid" )
                                or die("Query failed : " . mysql_error());

     $num_rows = mysql_num_rows( $res );
     if( $num_rows > 0 ){
         echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
         <td width="300" class="tabhead">������ ��������� ������</td>
         <td class="tabhead">��������</td>
         </tr>';
        
         while ($row = mysql_fetch_array( $res )) {
             $atype   = $row["sa_id"];         // ����� ��� ������
             echo '<tr><td class="armyinfo"><img src="'.$row["sa_image"].'"><a href="#">'.$row["sa_name"].'</a> <br>';
             echo '<img src="img/res/grain.png">'.$row["hrs_grain"].' <img src="img/res/ore.png">'.$row["hrs_ore"].' <img src="img/res/wood.png">'.$row["hrs_wood"].' <img src="img/res/clay.png">'.$row["hrs_clay"].' <img src="img/res/time.png"> '.$row["hrs_training_time"].'</td>';      
             echo '<td class="armyinfo">'; 
             if( allow_resurect( $fid, $atype ) ){
                echo '<a href="#" onClick="do_resurect('.$atype.')">�����������</a>';
             } else {
                echo '<font color="#CCCCCC">�� ������� �����</font>';
             }
             echo '</td>';
             echo '</tr>';
         }
         echo '</table>';
         echo '<br>';
     }  else {
          echo '<table  style="border-collapse: collapse;" cellpadding="0" cellspacing="0" id="army"><tr>
               <td width="450" class="tabhead">�����</td>
               <tr>
               <td width="450" class="armyinfo"><font color="#CCCCCC">� ��������� ������ � ������� ��� ������, ������� ����� �� ����� �������.</font></td>
               <tr>
               </table>';
     }

 } else {    // ����� ��� ����!


    // ������ �������� �������������
    if( isset( $_GET["up"] ) ){
       add_skill( $fid, $_GET["up"] );
    }


      $result = mysql_query("SELECT sa.sa_name, h.sa_attack, h.sa_inf_defence, h.sa_cav_defence, 
                             hr_attack_bonus, hr_defence_bonus, hr_regeneration, hr_points,
                             hr_level, hr_experience, hr_state, hr_points, hr_health,
                             sa_attack_pts, sa_defence_pts, hr_attack_bonus_pts, hr_defence_bonus_pts, hr_regeneration_pts
                             from heroes h
                             inner join spr_army sa on sa.sa_id=h.sa_id
                             where fid=$fid" ) 
                             or die("Query failed : " . mysql_error());
        $row = mysql_fetch_array( $result );
        $sa_name = $row["sa_name"];                    // ������ ���� �����?
        $sa_attack = $row["sa_attack"];                // �����
        $sa_inf_defence = $row["sa_inf_defence"];      // ������ �� ������
        $sa_cav_defence = $row["sa_cav_defence"];      // ������ �� ���������
        $hr_attack_bonus = $row["hr_attack_bonus"];    // ����� ����� �����
        $hr_defence_bonus = $row["hr_defence_bonus"];  // ����� ������ �����
        $hr_regeneration = $row["hr_regeneration"];    // �������������� � �����
        $hr_level = $row["hr_level"];                  // ������� �����
        $hr_experience = $row["hr_experience"];        // ���� �����
        $hr_state = $row["hr_state"];                  // ���? 0-���,1-��
        $hr_health = $row["hr_health"];                // �������� �����

        // ����
        $hr_points = $row["hr_points"];                // ���������������� ����

        $sa_attack_pts = $row["sa_attack_pts"];               // ���� �����
        $sa_defence_pts = $row["sa_defence_pts"];             // ���� ������
        $hr_attack_bonus_pts = $row["hr_attack_bonus_pts"];   // ���� � ������ ����� �����
        $hr_defence_bonus_pts = $row["hr_defence_bonus_pts"]; // ���� � ������ ������ �����
        $hr_regeneration_pts = $row["hr_regeneration_pts"];   // ���� � �������������� � �����

        if( $hr_state == 1 ){
            // ��������� ������� ��� progress-bar (168px - max �����)
            $sa_attack_pb      = 1+(168*($sa_attack_pts-($hr_level*5))*20)/100;
            $sa_defence_pb       = 1+(168*($sa_defence_pts-($hr_level*5))*20)/100;
            $hr_attack_bonus_pb   = 1+(168*($hr_attack_bonus_pts-($hr_level*5))*20)/100;
            $hr_defence_bonus_pb  = 1+(168*($hr_defence_bonus_pts-($hr_level*5))*20)/100;
            $hr_regeneration_pb   = 1+(168*($hr_regeneration_pts-($hr_level*5))*20)/100;
            $exp_pb = 1+168/100*$hr_experience * get_hero_exp_level( $hr_level+1 ) / 100;
    ?>


 <table id="distribution" class="distr" cellpadding="0" cellspacing="0">
	<tr>
		<td class="trade_bg" colspan="5">����� ������� <? echo $hr_level.' ('. $sa_name.')'; ?></span></th>
	</tr>
        <?
        echo '<tr>
		<td class="armyinfo">���������:</td>
		<td class="armyinfo">'.$sa_attack.'</td>
		<td class="xp"><img class="bar" src="img/x.gif" style="width:'.$sa_attack_pb.'px;" title="<? echo $sa_attack; ?>" /></td>';
		if($hr_points>0)
    		   echo '<td class="armyinfo"><a href="build.php?bnum='.$bnum.'&up=1">(<b>+</b>)</a></td>';
                else
   		   echo '<td class="armyinfo"><span class="none">(<b>+</b>)</span></td>';
                echo '<td class="armyinfo">'.$sa_attack_pts.'</td>
	</tr>
	<tr>
		<td class="armyinfo">������:</td>
		<td class="armyinfo">'.$sa_inf_defence."/".$sa_cav_defence.'</td>
		<td class="xp"><img class="bar" src="img/x.gif" style="width:'.$sa_defence_pb.'px;" title="" /></td>';
		if($hr_points>0)
    		   echo '<td class="armyinfo"><a href="build.php?bnum='.$bnum.'&up=2">(<b>+</b>)</a></td>';
                else
   		   echo '<td class="armyinfo"><span class="none">(<b>+</b>)</span></td>';
		echo '<td class="armyinfo">'.$sa_defence_pts.'</td>
	</tr>
	<tr>
		<td class="armyinfo">�����.-�����:</td>
		<td class="armyinfo">'.$hr_attack_bonus.'%</td>
		<td class="xp"><img class="bar" src="img/x.gif" style="width:'.$hr_attack_bonus_pb.'px;" title="" /></td>';
		if($hr_points>0)
    		   echo '<td class="armyinfo"><a href="build.php?bnum='.$bnum.'&up=3">(<b>+</b>)</a></td>';
                else
   		   echo '<td class="armyinfo"><span class="none">(<b>+</b>)</span></td>';
		echo '<td class="armyinfo">'.$hr_attack_bonus_pts.'</td>
	</tr>
	<tr>
		<td class="armyinfo">���.-�����:</td>
		<td class="armyinfo">'.$hr_defence_bonus.'%</td>
		<td class="xp"><img class="bar" src="img/x.gif" style="width:'.$hr_defence_bonus_pb.'px;" title="" /></td>';
		if($hr_points>0)
    		   echo '<td class="armyinfo"><a href="build.php?bnum='.$bnum.'&up=4">(<b>+</b>)</a></td>';
                else
   		   echo '<td class="armyinfo"><span class="none">(<b>+</b>)</span></td>';
		echo '<td class="armyinfo">'.$hr_defence_bonus_pts.'</td>
	</tr>
	<tr>
		<td class="armyinfo">��������������:</td>
		<td class="armyinfo">'.$hr_regeneration.'/�����</td>
		<td class="xp"><img class="bar" src="img/x.gif" style="width:'.$hr_regeneration_pb.'px;" title="" /></td>';
		if($hr_points>0)
    		   echo '<td class="armyinfo"><a href="build.php?bnum='.$bnum.'&up=5">(<b>+</b>)</a></td>';
                else
   		   echo '<td class="armyinfo"><span class="none">(<b>+</b>)</span></td>';
		echo '<td class="armyinfo">'.$hr_regeneration_pts.'</td>
	</tr>
	<tr>
		<td colspan="5" class="empty"></td>
	</tr>
	<tr>
		<td class="armyinfo" title="�� ���������� ������">����:</td>
		<td class="armyinfo">'.$hr_experience.'%</td>
		<td class="xp"><img class="bar" src="img/x.gif" style="width:'.$exp_pb.'px;" title="" /></td>
		<td class="armyinfo"></td>
		<td class="armyinfo">'.$hr_points.'</td>
	</tr></table>';

        echo '<br>��� ����� ������ �� <b>'.$hr_health.'</b>%<br>';

      }
 }  

?>

