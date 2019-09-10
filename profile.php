<?php
    session_start();
    $idUser = $_SESSION['idUser'];
    $emailUser = $_SESSION['emailUser'];    
    
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
    //sql запрос к БД
    $sql = "SELECT name_user, password, image FROM users WHERE id = $idUser";
    //запрос к БД
    $result = $pdo->query($sql);
    
    //Преобразуем то, что отдала нам база в нормальный массив PHP $comments:
    for ($userDate = []; $row = $result->fetch(PDO::FETCH_ASSOC); $userDate[] = $row);
    // Передаем в переменные не дастающие данные пользователя
    
    foreach ($userDate as $user) {
            $nameUser = $user['name_user'];
            $passwordUser = $user['password'];
            $imageUser = $user['image']; 
    }
    
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
                    <ul class="navbar-nav ml-auto" <?php //убираем данный элемент со страницы если не авторизован пользователь
                                    if(empty($_SESSION['idUser'])) {
                                        echo 'style="display: none;"';
                                    }
                                    ?>>
                    <?php 
                    if($_SESSION['nameUser']) {
                        echo $_SESSION['nameUser'];
                    }
                    ?> 
                    <li><a href="profile.php">Профиль   </a></li>
                    <li><a href="end.php">Выход </a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" 
                    <?php //убираем данный элемент со страницы если авторизован пользователь
                                    if($_SESSION['idUser']) {
                                        echo 'style="display: none;"';
                                    }
                                    ?>
                    >
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
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
                        <?php
                            if(!empty( $_SESSION['updatePassword'])) {
                             echo '<div class="alert alert-success" role="alert">Профиль успешно обновлен</div>';
                             unset( $_SESSION['updatePassword']);                             
                            }
                        ?>
                            <form action="handling_profile.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php
                                                    echo $nameUser;
                                                ?>">
                                           
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="email" class="form-control 
                                            <?php
                                                if($_SESSION['duplicateEmail'] || $_SESSION['emailFormatFalse'])    echo ' is-invalid';                                           
                                            ?>" name="email" id="exampleFormControlInput1" value="<?php
                                                    echo $emailUser;
                                                ?>">
                                            <?php
                                                if($_SESSION['emailFormatFalse']) {
                                                    echo '<span class="text text-danger">Ошибка валидации</span>';
                                                    unset($_SESSION['emailFormatFalse']);
                                                }
                                                if($_SESSION['duplicateEmail']) {
                                                    echo '<span class="text text-danger">Этот email уже занят!</span>';
                                                    unset($_SESSION['duplicateEmail']);
                                                }
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="
                                        <?php // выводим картинку
                                           echo "img/".$imageUser;
                                        ?>
                                        " alt="" class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-warning" name="updateProfile">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">
                            <?php
                            if(!empty( $_SESSION['update'])) {
                             echo '<div class="alert alert-success" role="alert">Пароль успешно обновлен</div>';
                             unset( $_SESSION['update']);                             
                            }
                            ?>
                            <form action="handling_profile.php" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Current password</label>
                                            <input type="password" name="current" class="form-control" id="exampleFormControlInput1">
                                        </div>
                                        <?php
                                        if($_SESSION['passwordFalse']) {
                                                    echo '<span class="text text-danger">Не верный пароль!</span>';
                                                    unset($_SESSION['passwordFalse']);
                                                }
                                        ?>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New password</label>
                                            <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
                                        </div>
                                        <?php
                                        if($_SESSION['passwordLengthFals']) {
                                                    echo '<span class="text text-danger">Должно быть не менее 8 символов!</span>';
                                                    unset($_SESSION['passwordLengthFals']);
                                                }
                                        if($_SESSION['passwordConfirmationFalse']) {
                                            echo '<span class="text text-danger">Пароли не совпадают!</span>';
                                            unset($_SESSION['passwordConfirmationFalse']);
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <button class="btn btn-success" name="updatePassword">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>
</body>
</html>
