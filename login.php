<?php
/*
 * login controller
 */
require_once 'inc/functions.php';
session_start();

$page_title = "Вход на сайт";
$error = $user = $pass = "";
if (isset($_POST['user'])) {
  $user = sanitize_string($_POST['user']);
  $pass = sanitize_string($_POST['pass']);
  if ($user == "" || $pass == "") {
    $error = "не все поля заполнены<br>";
  } else {
    $hash = sha1('1qaz' . $pass . '2wsx');
    $query = "SELECT user,pass FROM users WHERE user='$user' AND pass='$hash'";
    if (mysql_num_rows(my_sql_query($query)) == 0) {
      $error = "Неверный логин/пароль<br>";
      $user = '';
    } else {
      $_SESSION['user'] = $user;
      $loggedin = true;
    }
  }
}
include 'tpl/login.tpl.php';
include_once 'template.php';
?>