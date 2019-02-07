<?php 
    error_reporting(E_ALL & ~E_NOTICE);
    date_default_timezone_set('Europe/Moscow');
    
    // Указываем кодировку
    header('Content-Type: text/html; charset=utf-8');

    $address_site = "http://rentix.biz";

    $rental_host = "http://app.rentix.biz/#/";
    //$rental_host = "http://localhost:8080/";