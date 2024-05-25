<?php 
if (!isset($_POST['settings-submit'])) :
    die("File cannot be directly accessed.");
endif;
header("Location: ../settings?error=not-implemented-yet")
?>
