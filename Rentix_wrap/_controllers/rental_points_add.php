<?php 
    session_start();

    require_once("../app_config.php");

    require_once("../libs/db.php");
    require_once("./getID.php");
    require_once("./isUniq.php");


    $pDB = rent_connect_DB();

        //Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
    $_SESSION["error_messages"] = '';

    //Объявляем ячейку для добавления успешных сообщений
    $_SESSION["success_messages"] = '';

    if (!isset($_POST["btn_submit_new_rental_point"]) || empty($_POST["btn_submit_new_rental_point"])) {
        exit("
            <p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. 
            Вы можете перейти на <a href=" . $address_site . "> главную страницу </a>.</p>
        ");
    }

    $name = htmlspecialchars($_POST["name"], ENT_QUOTES);
    $city = htmlspecialchars($_POST["city"], ENT_QUOTES);
    $address = htmlspecialchars($_POST["address"], ENT_QUOTES);
    $phone = htmlspecialchars($_POST["phone"], ENT_QUOTES);
    $description = htmlspecialchars($_POST["description"], ENT_QUOTES);
    $description_short = htmlspecialchars($_POST["description_short"], ENT_QUOTES);
    $id_rent = getID('rental_points');


    // Генерация унникального токена
    $generateUniqToken = function () use (&$generateUniqToken) {
        $token = md5(microtime());

        return isUniq($token, 'rental_points', 'token') ? $token : $generateUniqToken();
    };

    $token = $generateUniqToken();


    $sql = 'INSERT INTO `rental_points` (
        `id`,
        `id_rent`,
        `name`,
        `city`,
        `address`,
        `phone`,
        `description`,
        `description_short`,
        `id_rental_org`,
        `token`
    ) VALUES (
        NULL,
        :id_rent,
        :name,
        :city,
        :address,
        :phone,
        :description,
        :description_short,
        :id_rental_org,
        :token
    )';
    

    $d = array(
        'id_rent' => $id_rent,
        'name' => $name,
        'city' => $city,
        'address' => $address,
        'phone' => $phone,
        'description' => $description,
        'description_short' => $description_short,
        'id_rental_org' => $_SESSION["id_rental_org"],
        'token' => $token   
    );

    $result = $pDB->set($sql, $d);

    if (!$result) {
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавление точки проката в БД</p>";
        
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/rental_points.php");

        //Останавливаем  скрипт
        exit();
    }

    // Копируем стандартные типы ремонта
    $copyBaseRepairTypes = function() use ($pDB, $id_rent) {
        $get = function () use ($pDB) {
            $sql = '
                SELECT *
                FROM `repair_types`
                WHERE `id_rental_org` = 0
            ';
            $d = array();

            return $pDB->get($sql, 0);
        };

        $set = function ($data) use ($pDB, $id_rent) {
            if (empty($data)) {
                return false;
            }

            foreach ($data as $type) {
                $sql = 'INSERT INTO `repair_types` (
                    `id`,
                    `id_rent`,
                    `id_rental_org`,
                    `is_plan`,
                    `name`,
                    `period`,
                    `note`
                ) VALUES (
                    NULL,
                    :id_rent,
                    :id_rental_org,
                    :is_plan,
                    :name,
                    :period,
                    :note
                )';

                $d = array(
                    'id_rent' => $type["id_rent"],
                    'id_rental_org' => $id_rent,
                    'is_plan' => $type["is_plan"],
                    'name' => $type["name"],
                    'period' => $type["period"],
                    'note' => $type["note"]
                );

                $pDB->set($sql, $d);             
            }
        };

        return $set($get());
    };

    if ($result) {
        $copyBaseRepairTypes();
    }

    // Возвращаем пользователя на ту страницу, на которой он нажал на кнопку выход.
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $_SERVER["HTTP_REFERER"]);