<?php
    //Запускаем сессию
    session_start();

    require_once("../app_config.php");
    //Добавляем файл подключения к БД
    require_once("../libs/db.php");
    //require_once("./functions/redirect.php");

    $pDB = rent_connect_DB();

    //Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
    $_SESSION["error_messages"] = '';

    //Объявляем ячейку для добавления успешных сообщений
    $_SESSION["success_messages"] = '';


    /*
        Проверяем была ли отправлена форма, то есть была ли нажата кнопка Войти. Если да, то идём дальше, если нет, значит пользователь зашел на эту страницу напрямую. В этом случае выводим ему сообщение об ошибке.
    */
    if (!isset($_POST["btn_submit_auth"]) || empty($_POST["btn_submit_auth"])) {
        exit("
            <p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. 
            Вы можете перейти на <a href=" . $address_site . "> главную страницу </a>.</p>
        ");
    }

    //Проверяем полученную капчу
    //Обрезаем пробелы с начала и с конца строки
    $captcha = trim($_POST["captcha"]);
    if (!isset($_POST["captcha"]) || empty($captcha)) {
        //Если капча не передана либо оно является пустой
        exit("
            <p><strong>Ошибка!</strong> Отсутствует проверечный код, то есть код капчи.
            Вы можете перейти на <a href=" . $address_site . "> главную страницу </a>.
            </p>
        ");
    }

    //Сравниваем полученное значение с значением из сессии. 
    if (($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")) {
        
        // Если капча не верна, то возвращаем пользователя на страницу регистрации, и там выведем ему сообщение об ошибке что он ввёл неправильную капчу.
        $error_message = "
            <p class='mesage_error'><strong>Ошибка!</strong> Вы ввели неправильную капчу </p>
        ";

        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] = $error_message;

        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ". $address_site ."/pages/auth.php");

        //Останавливаем скрипт
        exit();
    }



    //(2) Место для обработки почтового адреса

    if (!isset($_POST["email"])) {
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода Email</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/auth.php");

        //Останавливаем  скрипт
        exit();
    }

    //Обрезаем пробелы с начала и с конца строки
    $email = trim($_POST["email"]);

    if (empty($email)){
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш email</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/auth.php");

        //Останавливаем  скрипт
        exit();
    }

    $email = htmlspecialchars($email, ENT_QUOTES);

    
    //Обрезаем пробелы с начала и с конца строки
    $password = trim($_POST["password"]);

    if (empty($password)){
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш пароль</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/auth.php");

        //Останавливаем  скрипт
        exit();
    }

    $password = htmlspecialchars($password, ENT_QUOTES);

    //Шифруем папроль
    $password = md5($password . "top_secret");


    // (4) Место для составления запроса к БД
    // Запрос в БД на выборке пользователя.
    $sql = '
        SELECT *
        FROM `users` 
        WHERE `email` = :email
        AND `password` = :password
    ';
    $d = array(
        'email' => $email,
        'password' => $password
    );

    $result = $pDB->get($sql, false, $d);

    if (!$result) {
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Не верный логин или пароль</p>";
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/auth.php");
        exit();
    }

    // Проверяем, если в базе есть пользователь с такими данными, то сохраняем данные пользователя в сессии
    if (count($result) > 0) {

        // Если введенные данные совпадают с данными из базы, то сохраняем логин и пароль в массив сессий.
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['id_rental_org'] = $result[0]["id_rental_org"];

        //Возвращаем пользователя на главную страницу
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/index.php");

    } else {
        
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Неправильный логин и/или пароль</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/auth.php");

        //Останавливаем скрипт
        exit();
    }
