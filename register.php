<?php 
    session_start();   
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
                                <a class="nav-link" href="login.html">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.html">Register</a>
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
                            <div class="card-header">Register</div>

                            <div class="card-body">
                                <form method="POST" action="handling_register.php">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') 
                                            <?php 
                                            if($_SESSION['nameRegisterFalse']) {
                                                echo 'is-invalid'; 
                                            }                                            
                                            ?>
                                            @enderror" name="name" 
                                            <?php
                                            //возвращаем введенные до этого данные
                                            if (!empty($_SESSION['nameSave'])) {
                                                echo 'value="'.$_SESSION['nameSave'].'"';
                                                unset($_SESSION['nameSave']);
                                            } ?>  >
                                            <?php
                                            if($_SESSION['nameRegisterFalse']) {
                                               echo '<span class="invalid-feedback" role="alert">
                                                    <strong>Заполните поле!</strong>
                                                </span>';
                                                unset($_SESSION['nameRegisterFalse']);
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control
                                            <?php 
                                            if($_SESSION['emailNoValidate'] || $_SESSION['emailRegisterFalse']) {
                                                echo 'is-invalid'; 
                                            }
                                            ?>
                                            " name="email" <?php
                                            //возвращаем введенные до этого данные
                                            if (!empty($_SESSION['emailSave'])) {
                                                echo 'value="'.$_SESSION['emailSave'].'"';
                                                unset($_SESSION['emailSave']);
                                            } ?> >
                                            <?php
                                            if($_SESSION['emailRegisterFalse']) {
                                               echo '<span class="invalid-feedback" role="alert">
                                                    <strong>Введите e-mail адрес!</strong>
                                                </span>';
                                                unset($_SESSION['emailRegisterFalse']);
                                                unset($_SESSION['emailNoValidate']);
                                            }
                                            elseif ($_SESSION['emailNoValidate']) {
                                                echo '<span class="invalid-feedback" role="alert"><strong>Неверный формат E-mail!</strong></span>';
                                                unset($_SESSION['emailNoValidate']);
                                                unset($_SESSION['emailRegisterFalse']);
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control 
                                            <?php 
                                            if($_SESSION['passRegisterFalse'] || $_SESSION['falsPassLength'] || $_SESSION['falsPassSame']) {
                                                echo 'is-invalid'; 
                                            }
                                            ?>
                                            " name="password"  autocomplete="new-password">
                                            <?php
                                            if($_SESSION['passRegisterFalse']) {
                                               echo '<span class="invalid-feedback" role="alert">
                                                    <strong>Заполните поле!</strong>
                                                </span>';
                                                unset($_SESSION['passRegisterFalse']);
                                            }
                                            if($_SESSION['falsPassLength']) {
                                                echo '<span class="invalid-feedback" role="alert">
                                                     <strong>В пароле дожно быть не менее 8 символов!</strong>
                                                 </span>';                                                 
                                             }
                                             if($_SESSION['falsPassSame']) {
                                                echo '<span class="invalid-feedback" role="alert">
                                                     <strong>Значения полей не совпадают!</strong>
                                                 </span>';                                                
                                             }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control
                                            <?php 
                                            if($_SESSION['cofPassRegisterFalse'] || $_SESSION['falsPassLength'] || $_SESSION['falsPassSame']) {
                                                echo 'is-invalid';
                                                unset($_SESSION['falsPassLength']);
                                                unset($_SESSION['falsPassSame']); 
                                            }
                                            ?>
                                            " name="password_confirmation"  autocomplete="new-password">
                                            <?php
                                            if($_SESSION['cofPassRegisterFalse']) {
                                               echo '<span class="invalid-feedback" role="alert">
                                                    <strong>Заполните поле!</strong>
                                                </span>';
                                                unset($_SESSION['cofPassRegisterFalse']);
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Register
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
