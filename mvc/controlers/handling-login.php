<?php
session_start();

//данные из $_POST заносим в переменные
//$email = $_POST['email'];
//$password = $_POST['password'];
//Блок Валидация авторизации
if(empty($_POST['email'])) {
  $_SESSION['emailNot'] = true;
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
}
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
  $_SESSION['emailNoValidate'] = true;
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
}
if (empty($_POST['password'])) {
  $_SESSION['passNot'] = true;
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
} 
//Подключаемся к БД для проверки регистрации E-mail и соответвия пароля
$db = include  __DIR__ . '/../models/start.php';
$result = $db->getRequestWithConditionAND('email, id, name_user, password', 'users', 'id>0', 'email='."'".$_POST['email']."'");
$emailAndPass = $result[0];

//Перебераем полученный массиив с проверкой email и password
if(!empty($emailAndPass)) {
  if(password_verify($_POST['password'], $emailAndPass['password'])) {
    $_SESSION['emailUser'] = $_POST['email']; // сохраняем email в сессию
    $_SESSION['idUser'] = $emailAndPass['id']; // сохраняем id в сессию
    $_SESSION['nameUser'] =  $emailAndPass['name_user']; // сохраняем имя
    if(isset($_POST['remember'])) { //и если существует переменная отмеченного цекбокса создаем куки
      setcookie("emailUserСookie", "{$_POST['email']}", time() + 900);
      setcookie("passUserСookie", "{$_POST['password']}", time() + 900);
      
    }
    else { //если чекбокс не включен удаляем куки текущего пользователя
      setcookie("emailUserСookie", "{$_POST['email']}", time());
      setcookie("passUserСookie", "{$_POST['password']}", time());
    }
  }
  else {
    $_SESSION['loginPassFalse'] = true;
    $_SESSION['email'] = $_POST['email']; //Сохраним email в переменную чтобы повторно не вводить при ошибке пароля
    $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
  }
}
else {
  $_SESSION['loginEmailFalse'] = true;
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
}

$redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
