<?php
    session_start();
    // Берем данные комментария из $_POST, заносим в переменные.
    $name = $_POST['name'];
    $text = $_POST['text'];
    //Проверяе переменные из $_POST, сущестуютли:
    //Сперва проверяем обе
    if(empty($_POST['name']) && empty($_POST['text'])) {
        $_SESSION['nameValidation'] = true;
        $_SESSION['textValidation'] = true;
        // Отправляем пользователя на главную:
        $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
        header("Location: $redirect");
        exit();
    }
    //Проверяем отдельно первую, если первое условие ны выполнилась и одна из переменных не пустая
    elseif (empty($_POST['name'])){
        $_SESSION['nameValidation'] = true;
        $_SESSION['text'] = $text;
        // Отправляем пользователя на главную:
        $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
        header("Location: $redirect");
        exit();
     //Проверяем отдельно вторую, если первое условие ны выполнилась и одна из переменных не пустая
    } elseif (empty($_POST['text'])) {
        $_SESSION['textValidation'] = true;
        $_SESSION['name'] = $name; //Записываем переданные данные для передачив value, для предотвращения повторного ввода
        // Отправляем пользователя на главную:
        $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
        header("Location: $redirect");
        exit();
    }
  
    //Устанавливаем доступы к базе данных:       
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
    $sql = "INSERT INTO comments (name_user, comment, date) VALUES ('$name', '$text', NOW())";
    //Отправка запроса в БД
    $pdo->exec($sql);

    //Создаем переменную в $_SESSION переменную, для вывода уведомления о добавлении комментария на главной:
        $_SESSION ['newComment'] = true;
    
    // Отправляем пользователя на главную:
        $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
        header("Location: $redirect");
        exit();    
?>