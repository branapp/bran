<?php 
$config_location = $_SERVER['DOCUMENT_ROOT'] . "/../bran-config.php";
if (file_exists($config_location)):
    if (filesize($config_location) > 0):
        include "$config_location";
    else:
        header("Location: setup/installation.php");
        exit;
    endif;
else:
    header("Location: setup/installation.php");
    exit;
endif;
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