<?php 
$config_location = $_SERVER['DOCUMENT_ROOT'] . "/../bran-config.php";
include "$config_location";
// ensure if no config file, go to setup
session_start();
if ($installed === false):
    header("Location: setup/installation.php");
else:
    if(!defined($_SESSION['cuid'])):
        header("Location: login");
    endif;
endif;
?>