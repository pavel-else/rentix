<?php
	// Нужно сделать абс путь от корня!!
	require_once("app_config.php");

	function redirect($to, $stop = false) {
		        //Возвращаем пользователя на главную страницу
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . $to);

        if ($stop) {
        	exit();
        }
	}
?>