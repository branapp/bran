<?php 
if(!file_exists("../bran-config.php")):
    header("Location: setup/installation.php");
endif;
include "../bran-config.php";
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