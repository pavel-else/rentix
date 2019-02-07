<?php 
    function deletePoint($id_rent) {
        require_once("./connectToDB.php");

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

        $delete = function ($id) use ($pDB) {
            $sql = '
                DELETE FROM `rental_points` 
                WHERE `id` = :id
            ';

            $d = array(
                'id' => $id
            );

            return $pDB->set($sql, $d);
        };

        return $delete($searchID($id_rent));        
    }

    if ($_GET["id"]) {
        deletePoint($_GET["id"]);
    }

    // Возвращаем пользователя на ту страницу, на которой он нажал на кнопку выход.
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $_SERVER["HTTP_REFERER"]);
?>