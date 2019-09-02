<?php
    session_start();
    // Берем данные комментария из $_POST, заносим в переменные.
    $name = $_POST['name'];
    $text = $_POST['text'];
  
    //Устанавливаем доступы к базе данных:
        $host = 'localhost'; //имя хоста, на локальном компьютере это localhost
        $user = 'root'; //имя пользователя, по умолчанию это root
        $password = ''; //пароль, по умолчанию пустой
        $db_name = 'rahim_project'; //имя базы данных

    //Соединяемся с базой данных используя наши доступы:
        $link = mysqli_connect($host, $user, $password, $db_name);

    //Устанавливаем кодировку (не обязательно, но поможет избежать проблем):
        mysqli_query($link, "SET NAMES 'utf8'");

    //Формируем тестовый запрос для записи данных из формы в БД:
        $query = "INSERT INTO comments (name_user, comment, date) VALUES ('$name', '$text', NOW())";

    //Делаем запрос к БД, заносим данные комментария в БД:
        mysqli_query($link, $query) or die(mysqli_error($link));
    
    //Создаем переменную в $_SESSION переменную, для вывода уведомления о добавлении комментария на главной:
        $_SESSION ['newComment'] = true;
    
    // Отправляем пользователя на главную:
        $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
        header("Location: $redirect");
        exit();    
?>