<?php
die ('registration closed');
require_once 'inc/functions.php';
include_once 'tpl/template.php';
?>
  <script src="js/ajax.js"></script>
  <script>

    function checkUser(user) {
      if (user.value == '') {
        document.getElementById('info').innerHTML = ''
        return
      }
      params = "user=" + user.value
      request = new ajaxRequest()
      request.open("POST", "checkuser.php", "true")
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      request.setRequestHeader("Content-length", params.length)
      request.setRequestHeader("Connection", "close")
      request.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) {
            if (this.responseText != null) {
              document.getElementById('info').innerHTML =
                this.responseText
            }
            else alert("Ajax error: data not received")
          }
          else alert("Ajax error: " + this.statusText)
        }
      }
      request.send(params)
    }
  </script>
  <h3>Sign up form</h3>
<?php
$error = $user = $pass = "";
if (isset($_SESSION['user'])) destroy_session();

if (isset($_POST['user'])) {
  $user = sanitize_string($_POST['user']);
  $pass = sanitize_string($_POST['pass']);

  if ($user == "" || $pass == "") {
    $error = "данные получены не во все поля<br><br>";
  } else {
    $query = "SELECT * FROM users WHERE user='$user'";
    if (mysql_num_rows(my_sql_query($query)))
      $error = "такое имя уже используется<br>";
    else {
      $hash = sha1('1qaz' . $pass . '2wsx');
      $query = "INSERT INTO users VALUES('$user', '$hash')";
      my_sql_query($query);
    }
    die ("<h4>Аккаунт создан</h4>Теперь можно войти.");
  }
}
echo <<< _END
<form method='post' action='signup.php'>$error
Логин <input type='text' maxlength='16' name='user' value='$user' onBlur='checkUser(this)'><span id='info'></span><br>
Пароль <input type='text' maxlength='16' name='pass' value='$pass'><br>
<input type='submit' value='signup'>
</form>
_END;
?>