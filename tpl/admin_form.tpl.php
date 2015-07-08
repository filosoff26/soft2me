<?php
/*
 * form
 */

$page_content .= "<form action='admin.php' method='post'>";
if ($file[0])
  $page_content .= "<h3>файл №$file[0]</h3>";
else
  $page_content .= "<h3>Добавить файл</h3>";
$page_content .= "
file name<br>
<input type='text' name='file_name' value='$file[1]'><br>
file url<br>
<input type='text' name='file_url' value='$file[2]'><br>
category<br>
<select name='cat_name'>";
foreach ($categories as $category) {
  if ($category == $file[3])
    $selected = 'selected';
  $page_content .= "<option $selected value='$category'>$category</option>";
}
$page_content .= "</select><br>
описание<br>
<textarea name='file_info'>$file[4]</textarea><br>
<input type='hidden' name='action' value='$action'>";
if ($file[0])
  $page_content .= "<input type='hidden' name='file_id' value='$file[0]'>";
$page_content .= "<input type='submit' value='$action'></form>";
$page_content .= $msg;


