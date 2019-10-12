<?php
//Запуск сессии
    session_start();
    //передаем в переменную ID пользователя для формирования запроса на получения данных из двух таблиц
   
    $db = include  __DIR__ . '/../models/start.php';

    
    $row = $db->getDataFromTwoTables_DESC('users', 'comments', 'id', 'id_user');    
    
        //Блок проверки авторизации
    if (!isset($_SESSION['emailUser'])) { //проверка куки если нет сессии
        if (isset($_COOKIE['emailUserСookie']) && isset($_COOKIE['passUserСookie'])){ //проверка данных в базе при наличии куки
            $emailCookie = $_COOKIE['emailUserСookie']; 
            $passCookie = $_COOKIE['passUserСookie'];            

           $row = $db->getAll('users');

            foreach ($row as $user) {
                if($user['email'] == $emailCookie && $user['password'] == $passCookie) {
                    $_SESSION['emailUser'] = $emailCookie;
                    $_SESSION['nameUser'] = $user['name_user'];
                }
            }
           
        }

    }
include '../mvc/views/index.view.php';    
?>
