<?php
include($_SERVER['DOCUMENT_ROOT'] . '/assets/templates/header.php');
if(!isset($_SESSION['cuid'])):
    header("Location: ../login");
endif;
if (isset($_SESSION['cuid'])) :
    if($_SESSION['cuid_role'] !== 'admin'): // Modified this line
        header("Location: ../dashboard");
    endif;
endif;
?>
