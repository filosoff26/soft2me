<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.05.2015
 * Time: 17:48
 */
$page_content .= "<table border=1><tr>
<th>№</th>
<th>Имя</th>
<th>Категория</th>
<th>Информация</th>
</tr>";
foreach ($files as $file) {
  $page_content .= "<tr>
    <td>
        <a href='admin.php?action=edit&id=$file[0]'>$file[0]</a>
        [<a href='admin.php?action=del&id=$file[0]'>X</a>]
    </td>
    <td><a href='$file[2]'>$file[1]</a></td>
    <td>$file[3]</td>
    <td>$file[4]</td></tr>";

}
$page_content .= "</table>";