<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

include 'config.php'; 

session_start();
if($_SESSION["is_logged"] != 'true'){  
  Header("Location: sign-in.php");exit;
}else{
	  Header("Location: list.php");exit;
}

?>
