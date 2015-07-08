<?php
/*
 * main file - show home page
 */
require_once 'inc/functions.php';
$user = get_user();
$page_title = 'Главная страница';
$page_content = 'Добро пожаловать';

include_once 'template.php';
