<?php 
session_start();
include "../bran-config.php";
if ($installed === false):
    header("Location: setup/installation.php");
else:
    if(!defined($_SESSION['cuid'])):
        header("Location: login");
    endif;
endif;
?>