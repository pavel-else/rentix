<?php
    session_start();
    require_once("../app_config.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Админка проката</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <!-- <link rel="stylesheet" type="text/css" href="../css/coreui.css"> -->
        <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
       
        <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
        
        
        <script type="text/javascript">
            $(document).ready(function(){
                "use strict";
                //================ Проверка email ==================

                //регулярное выражение для проверки email
                var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;
                var mail = $('input[name=email]');
                
                mail.blur(function(){
                    if(mail.val() != ''){

                        // Проверяем, если введенный email соответствует регулярному выражению
                        if(mail.val().search(pattern) == 0){
                            // Убираем сообщение об ошибке
                            $('#valid_email_message').text('');

                            //Активируем кнопку отправки
                            $('input[type=submit]').attr('disabled', false);
                        }else{
                            //Выводим сообщение об ошибке
                            $('#valid_email_message').text('Не правильный Email');

                            // Дезактивируем кнопку отправки
                            $('input[type=submit]').attr('disabled', true);
                        }
                    }else{
                        $('#valid_email_message').text('Введите Ваш email');
                    }
                });

                //================ Проверка длины пароля ==================
                var password = $('input[name=password]');
                
                password.blur(function(){
                    if(password.val() != ''){

                        //Если длина введенного пароля меньше шести символов, то выводим сообщение об ошибке
                        if(password.val().length < 6){
                            //Выводим сообщение об ошибке
                            $('#valid_password_message').text('Минимальная длина пароля 6 символов');

                            // Дезактивируем кнопку отправки
                            $('input[type=submit]').attr('disabled', true);
                            
                        } else {
                            // Убираем сообщение об ошибке
                            $('#valid_password_message').text('');

                            //Активируем кнопку отправки
                            $('input[type=submit]').attr('disabled', false);
                        }
                    } else {
                        $('#valid_password_message').text('Введите пароль');
                    }
                });
            });
        </script>
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <div class="app-blur"></div>
        <header class="app-header navbar">
            <a class="navbar-brand" href="../index.php">
                <span class="app-logo"><span class="first-letter">R</span>entix</span> 
            <!-- <img class="navbar-brand-full" src="../img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
                <img class="navbar-brand-minimized" src="../img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo"> -->
            </a>

            <!-- Если пользователь залогинен выводим рабочий контент -->
            <?php if ($_SESSION["email"] && $_SESSION["password"]) { ?>
                <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
                    <span class="navbar-toggler-icon"></span>
                </button>
<!--                 <ul class="nav navbar-nav d-md-down-none">
                    <li class="nav-item px-3">
                      <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item px-3">
                      <a class="nav-link" href="#">Users</a>
                    </li>
                    <li class="nav-item px-3">
                      <a class="nav-link" href="#">Settings</a>
                    </li>
                </ul> -->
                <ul class="nav navbar-nav ml-auto">
<!--                     <li class="nav-item d-md-down-none">
                      <a class="nav-link" href="#">
                        <i class="icon-bell"></i>
                        <span class="badge badge-pill badge-danger">5</span>
                      </a>
                    </li>
                    <li class="nav-item d-md-down-none">
                        <a class="nav-link" href="#">
                            <i class="icon-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-md-down-none">
                        <a class="nav-link" href="#">
                            <i class="icon-location-pin"></i>
                        </a>
                    </li> -->
                    <li class="nav-item dropdown">
                      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <!-- <img class="img-avatar" src="img/avatars/6.jpg" alt="admin@bootstrapmaster.com"> -->
                        <span><? echo $_SESSION["email"] ?></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                          <strong>Settings</strong>
                        </div>
                       <!--  <a class="dropdown-item" href="#">
                          <i class="fa fa-user"></i> Profile</a>
                        <a class="dropdown-item" href="#">
                          <i class="fa fa-wrench"></i> Settings</a>
                        <a class="dropdown-item" href="#">
                          <i class="fa fa-usd"></i> Payments
                          <span class="badge badge-secondary">42</span>
                        </a>
                        <a class="dropdown-item" href="#">
                          <i class="fa fa-file"></i> Projects
                          <span class="badge badge-primary">42</span>
                        </a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../controllers/logout.php">
                          <i class="fa fa-lock"></i> Выход</a>
                      </div>
                    </li>
                </ul>
                <div class="navbar-toggler aside-menu-toggler d-md-down-none" style="cursor: default;">
                    <!-- заглушка -->
                </div>
            
            <!-- Иначе выводим лэндинг -->
            <?php } else { ?>
                <ul class="nav navbar-nav ml-auto nav-login">
                    <li class="nav-item d-md-down-none">
                        <button class="navbar-toggler asside-menu-toggler d-md-down-none">
                            <a href="./auth.php">Логин</a>
                        </button>
                    </li>
                    <li class="nav-item d-md-down-none">
                        <button class="navbar-toggler asside-menu-toggler d-md-down-none">
                            <a href="./register.php">Регистрация</a>
                        </button>
                    </li>
                </ul>
            <?php } ?>
        </header>

        <div class="app-body">
            <!-- Далее подключается нужная страница --> 