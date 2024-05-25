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
    exit;
else:
    if(isset($_SESSION['cuid'])):
        header("Location: login");
        exit;
    endif;
endif;
header("Location: login");
include "assets/templates/header.php";
?>
<div class="d-flex align-items-center justify-content-center">
    <img src="../assets/img/bran.png" alt="bran" class="logo">
</div>
<h1 class="text-header text-center">nothing to see here yet...</h1>