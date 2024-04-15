<?php
session_start();
if (!isset($_SESSION['cuid'])) :
    header("Location: ../login");
    exit();
endif;

include "../assets/templates/header.php";
?>
    <a class="nav-link" aria-current="page" href="../inc/logout.inc.php">Sign out</a>
<p>sex</p>