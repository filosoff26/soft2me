<?php
/* functions file
 * main kernel for all engine
 * used in every file
 */

// переменные для начала
require_once '/inc/db.inc.php';
$appname = 'soft2me';
$avatars_dir = '/avatars/';
$user = '';

// захардкодил категории. потом может быть опасно
$categories = array(
  array('name' => 'security',
    'title' => 'Безопасность'),
  array('name' => 'development',
    'title' => 'Разработка'),
  array('name' => 'office',
    'title' => 'Офис'),
  array('name' => 'web_dev',
    'title' => 'Веб-разработка'),
  array('name' => 'system_tools',
    'title' => 'Системные'),
  array('name' => 'multimedia',
    'title' => 'Аудио-видео'),
  array('name' => 'admin_tools',
    'title' => 'Админу')
);

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die (mysql_error());
mysql_select_db($dbname) or die(mysql_error());
mysql_set_charset('utf8', $conn) or die(mysql_error());

function category_exists($category)
{
  global $categories;
  return array_search(array('name' => $category), $categories);
}

function is_admin($user)
{
  return ($user == 'alex' || $user == 'wadim') ? true : false;
}

/*
 * получить имя пользователя из сессии
 * выполнять только в начале скрипта!!!
 * нужно для админки
 */
function get_user()
{
  session_start();
  if (isset($_SESSION['user']))
    return $_SESSION['user'];
  else
    return false; //die("<br><br>Для просмотра этой страницы нужно войти на сайт");
}

function my_sql_query($query) // запросы к БД
{
  $result = mysql_query($query) or die(mysql_error()); // сдохнем при ошибке
  return $result;
}

function table_exists($name)
{
  $result = my_sql_query("SHOW TABLES LIKE '$name'");
  return mysql_num_rows($result);
}

function create_table($name, $query) // создание таблиц
{
  if (table_exists($name)) // а ну как уже есть?
    echo "table $name already exists<br>";
  else {
    my_sql_query("CREATE TABLE $name($query)");
    echo "table $name created<br>";
  }
}

function destroy_session() // проверка и удаление сессии
{
  $_SESSION = array(); // чистим сессию
  // очистка кук отключена до лучших времен [применение шаблонизатора]
  if (session_id() != "" || isset ($_COOKIE[session_name()]))
    setcookie(session_name(), '', time() - 60 * 60 * 24 * 30);
  session_destroy(); // грохаем сессию
}

function sanitize_string($var) // обезвреживание строки
{
  $var = strip_tags($var); // выкидываем теги (от XSS)
  $var = htmlspecialchars($var); // < > и прочее (??)
  $var = stripslashes($var); // слэши (от инъекций)
  $var = mysql_real_escape_string($var); // и еще по мусклю (??)
  return $var;
}

function show_profile($user) // отображение профиля пользователя
{
  global $avatars_dir;
  $out = '';
  if (file_exists($_SERVER['DOCUMENT_ROOT'] . "$avatars_dir/$user.jpg")) // добавляем картинку если есть
    $out .= "<img src='$avatars_dir/$user.jpg' border=1 align=left>";
  $result = my_sql_query("SELECT * FROM vkprofiles WHERE user='$user'"); // выполняем запрос к базе, берем всех из таблицы, должен попасться только один
  if (mysql_num_rows($result)) // если нашли
  {
    $row = mysql_fetch_row($result); // берем за жопу
    $out .= stripslashes($row[1]) . "<br clear=left><br>"; // и выдаем текст из первой ячейки
  }
  return $out;
}

?>