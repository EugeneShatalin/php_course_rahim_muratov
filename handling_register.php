<?php
  session_start();
  // Берем данные регистрации из $_POST, заносим в переменные.
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_confirmation = $_POST['password_confirmation'];

//Блок кода для валидации данных из формы:
  //Проверка на пустоту поля формы Имя
    if (empty($name)) {
      $_SESSION['nameRegisterFalse'] = true;      
    }
  //Проверка на пустоту и валидация поля формы E-Mail Address
    //Отдельно проверяем валидацию и заполнение поля формы E-Mail Address, для вывода соответствующих сообщений об ошибке
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
      $_SESSION['emailNoValidate'] = true;
    } elseif (empty($email)) {
      $_SESSION['emailRegisterFalse'] = true;
    }
    //Подключаемся к БД для проверки E-mail ареса на повторное использование при регистрации
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
  $sql = "SELECT email FROM users WHERE id > 0";
  //запрос к БД
  $result = $pdo->query($sql);
  //Преобразуем то, что отдала нам база в нормальный массив PHP $comments:
  for ($emailSame = []; $row = $result->fetch(PDO::FETCH_COLUMN); $emailSame[] = $row);
  //Перебераем полученный массив для поиска дубликата E-mail
  foreach($emailSame as $elem ) {
    if ($elem == $email) {
        $_SESSION['trueEmailSame'] = true; 
        break;//Если обнаружен дубликат адреса создаем переменную в сессии и выходим из цикла
    }          
  }  
  //Проверка на пустоту поля формы Password
  if (empty($password)) {
    $_SESSION['passRegisterFalse'] = true;
  }
  //Проверям соответствеее пароля минимальному количеству символов
  if(!empty($password) && strlen($password) < 8) {
    $_SESSION['falsPassLength'] = true;
  }
  //Проверка на пустоту поля формы Confirm Password
  if (empty($password_confirmation)) {
    $_SESSION['cofPassRegisterFalse'] = true;
  }
  //Проверям идентичность введеного пароля в обоих полях
  if((!empty($password) && !empty($password_confirmation) && strlen($password) >= 8) && ($password === $password_confirmation))  {
    $_SESSION['falsPassSame'] = true;
  }
  

  //Проверяем была ли допущенна какая-то ошибка при заполнении формы
    if ($_SESSION['nameRegisterFalse'] || $_SESSION['emailNoValidate'] || $_SESSION['emailRegisterFalse'] || $_SESSION['passRegisterFalse'] || $_SESSION['cofPassRegisterFalse'] || $_SESSION['falsPassLength'] || $_SESSION['falsPassSame'] || $_SESSION['trueEmailSame']) {
      //если будеть хотя бы одна ошибка вернем пользователя на страницу с формой регистрации и там выведем ошибки
      $_SESSION['nameSave'] = $name; //сохраняем в сессии данные для вставки в value=""
      $_SESSION['emailSave'] = $email; //сохраняем в сессии данные для вставки в value=""
      header("Location: register.php");
      exit; //прерываем дальнейшее выполнение скрипта
    }
    
    $password = password_hash($password, PASSWORD_DEFAULT); //хешируем пароль

    $driver = 'mysql'; // тип базы данных, с которой мы будем работать 
    $host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального    
    $db_name = 'rahim_project'; // имя базы данных     
    $db_user = 'root'; // имя пользователя для базы данных     
    $db_password = ''; // пароль пользователя     
    $charset = 'utf8'; // кодировка по умолчанию     
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; // массив с дополнительными настройками подключения. В данном примере мы установили отображение ошибок, связанных с базой данных, в виде исключений
    //создание переменной хранящей параметры БД
    $dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
    //создание обьекта PDO
    $pdo = new PDO($dsn, $db_user, $db_password, $options);
    //sql запрос к БД
    $sql = "INSERT INTO users (name_user, email, password) VALUES ('$name', '$email', '$password')";
    //Отправка запроса в БД
    $pdo->exec($sql);

    // Отправляем пользователя на главную:
    header("Location: index.php");

