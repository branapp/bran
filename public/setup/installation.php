<?php 
    include("../assets/templates/header.php");
    
    if ($installed == true):
        header("Location: ../login");
    endif;
?>
