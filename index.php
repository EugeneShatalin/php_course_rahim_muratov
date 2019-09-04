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
    //sql запрос к БД
    $sql = "SELECT * FROM comments WHERE id > 0 ORDER BY id DESC";
    //запрос к БД
    $result = $pdo->query($sql);
    //Преобразуем то, что отдала нам база в нормальный массив PHP $comments:
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
                <a class="navbar-brand" href="index.html">
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
                            <div class="card-header"><h3>Комментарии</h3></div>

                            <div class="card-body">
                <?php
                    //Проверка наличия нового комментария, и обнулунеи переменной в сессии    
                        if ($_SESSION['newComment']) {
                            echo '<div class="alert alert-success" role="alert">
                            Комментарий успешно добавлен
                          </div>';
                          unset($_SESSION['newComment']);
                        }
                              

                    //Вывод комментариев циклом foreach         
                    foreach ($comments as $comment ) { ?>						
                                <div class="media">
                                <img src="img/no-user.jpg" class="mr-3" alt="..." width="64" height="64">
                                  <div class="media-body">
                                    <h5 class="mt-0"> 
                                        <?php echo $comment['name_user'] ?> 
                                    </h5>                                    
                                    <span><small>                
                                        <?php 
                //Выводим дату в нужно формате
                                        echo date('d/m/Y', strtotime($comment['date']));  
                                        ?>
                                    </small></span>
                                    <p>
                                        <?php echo $comment['comment'] ?>
                                    </p>
                                  </div> 
                                </div> 
                <?php } ?>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="store.php" method="post">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <input name="name" class="form-control" id="exampleFormControlTextarea1"
                                    <?php 
                                    //возвращаем введенные до этого данные
                                       if (!empty($_SESSION['name'])) {
                                           echo 'value="'.$_SESSION['name'].'"';
                                       }  
                                    ?> />
                                    <?php
                                    //Проверка заполнения данных 
                                        if ($_SESSION['nameValidation']) {
                                            echo '<p style="color: red; font-size: 14px;">Введите данные!</p>';
                                            unset($_SESSION['nameValidation']);
                                        }
                                    ?>
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                    <?php 
                                    //возвращаем введенные до этого данные
                                       if (!empty($_SESSION['text'])) {
                                           echo 'value="'.$_SESSION['text'].'"';
                                       }  
                                    ?>
                                    ></textarea>
                                    <?php
                                    //Проверка заполнения данных
                                        if ($_SESSION['textValidation']) {
                                            echo '<p style="color: red; font-size: 14px;">Введите данные!</p>';
                                            unset($_SESSION['textValidation']);
                                        }
                                    ?>
                                  </div>
                                  <button type="submit" class="btn btn-success">Отправить</button>
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
