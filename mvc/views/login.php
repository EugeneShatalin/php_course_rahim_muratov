<?php
    session_start();
    include '../functions/dd.php';
    //dd($_SERVER);
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
                    <li><a href="/mvc/views/profile.php">Профиль   </a></li>
                    <li><a href="/mvc/controlers/end.php">Выход </a></li>
                    <li><a href="/mvc/views/admin.php">Админка </a></li>
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Login</div>

                            <div class="card-body">
                                <form method="POST" action="/mvc/controlers/handling-login.php">

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control 
                                            <?php 
                                            if($_SESSION['loginEmailFalse'] || $_SESSION['emailNot'] || $_SESSION['emailNoValidate']) {
                                                echo ' is-invalid'; 
                                            }
                                           ?> 
                                            " name="email"
                                            <?php
                                            if(!empty($_SESSION['email'])) {
                                                echo ' value="'.$_SESSION['email'].'"';
                                                unset($_SESSION['email']);
                                            } 
                                            ?>
                                            autocomplete="email" autofocus >
                                            <?php
                                            if($_SESSION['emailNot']) {
                                                echo '<span class="invalid-feedback" role="alert">
                                                     <strong>Введите E-mail адрес!</strong>
                                                 </span>';
                                                 unset($_SESSION['emailNot']);
                                             }
                                            if($_SESSION['loginEmailFalse']) {
                                               echo '<span class="invalid-feedback" role="alert">
                                                    <strong>Данный Email не зарегистрирован!</strong>
                                                </span>';
                                                unset($_SESSION['loginEmailFalse']);
                                            }
                                            
                                             if($_SESSION['emailNoValidate']) {
                                                echo '<span class="invalid-feedback" role="alert">
                                                     <strong>Не верный формат E-mail!</strong>
                                                 </span>';
                                                 unset($_SESSION['emailNoValidate']);
                                             }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control
                                            <?php 
                                            if($_SESSION['loginPassFalse'] || $_SESSION['passNot']) {
                                                echo ' is-invalid'; 
                                            }                                            
                                            ?> 
                                            " name="password"  autocomplete="current-password">
                                            <?php
                                            if($_SESSION['passNot']) {
                                                echo '<span class="invalid-feedback" role="alert">
                                                     <strong>Введите пароль!</strong>
                                                 </span>';
                                                 unset($_SESSION['passNot']);
                                             }
                                            if($_SESSION['loginPassFalse']) {
                                               echo '<span class="invalid-feedback" role="alert">
                                                    <strong>Не верный пароль!</strong>
                                                </span>';
                                                unset($_SESSION['loginPassFalse']);
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                               Login
                                            </button>
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
