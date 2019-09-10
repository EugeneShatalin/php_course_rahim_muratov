<?php
 session_start();

 $image = $_FILES['image'];
 $idUser = $_SESSION['idUser'];
 $namePost = $_POST['name'];
 $emailPost = $_POST['email'];
 
 //Подключаемся к БД
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
$sql = "SELECT name_user, email, password, image FROM users WHERE id=$idUser";
//запрос к БД
$result = ($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));
//Преобразуем то, что отдала нам база в нормальный массив PHP $userArray со всеми данными текущего пользователя хоранящимися на момент обработки в БД:
$userArray = $result[0];
$userName = $userArray['name_user'];
$userEmail = $userArray['email'];
$userImageName = $userArray['image'];
$userPassword = $userArray['password'];

// Блок обработки данных из формы по изминению профайла
if(isset($_POST['updateProfile'])) {
//Если имя переданное из формы отличается от имени в БД, перезаписываем его
if($userName !== $namePost) {
  $sql_2 = "UPDATE users SET name_user = '$namePost' WHERE id = $idUser";
  $pdo->exec($sql_2);
  $update = true; // переменная для фиксации изминений(для вывода сообщения о успешно изминении)
}
//Проверка email на валидацию и дублирование
 if($userEmail !== $emailPost) { //Проверяем отличается ли введеный email от email в БД

    if (filter_var($emailPost, FILTER_VALIDATE_EMAIL)) {   //Проверяем соответствие email формату                
    $sql_3 = "SELECT email FROM users WHERE email='$emailPost'"; 
    $result_2 = ($pdo->query($sql_3)->fetch(PDO::FETCH_COLUMN)); 
      if(empty($result_2)) { //Проверяем email на дубликат в БД
        $sql_4 = "UPDATE users SET email = '$emailPost' WHERE id = $idUser";
        $pdo->exec($sql_4); //Презаписываем email в БД
        $update = true; // переменная для фиксации изминений(для вывода сообщения о успешно изминении)
      }
      else {
        $_SESSION['duplicateEmail'] = true; //Создаем переменную для ошибки дубля email
      }
    }
    else {
      $_SESSION['emailFormatFalse'] = true; //Создаем переменную для ошибки валидации email
    }
  }

// Блок обработки изображения
$imageName = $image['name'];
if(!empty($imageName)) {
  
  $filenameExtension = array_pop(explode('.', $imageName)); // отделяем расширение файла от имени
  $imageNewName = uniqid()."."."$filenameExtension"; // создаем новое имя файла с текущим расширением
  $tmp_name = $image['tmp_name']; // сохраняем в переменную временное место хранения файла
  move_uploaded_file( $tmp_name, "img/$imageNewName");

  $sql_5 = "UPDATE users SET image = '$imageNewName' WHERE id = $idUser"; //создаем sql запрос для заменны имени картинки профиля в БД
  $pdo->exec($sql_5); // Отправляе запрос в БД
  $update = true; // переменная для фиксации изминений(для вывода сообщения о успешно изминении)
  
  
  if(!empty($userImageName)) { // Если существовала до этого картинка профиля, удаляем ее
      unlink("img/$userImageName");
  }
  
}
if($update) {
  $_SESSION['update'] = true; // переменная в сессия для вывода сообщения об успешном изминении профиля
}

header("Location: profile.php");
}

// Блок обработки данных из формы по изминению пароля
if(isset($_POST['updatePassword'])) {
  $current = $_POST['current'];
  $password = $_POST['password'];
  $password_confirmation = $_POST['password_confirmation'];
  // проверяем совпадает ли введеный пароль с текущим в БД
  if(password_verify($current, $userPassword)) {
    // Проверямм длину нового пароля, не менее 8 символов
    if(strlen($password) > 8) {
      // Проверяем совпадение обоих введеных паролей
      if($password === $password_confirmation) {
        $sql_6 = "UPDATE users SET password = '$password' WHERE id = $idUser";
        $pdo->exec($sql_6); // Отправляе запрос в БД
        $updatePassword = true; // переменная для фиксации изминений(для вывода сообщения о успешно изминении)
      }
      else{
        $_SESSION['passwordConfirmationFalse'] = true;
      }
    }
    else {
      $_SESSION['passwordLengthFals'] = true;
    }
  }
  else {
    $_SESSION ['passwordFalse'] = true;
  }

header("Location: profile.php");
}
?>
