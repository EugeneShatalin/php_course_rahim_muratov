<?php
//Запуск сессии
    session_start();
    
    $db = include  __DIR__ . '/../models/start.php';
    $comments = $db->getDataFromTwoTables_DESC('users', 'comments', 'id', 'id_user');
    
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
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
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
                                                        echo " /"."img/".$comment['image'];
                                                    }
                                                    else {
                                                        echo " /"."/img/no-user.jpg";
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
                                            <a href="/mvc/controlers/handling_admin.php/?comment=true&id_comment=<?php echo $comment['id']; ?>
                                            " class="btn btn-success">Разрешить</a>
                                                    <?php } ?>
                                                <?php
                                                    if($comment['do_not_show_comment'] == false) {
                                                ?>   
                                            <a href="/mvc/controlers/handling_admin.php/?comment=false&id_comment=<?php echo $comment['id']; ?>
                                            " class="btn btn-warning">Запретить</a>
                                            <?php } ?>
                                            <a href="/mvc/controlers/handling_admin.php/?comment=delet&id_comment=<?php echo $comment['id']; ?>
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
