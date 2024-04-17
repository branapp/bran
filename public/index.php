<?php 
session_start();
include "../bran-config.php";
if ($installed === false):
    header("Location: setup/installation.php");
endif;

if (!isset($_SESSION['cuid'])) :
    header("Location: ../login");
    exit();
endif;
?>