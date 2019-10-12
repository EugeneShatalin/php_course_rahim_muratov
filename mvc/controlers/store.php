<?php
    session_start();
    
    //Проверяе переменные из $_POST, сущестуютли:
    //Проверяем заполнен комментарий или нет
    if (empty($_POST['text'])) {
        $_SESSION['textValidation'] = true;
        // Отправляем пользователя на главную:
        header("Location: $redirect");
        exit();
    }
    // добавляем переменну, хранящую текущее время
    $date = date('Y-m-d H:m:i', time());
    
    $db = include  __DIR__ . '/../models/start.php';
    $db->create('comments', 
                [
                    'id_user' => $_POST['idUser'],
                    'comment' => $_POST['text'],
                    'date' => $date
                ]);

    //Создаем переменную в $_SESSION переменную, для вывода уведомления о добавлении комментария на главной:
        $_SESSION ['newComment'] = true;
    
    // Отправляем пользователя на главную:
        $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
        header("Location: $redirect");
        exit();    
?>