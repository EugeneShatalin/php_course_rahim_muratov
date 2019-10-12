<?php
session_start();
$condition = 'id = ' . $_GET['id_comment'];
$db = include  __DIR__ . '/../models/start.php';

if($_GET['comment'] == 'false') {  
  $db->update('comments', 
                [
                    'do_not_show_comment' => 1,
                ],
                $condition
              );
 
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';  
  header("Location: $redirect");
  exit();  
}
if($_GET['comment'] == 'true') {
  $db->update('comments', 
                [
                    'do_not_show_comment' => 0,
                ],
                $condition
              );

  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
}
if($_GET['comment'] == 'delet') {
  $db->delete('comments', $_GET['id_comment']);
  
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
}
?>