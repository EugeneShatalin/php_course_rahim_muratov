<?php 
  session_start();
  //Удаляем куки пользователя
  setcookie("emailUserСookie", "", time());
  setcookie("passUserСookie", "", time());
  //Удаляем данные из сессии
  session_destroy();
  $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();
