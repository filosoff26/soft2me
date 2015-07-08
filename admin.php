<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.05.2015
 * Time: 13:01
 */
require_once 'inc/functions.php';
// проверка прав доступа
$user = get_user();
if (!$user) die ("access denied");
$msg = '';
// добавление-обновление файла
if ($_POST['action'] == 'add' || $_POST['action'] == 'update') {
  if (isset($_POST['file_name']) &&
    isset($_POST['file_url']) &&
    isset($_POST['cat_name']) &&
    isset($_POST['file_info'])
  ) {
    $file_name = substr(sanitize_string($_POST['file_name']), 0, 40);
    $file_url = substr(sanitize_string($_POST['file_url']), 0, 256);
    $cat_name = sanitize_string($_POST['cat_name']);
    $file_info = substr(sanitize_string($_POST['file_info']), 0, 1024);
    if ($_POST['action'] == 'add') {
      my_sql_query("INSERT INTO files VALUES(NULL, '$file_name', '$file_url', '$cat_name', '$file_info')");
      $msg = 'файл добавлен';
    }
    if ($_POST['action'] == 'update') {
      $file_id = sanitize_string($_POST['file_id']);
      my_sql_query("UPDATE files SET file_name='$file_name', file_url='$file_url', cat_name='$cat_name', file_info='$file_info' WHERE file_id=$file_id");
      $msg = 'файл обновлен';
    }
  }
}
// редактирование файла
if ($_GET['action'] == 'edit' && isset($_GET['id'])) {
  $file_id = sanitize_string($_GET['id']);
  $result = my_sql_query("SELECT * from files WHERE file_id=$file_id");
  $file = mysql_fetch_array($result);
  $action = 'update';
  include 'tpl/admin_form.tpl.php';

}
// удаление файла
if ($_GET['action'] == 'del' && isset($_GET['id'])) {
  $file_id = sanitize_string($_GET['id']);
  my_sql_query("DELETE FROM files WHERE file_id=$file_id");
}
$result = my_sql_query("SELECT * FROM files");
$files = array();
for ($i = 0; $i < mysql_num_rows($result); $i++)
  $files[$i] = mysql_fetch_array($result);
include 'tpl/admin_table.tpl.php';
include_once 'template.php';