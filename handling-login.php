<?php
session_start();
//данные из $_POST заносим в переменные
$email = $_POST['email'];
$password = $_POST['password'];
//Блок Валидация авторизации
if(empty($email)) {
  $_SESSION['emailNot'] = true;
  header("Location: login.php");
  exit;
}
if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
  $_SESSION['emailNoValidate'] = true;
  header("Location: login.php");
  exit;
}
if (empty($password)) {
  $_SESSION['passNot'] = true;
  header("Location: login.php");
  exit;
} 
//Подключаемся к БД для проверки регистрации E-mail и соответвия пароля
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
//sql запрос к БД
$sql = "SELECT email, id, name_user, password FROM users WHERE id>0 AND email='$email'";
//запрос к БД
$result = $pdo->query($sql);
//Преобразуем то, что отдала нам база в нормальный массив PHP $emailAndPass:
for ($emailAndPass = []; $row = $result->fetchAll(PDO::FETCH_UNIQUE); $emailAndPass[] = $row);

// Блок обработки формы изминения профиля

//Перебераем полученный массиив с проверкой email и password
if(!empty($emailAndPass)) {
  $pass = $emailAndPass[0][$email]['password'];
 
  if(password_verify($password, $pass)) {
    $_SESSION['emailUser'] = $email; // сохраняем email в сессию
    $_SESSION['idUser'] = $emailAndPass[0][$email]['id']; // сохраняем id в сессию
    $_SESSION['nameUser'] =  $emailAndPass[0][$email]['name_user']; // сохраняем картинку профеля в сессию
    if(isset($_POST['remember'])) { //и если существует переменная отмеченного цекбокса создаем куки
      setcookie("emailUserСookie", "$email", time() + 900);
      setcookie("passUserСookie", "$pass", time() + 900);
      
    }
    else { //если чекбокс не включен удаляем куки текущего пользователя
      setcookie("emailUserСookie", "$email", time());
      setcookie("passUserСookie", "$pass", time());
    }
  }
  else {
    $_SESSION['loginPassFalse'] = true;
    $_SESSION['email'] = $email; //Сохраним email в переменную чтобы повторно не вводить при ошибке пароля
    header("Location: login.php");
    exit;
  }
}
else {
  $_SESSION['loginEmailFalse'] = true;
  header("Location: login.php");
  exit;
}

header("Location: index.php");
