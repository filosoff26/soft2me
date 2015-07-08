<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.05.2015
 * Time: 1:03
 */

//check perms

// log stats
$id = intval($_GET['id']);
if ($id = 0) die('404');
require_once 'inc/functions.php';
$result = my_sql_query("SELECT file_url FROM files WHERE file_id=$id");
if (!mysql_num_rows($result)) die('404');
$file_url = mysql_fetch_assoc($result)['file_url'];
http_redirect('http://91.228.31.9:8990/' . $file_url);

