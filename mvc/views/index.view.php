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
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/index.php">
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
                    <li><a href="/profile">Профиль   </a></li>
                    <li><a href="/mvc/controlers/end.php">Выход </a></li>
                    <li><a href="/admin">Админка </a></li>
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
                                <a class="nav-link" href="/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register">Register</a>
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
                    //Проверка наличия нового комментария, при обнулунеи переменной в сессии    
                        if ($_SESSION['newComment']) {
                            echo '<div class="alert alert-success" role="alert">
                            Комментарий успешно добавлен
                          </div>';
                          unset($_SESSION['newComment']);
                        }
                              

                    //Вывод комментариев циклом foreach         
                    foreach ($row as $comment ) {
                        // Проверяем что комментарий существует для данного пользователя, так как данные берем из двух таблиц, чтоб не вывести пустой комментарий
                        if(!empty($comment['comment']) && $comment['do_not_show_comment'] == false) {?>						
                                <div class="media">
                                <img src="
                                <?php // выводим картинку
                                    $id = $comment['id'];
                                    
                                   if($comment['image'] != NULL) { // если картинка существует выведим ее
                                       echo '/'.'img/'.$comment['image'];
                                   }
                                   else {
                                    echo '/'.'img/no-user.jpg'; // если не существует, выведим заглушку
                                   }
                                    
                                ?>
                                "                          
                                class="mr-3" alt="..." width="64" height="64">
                                  <div class="media-body">
                                    <h5 class="mt-0"> 
                                        <?php 
                                        echo $comment['name_user']; ?>
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
                <?php } }?>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12" style="margin-top: 20px; <?php
                                                                        if(empty($_SESSION['idUser'])) {
                                                                            echo 'display: none;';
                                                                        }
                                                                    ?> ">
                        <div class="card" display = "none">
                            <div class="card-header" display = "none"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="/mvc/controers/store.php" method="post">
                                    <div class="form-group" 
                                    <?php //убираем данный элемент со страницы если авторизован пользователь
                                    if($_SESSION['idUser']) {
                                        echo 'style="display: none;"';
                                    }
                                    ?>>
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <input name="idUser" class="form-control" id="exampleFormControlTextarea1"
                                    <?php
                                    //Передаем id пользователя в строку
                                    if($_SESSION['idUser']) {
                                        echo 'value="'.$_SESSION['idUser'].'"';
                                    }                                    
                                    ?> />
                                   
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    <?php
                                    //Проверка заполнения данных
                                        if ($_SESSION['textValidation']) {
                                            echo '<p style="color: red; font-size: 14px;">Введите комментарий!</p>';
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