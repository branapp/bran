<?php 
include "../bran-config.php";

if ($installed == false):
    header("Location: setup/installation.php");
else:
    if (!isset($_SESSION['uid'])):
        header("Location: login");
        die();
    endif;
endif;
?>