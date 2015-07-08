<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.05.2015
 * Time: 16:13
 */
require_once 'inc/functions.php';
$user = get_user();
$page_content = '';
$admin_link = '';
if (isset($_GET['view'])) {
  $view = sanitize_string($_GET['view']);
  if (category_exists($view)) {
    $page_content = '404';
  } else {
    $result = my_sql_query("SELECT file_id, file_name, file_info FROM files WHERE cat_name='$view'");
    while ($row = mysql_fetch_assoc($result)) {
      $file_id = $row['file_id'];
      $file_name = $row['file_name'];
      $file_info = $row['file_info'];
      if (is_admin($user))
        $admin_link = " [<a href='admin.php?action=edit&id=$file_id'>edit</a>]";
      $page_content .= "
                <h3>
                    <a href='download.php?id=$file_id'>$file_name</a>
                    $admin_link
                </h3>
                <p class='file-info'>$file_info</p>
                ";
    }
  }

} else {
  $page_title = "Категории файлов";
  foreach ($categories as $category) {
    $page_content .= "<li><a href='catalog.php?view=$category[name]'>$category[title]</a></li>";
  }
}
include_once 'template.php';