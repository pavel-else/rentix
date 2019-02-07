<?php
    //Запускаем сессию
    session_start();

    //Добавляем файл подключения к БД
    //require_once("dbconnect.php");
    require_once("../app_config.php");
    require_once("./connectToDB.php");
    require_once("./getID.php");

    $pDB = rent_connect_DB();

    //Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
    $_SESSION["error_messages"] = '';

    //Объявляем ячейку для добавления успешных сообщений
    $_SESSION["success_messages"] = '';

    /*
        Проверяем была ли отправлена форма, то есть была ли нажата кнопка зарегистрироваться. Если да, то идём дальше, если нет, значит пользователь зашёл на эту страницу напрямую. В этом случае выводим ему сообщение об ошибке.
    */
    if (!isset($_POST["btn_submit_register"]) || empty($_POST["btn_submit_register"])) {
        exit("
            <p>
                <strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки.
                Вы можете перейти на <a href=" . $address_site . "> главную страницу </a>.
            </p>
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
        header("Location: ". $address_site ."/pages/register.php");

        //Останавливаем скрипт
        exit();
    }

    /* Проверяем если в глобальном массиве $_POST существуют данные отправленные из формы и заключаем переданные данные в обычные переменные.*/
    if (!isset($_POST["first_name"])) {
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с именем</p>";

        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем скрипт
        exit();
    }
        
    //Обрезаем пробелы с начала и с конца строки
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);

    //Проверяем переменную на пустоту
    if (empty($first_name)) {
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваше имя</p>";

        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем скрипт
        exit();
    }

    // Для безопасности, преобразуем специальные символы в HTML-сущности
    $first_name = htmlspecialchars($first_name, ENT_QUOTES);
    $last_name = htmlspecialchars($last_name, ENT_QUOTES);
    
    
    if (!isset($_POST["email"])) {
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода Email</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем  скрипт
        exit();
    }

    //Обрезаем пробелы с начала и с конца строки
    $email = trim($_POST["email"]);
    if(empty($email)){
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш email</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем  скрипт
        exit();
    }

    $email = htmlspecialchars($email, ENT_QUOTES);

    // (3) Место кода для проверки формата почтового адреса и его уникальности

    //Проверяем формат полученного почтового адреса с помощью регулярного выражения
    $reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";

    //Если формат полученного почтового адреса не соответствует регулярному выражению
    if (!preg_match($reg_email, $email)) {
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Вы ввели неправельный email</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем  скрипт
        exit();
    }


    //Проверяем нет ли уже такого адреса в БД.

    $sql = "
        SELECT `email` 
        FROM `users` 
        WHERE `email` = :email

    ";
    $d = array (
        'email' => $email
    );

    $result = $pDB->get($sql, false, $d);

    if (count($result) > 0) {
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Пользователь с таким почтовым адресом уже зарегистрирован</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");
    }
        

    if(!isset($_POST["password"])){
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода пароля</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем  скрипт
        exit();
    }

    //Обрезаем пробелы с начала и с конца строки
    $password = trim($_POST["password"]);

    if (empty($password)){
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш пароль</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем  скрипт
        exit();
    }

    $password = htmlspecialchars($password, ENT_QUOTES);

    //Шифруем папроль
    $password = md5($password . "top_secret");

    // Выбираем свободный ID организации
    $id_rental_org = getID('users', 'id_rental_org', function ($id) { return $id + 3; });

    // (4) Место для кода добавления пользователя в БД

    //Запрос на добавления пользователя в БД
    $sql = 'INSERT INTO `users` (
        `id`,
        `first_name`,
        `last_name`,
        `email`,
        `email_status`,
        `password`,
        `id_rental_org`
    ) VALUES (
        NULL,
        :first_name,
        :last_name,
        :email,
        :email_status,
        :password,
        :id_rental_org
    )';
    
    $d = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'email_status' => 'not confirmed',
        'password' => $password,
        'id_rental_org' => $id_rental_org
    );

    $result = $pDB->set($sql, $d);

    if (!$result){
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавление пользователя</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/register.php");

        //Останавливаем  скрипт
        exit();
    }

    // сохраняем логин и пароль в массив сессий.
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['id_rental_org'] = $id_rental_org;

    //Возвращаем пользователя на главную страницу
    // или на следуюшую сьраницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $address_site . "/index.php");
?>