<?php
/**
 * messages functions
 * used by messahes.php controller
 */

function message_post($text, $from, $to, $pm)
{
  $text = sanitize_string($text);
  if ($text == '') return;
  $pm = substr(sanitize_string($pm), 0, 1);
  $time = time();
  my_sql_query("INSERT INTO vkmessages VALUES(NULL, '$from', '$to', '$pm', '$time', '$text')");
}