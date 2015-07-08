<?php
/*
 * logout controller
 */
require_once 'inc/functions.php';
$user = get_user();
$title = "<h3>Log out</h3>";
if ($user) {
  destroy_session();
  $user = "";
  $msg = "Сеанс завершен. <a href='index.php'>На главную</a>";
} else $msg = "Вы не вошли на сайт";
include_once 'template.php';
echo $title;
echo $msg;
?>