<?php 
    session_start();
    $_SESSION["page_name"] = "nologin";

    require_once("../templates/header.php");
    require_once("../templates/nologin.php");
?>