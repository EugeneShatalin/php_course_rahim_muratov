<?php
  session_start();

//Блок кода для валидации данных из формы:
  //Проверка на пустоту поля формы Имя
    if (empty($_POST['name'])) {
      $_SESSION['nameRegisterFalse'] = true;      
    }
  //Проверка на пустоту и валидация поля формы E-Mail Address
    //Отдельно проверяем валидацию и заполнение поля формы E-Mail Address, для вывода соответствующих сообщений об ошибке
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
      $_SESSION['emailNoValidate'] = true;
    } elseif (empty($_POST['email'])) {
      $_SESSION['emailRegisterFalse'] = true;
    }
    //Подключаемся к БД для проверки E-mail ареса на повторное использование при регистрации
    $db = include  __DIR__ . '/../models/start.php';

    $result =  $db->getRequestWithCondition('email', 'users', "email = '".$_POST['email']."'");
    
  if (!empty($result)) {
        $_SESSION['trueEmailSame'] = true;        
    }
   
  //Проверка на пустоту поля формы Password
  if (empty($_POST['password'])) {
    $_SESSION['passRegisterFalse'] = true;
  }
  //Проверям соответствеее пароля минимальному количеству символов
  if(!empty($_POST['password']) && strlen($_POST['password']) < 8) {
    $_SESSION['falsPassLength'] = true;
  }
  //Проверка на пустоту поля формы Confirm Password
  if (empty($_POST['password_confirmation'])) {
    $_SESSION['cofPassRegisterFalse'] = true;
  }
  //Проверям идентичность введеного пароля в обоих полях
  if((!empty($_POST['password']) && !empty($_POST['password_confirmation']) && strlen($_POST['password']) >= 8) && ($_POST['password'] !== $_POST['password_confirmation']))  {
    $_SESSION['falsPassSame'] = true;
  }
  

  //Проверяем была ли допущенна какая-то ошибка при заполнении формы
    if ($_SESSION['nameRegisterFalse'] || $_SESSION['emailNoValidate'] || $_SESSION['emailRegisterFalse'] || $_SESSION['passRegisterFalse'] || $_SESSION['cofPassRegisterFalse'] || $_SESSION['falsPassLength'] || $_SESSION['falsPassSame'] || $_SESSION['trueEmailSame']) {
      //если будеть хотя бы одна ошибка вернем пользователя на страницу с формой регистрации и там выведем ошибки
      $_SESSION['nameSave'] = $_POST['name']; //сохраняем в сессии данные для вставки в value=""
      $_SESSION['emailSave'] = $_POST['email']; //сохраняем в сессии данные для вставки в value=""
      $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
      header("Location: $redirect");
      exit();
       //прерываем дальнейшее выполнение скрипта
    }
    
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //хешируем пароль

    $db->create('users', [
                'name_user' => $_POST['name'],
                'email'     => $_POST['email'],
                'password'  => $password
    ]);
   

    // Отправляем пользователя на главную:
    $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
  header("Location: $redirect");
  exit();

