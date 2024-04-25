<?php
session_start();
if (!isset($_SESSION['cuid'])) :
    header("Location: ../login");
    exit();
endif;

include "../assets/templates/header.php";
?>