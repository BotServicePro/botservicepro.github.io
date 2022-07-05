<?
  // Шаблон для главного здания!

echo '<table cellpadding="5" cellspacing="1" id="build_value"><tr>
      <td >Время строительства:</td>
      <td ><b>'.get_build_speed( $b_level ).'</b> % </td>
      </tr>
      <tr>
      <td >Время строительства на уровне '.($b_level+1).':</td>
      <td ><b>'.get_build_speed( $b_level + 1 ).'</b> %</td>
      </tr>
      </table>';

?>