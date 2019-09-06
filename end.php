<?php 
  session_start();
  //Удаляем куки пользователя
  setcookie("emailUserСookie", "", time());
  setcookie("passUserСookie", "", time());
  //Удаляем данные из сессии
  session_destroy();
  header("Location: index.php");
