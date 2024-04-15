<?php
session_start(); // Start or resume the session

if (isset($_SESSION['cuid'])) :
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    header("Location: ../login");
    exit();
else :
    header("Location: ../login");
    exit();
endif;
