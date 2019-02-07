<?php 
    error_reporting(E_ALL & ~E_NOTICE);
    date_default_timezone_set('Europe/Moscow');
    
    // Указываем кодировку
    header('Content-Type: text/html; charset=utf-8');

    $address_site = "https://rentix.biz";

    // Расположение приложения точки проката
    //
    //$rental_host = "https://app.rentix.biz/#/";
    $rental_host = "http://localhost:8080/"; 