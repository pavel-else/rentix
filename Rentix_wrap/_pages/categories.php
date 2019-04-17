<?php 
require_once("../app_config.php");
    session_start();
    $_SESSION["page_name"] = "categories";

    if ($_SESSION["email"] && $_SESSION["password"]) {
    	// require_once("../controllers/rental_points_get.php"); // Проброс $rental_points в templates/rental_points.php
    	require_once("../app_config.php");

	    require_once("../templates/header.php");
	 	require_once("../templates/sidebar.php");
		require_once("../templates/rental_points.php");
		require_once("../templates/footer.php");
	} else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/nologin.php");
	}
