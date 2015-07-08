<?php
/*
 * profile edit module
 * редактирование своего профиля - "о себе" и аватарка
 * access mode - user
 */
require_once 'inc/functions.php';
include_once 'tpl/template.php';
if (!isset($_SESSION['user']))
  die("<br><br>для просмотра этой страницы нужно войти на сайт");
$user = $_SESSION['user'];
echo "<h3>Редактирование вашего профиля</h3>";
if (isset($_POST['text'])) // нам дали текст
{
  $text = sanitize_string($_POST['text']);
  $text = preg_replace('/\s\s+/', ' ', $text);
  $query = "SELECT * FROM vkprofiles WHERE user='$user'"; // ищем старый текст
  if (mysql_num_rows(my_sql_query($query))) {
    my_sql_query("UPDATE vkprofiles SET text='$text' WHERE user='$user'"); // нашли - обновляем
  } else {
    $query = "INSERT INTO vkprofiles VALUES('$user', '$text')"; // иначе добавляем
    my_sql_query($query);
  }
} else {
  $query = "SELECT * FROM vkprofiles WHERE user='$user'"; // текст не дали, прочитаем что было
  $result = my_sql_query($query);
  if (mysql_num_rows($result)) {
    $row = mysql_fetch_row($result);
    $text = stripslashes($row[1]); // а нафига выдирать слэши?
  } else
    $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/', ' ', $text)); // и еще раз??

if (isset($_FILES['image']['name'])) // картинко?
{
  $saveto = "/avatars/$user.jpg";
  move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
  $typeok = TRUE;

  switch ($_FILES['image']['type']) // дальше без PHP_GD работать не будет
  {
    case "image/gif":
      $src = imagecreatefromgif($saveto);
      break;
    case "image/jpeg":
    case "image/pjpeg":
      $src = imagecreatefromjpeg($saveto);
      break;
    case "image/png":
      $src = imagecreatefrompng($saveto);
      break;
    default:
      $typeok = FALSE;
      break;
  }
  if ($typeok) {
    list($w, $h) = getimagesize($saveto); // ресайз
    $max = 100;
    $tw = $w;
    $th = $h;

    if ($w > $h && $max < $w) // слишком широко
    {
      $th = $max / $w * $h;
      $tw = $max;
    } elseif ($h > $w && $max < $h) // слишком высоко
    {
      $tw = $max / $h * $w;
      $th = $max;
    } elseif ($max < $w) // большой квадрат
    {
      $tw = $th = $max;
    }

    $tmp = imagecreatetruecolor($tw, $th);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h); // магия
    imageconvolution($tmp, array( // упорин
      array(-1, -1, -1),
      array(-1, 16, -1),
      array(-1, -1, -1)
    ), 8, 0);
    imagejpeg($tmp, $saveto);
    imagedestroy($tmp);
    imagedestroy($src);
  }
}
show_profile($user);
echo "<form method='post' action='profile.php' enctype='multipart/form-data'>
Напишите о себе и загрузите аватарку:<br>
<textarea name='text' cols='40' rows='3'>$text</textarea><br>
Аватарка: <input type='file' name='image' size='14' maxlength='32'>
<input type='submit' value='Сохранить'>
</form>";
?>