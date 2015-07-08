<?php
/**
 * main template file
 * содержит начальные html-тэги и прочую инфу
 * сессия обычно уже открыта, заголовки отправлены
 */
?>
<html>
<head>
  <link rel='stylesheet' href='css/main.css' type='text/css'>
  <title>
    <?php echo $appname; ?>
    <?php if ($user) echo " ($user)"; ?>
  </title></head>
<body>
<div id='menu'>
  <input id='search-field' type='text'>
  <ul>
    <?php if ($user) {
      echo "
            <li><a href='admin.php'>Админка</a></li>
            <li><a href='catalog.php'>Каталог</a></li>
            <li><a href='logout.php'>Выход</a></li>
            ";
    } else {
      echo "
            <li><a href='index.php'>Домой</a></li>
            <li><a href='login.php'>Вход</a></li>
            ";
    } ?>
  </ul>
</div>
<div id='disclaimer'>
  <?php echo $contacts ?: "skype, vk, email"; ?>
</div>
<div id='logo'>
  <img src='img/logo.png' alt='soft2me'>
</div>
<div id='page-title' class="block">
  <h3><?php echo $page_title ?: "page title"; ?></h3>
</div>
<div id='catalog' class="block">
  <div id='catalog-title'>
    Каталог
  </div>
  <ul>
    <?php foreach ($categories as $category) {
      echo "<li><a href='catalog.php?view=$category[name]'>$category[title]</a></li>";
    } ?>
  </ul>
</div>
<div id='content' class="block">
  <?php echo $page_content ?: "page content"; ?>
</div>
</body>
</html>