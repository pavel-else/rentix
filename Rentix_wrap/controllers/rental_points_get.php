<?php 

    require_once("../app_config.php");

    require_once("../libs/db.php");


    $pDB = rent_connect_DB();

    session_start();

    $sql = '
        SELECT * 
        FROM `rental_points` 
        WHERE `id_rental_org` = :id_rental_org
    ';
    
    $d = array(
        'id_rental_org' => $_SESSION["id_rental_org"]     
    );

    $rental_points = $pDB->get($sql, 0, $d);
