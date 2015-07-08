<?php
/*
 * login template
 * кажет если ты вошел или форму если не вошел
 * на вход требует $user или еще как то назвать юзера который зашел, или юзера который еещ пытается
 */
if ($loggedin) $page_content = "Вы успешно вошли. <a href='index.php'>Продолжить</a>";
else $page_content = "
<form method='post' action='login.php'><span class='error'>$error</span>
    <label class='label'>Логин</label><input type='text' maxlength='16' name='user' value='$user'><br>
    <label class='label'>Пароль</label><input type='password' maxlength='16' name='pass' value='$pass'><br>
    <input class='login-button' type='submit' value='Вход'>
</form>";