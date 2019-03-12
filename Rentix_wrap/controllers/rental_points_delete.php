<?php 
    function deletePoint($id_rent) {
        require_once("../libs/db.php");

        // Сессия для id_rental_org
        session_start();

        $pDB = rent_connect_DB();

        // Функция поиска глобального ID по id_rent относящегося к конкретной организации
        $searchID = function ($id_rent) use ($pDB) {
            $sql = '
                SELECT `id` 
                FROM `rental_points`
                WHERE `id_rental_org` = :id_rental_org 
                AND `id_rent`        = :id_rent
            ';

            $d = array(
                'id_rent'      => $id_rent,
                'id_rental_org' => $_SESSION["id_rental_org"]
            );

            $result = $pDB->get($sql, 0, $d);

            return $result[0][id];
        };

        $delete = function ($id_rent) use ($pDB) {
            $tableNames = [
                'accessories',
                'categories',
                'customers',
                'generall_settings',
                'orders',
                'order_products',
                'products',
                'rental_points',
                'repairs',
                'repair_types',
                'tariffs'
            ];

            // Удаляем все записи с этим id_rent из всех таблиц
            array_map(function ($item) use ($id_rent, $pDB) {
                $sql = "
                    DELETE FROM $item 
                    WHERE `id_rental_org` = :id_rental_org
                ";
                $d = array(
                    'id_rental_org' => $id_rent
                );
                $pDB->set($sql, $d);                
            }, $tableNames);

            // Удалям саму точку проката
            $sql = '
                DELETE FROM `rental_points` 
                WHERE `id_rent` = :id_rent
            ';

            $d = array(
                'id_rent' => $id_rent
            );

            return $pDB->set($sql, $d);
        };

        return $delete($id_rent);        
    }

    if ($_GET["id"]) {
        deletePoint($_GET["id"]);
    }

    // Возвращаем пользователя на ту страницу, на которой он нажал на кнопку выход.
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $_SERVER["HTTP_REFERER"]);
