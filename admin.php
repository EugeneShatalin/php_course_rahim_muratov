<?php
//Запуск сессии
    session_start();
    //Подключение к БД        
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
    // SQL запрос
    $sql = "SELECT users.name_user, users.image, comments.comment, comments.date, comments.do_not_show_comment, comments.id FROM users LEFT JOIN comments  ON users.id=comments.id_user ORDER BY date DESC";
    // Отправка SQL запроса
    $result = $pdo->query($sql);
    // Перобразовываем данные из БД
    for ($comments = []; $row = $result->fetch(PDO::FETCH_ASSOC); $comments[] = $row);
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Админ панель</h3></div>

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach($comments as $comment) {
                                            if (!empty($comment['comment'])) { 
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="
                                                <?php // картинка пользователя
                                                    if(!empty($comment['image'])) {
                                                        echo "img/".$comment['image'];
                                                    }
                                                    else {
                                                        echo "img/no-user.jpg";
                                                    }
                                                ?>
                                                " alt="" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td>
                                                <?php
                                                    echo $comment['comment'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo date('d/m/Y', strtotime($comment['date']));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $comment['comment'];
                                                ?>
                                            </td>
                                            <td>
                                               <?php 
                                                    if($comment['do_not_show_comment'] == true) {
                                                ?>
                                            <a href="handling_admin.php/?comment=true&id_comment=<?php echo $comment['id']; ?>
                                            " class="btn btn-success">Разрешить</a>
                                                    <?php } ?>
                                                <?php
                                                    if($comment['do_not_show_comment'] == false) {
                                                ?>   
                                            <a href="handling_admin.php/?comment=false&id_comment=<?php echo $comment['id']; ?>
                                            " class="btn btn-warning">Запретить</a>
                                            <?php } ?>
                                            <a href="handling_admin.php/?comment=delet&id_comment=<?php echo $comment['id']; ?>
                                            " onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
                                                    <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
