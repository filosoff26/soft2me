<?php
/*
 * check if user exists
 * used in ajax signup form
 */
require_once 'inc/functions.php';
if (isset($_POST['user'])) {
  $user = sanitize_string($_POST['user']);
  $query = "SELECT * FROM users WHERE user='$user'";
  if (mysql_num_rows(my_sql_query($query)))
    echo "<span class='red'>&nbsp;&larr;уже занято</span>";
  else
    echo "<span class='green'>&nbsp;&larr;доступно</span>";
}
?>