<?
    // Тайник
echo '<table cellpadding="5" cellspacing="1" id="build_value"><tr>
      <td >Тайник:</td>
      <td ><b>'.get_res_space( $b_level, 11 ).'</b> ед. сырья</td>
      </tr>
      <tr>
      <td >Тайник на уровне '.($b_level+1).':</td>
      <td ><b>'.get_res_space( $b_level + 1, 11 ).'</b> ед. сырья</td>
      </tr>
      </table>';                            
?>