<?php
include "../../bran-config.php";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=' . PDO_DBNAME, PDO_DBUSER, PDO_DBPASSWORD);
} catch (PDOException $e) {
    die("Shit got a bit fucked while connecting to server. Reason: $e");
}