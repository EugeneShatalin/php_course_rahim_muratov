<?php
//Подключение к БД        
$driver = 'mysql'; // тип базы данных, с которой мы будем работать 
$host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального    
$db_name = 'rahim_project'; // имя базы данных     
$db_user = 'root'; // имя пользователя для базы данных     
$db_password = ''; // пароль пользователя     
$charset = 'utf8'; // кодировка по умолчанию     
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; // массив с дополнительными настройками подключения
//создание переменной хранящей параметры БД
$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
//создание обьекта PDO
$pdo = new PDO($dsn, $db_user, $db_password, $options);

if($_GET['comment'] == 'false') {
  $id = $_GET['id_comment'];
  $sql = "UPDATE comments SET do_not_show_comment = 1 WHERE id = $id";
  $pdo->exec($sql);
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();  
}
if($_GET['comment'] == 'true') {
  $id = $_GET['id_comment'];
  $sql = "UPDATE comments SET do_not_show_comment = 0 WHERE id = $id";
  $pdo->exec($sql);
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
}
if($_GET['comment'] == 'delet') {
  $id = $_GET['id_comment'];
  $sql = "DELETE FROM comments WHERE id = $id";
  $pdo->exec($sql);
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
}
?>