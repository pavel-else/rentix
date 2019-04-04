<?php 
require_once("../app_config.php");
    session_start();
    $_SESSION["page_name"] = "rental_point_once";

    if ($_SESSION["email"] && $_SESSION["password"]) {
        $id = $_GET['id'];

    	require_once("../app_config.php");

	    require_once("../templates/header.php");
	 	require_once("../templates/sidebar.php");

		require_once("../templates/rental_point_once.php");

		require_once("../templates/footer.php");
	} else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $address_site . "/pages/nologin.php");
	}
?>