<?
    // Склад
echo '<table cellpadding="5" cellspacing="1" id="build_value"><tr>
      <td >Вместимость:</td>
      <td ><b>'.get_res_space( $b_level, 4 ).'</b> ед.</td>
      </tr>
      <tr>
      <td >Вместимость на уровне '.($b_level+1).':</td>
      <td ><b>'.get_res_space( $b_level + 1, 4 ).'</b> ед.</td>
      </tr>
      </table>';                            
?>