<?php
/*
 * messages module
 * only for users
 */
require_once 'inc/functions.php';
$user = get_user();
$view = isset($_GET['view']) ? sanitize_string($_GET['view']) : $user;

// post a message
if (isset($_POST['text'])) {
  $text = sanitize_string($_POST['text']);

  if ($text != "") {
    $pm = substr(sanitize_string($_POST['pm']), 0, 1);
    $time = time();
    my_sql_query("INSERT INTO vkmessages VALUES(NULL, '$user', '$view', '$pm', '$time', '$text')");
  }
}

include_once 'tpl/template.php';
// view messages
if ($view != "") {
  if ($view == $user) {
    $name1 = "Your";
    $name2 = "Your";
  } else {
    $name1 = "<a href='members.php'?view=$view'>$view</a>'s";
    $name2 = "$view's";
  }
  echo "<h3>$name1 Messages</h3>";
  show_profile($view);

  echo <<< _END
<form method='post' action='messages.php?view=$view'>
Текст сообщения: <br>
<textarea name='text' cols='40' rows='3'></textarea><br>
Public<input type='radio' name='pm' value='0' checked='checked'>
Private<input type='radio' name='pm' value='1'>
<input type='submit' value='Отправить'></form>
_END;
  if (isset($_GET['erase'])) {
    $erase = sanitize_string($_GET['erase']);
    my_sql_query("DELETE FROM vkmessages WHERE id=$erase AND recip='$user'");
  }
  $query = "SELECT * FROM vkmessages WHERE auth='$view' OR recip='$view' ORDER BY time DESC";
  $result = my_sql_query($query);
  $num = mysql_num_rows($result);
  for ($j = 0; $j < $num; $j++) {
    $row = mysql_fetch_row($result);
    if ($row[3] == 0 || // public
      $row[1] == $user || // from us
      $row[2] == $user
    ) //to us
    {
      echo date('d.m.y H:i:s', $row[4]); // timestamp format OMG
      echo " <a href='messages.php?";
      echo "view='$row[1]'>$row[1]</a> ";
      if ($row[3] == 0)
        echo ": $row[5]";
      else
        echo "(личное): <i><font color='#006600'>$row[5]</font></i> ";
      if ($row[2] == $user)
        echo " [<a href='messages.php?view=$view&erase=$row[0]'>стереть</a>]";
      echo "<br>";
    }
  }
}
if (!$num) echo "На заборе чисто<br>";
echo "<br><a href='messages.php?view=$view'>Обновить</a>";