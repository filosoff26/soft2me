<?php
require_once 'inc/functions.php';
echo '<h3>Setting up</h3>';
create_table('users', 'user VARCHAR(16), pass VARCHAR(16), INDEX(user(6))');
create_table('messages', 'msg_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          msg_from VARCHAR(16),
                          msg_to VARCHAR(16),
                          time INT UNSIGNED,
                          msg_text VARCHAR(4096),
                          INDEX(msg_from(6)),
                          INDEX(msg_to(6))');
create_table('files', 'file_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, file_name VARCHAR(40), file_url VARCHAR(64), cat_name VARCHAR(16), file_info VARCHAR(1024), INDEX(file_name(6))');
?>