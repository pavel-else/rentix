<?php
    session_start();
    require_once("app_config.php");

    if ($_SESSION["email"] && $_SESSION["password"]) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/rental_points.php");
    } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/nologin.php");
    }
?>