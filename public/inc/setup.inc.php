<?php 
if (!isset($_POST['setup-submit'])):
    die('y u here hm?');
endif;

// POST variables
$admin_email = $_POST['adminemail'];
$admin_user = $_POST['adminuser'];
$admin_pass = $_POST['adminpass'];
$admin_pass_confirm = $_POST['adminpassconf'];
$bran_db_name = $_POST['dbname'];
$bran_db_user = $_POST['dbuser'];
$bran_db_pass = $_POST['dbpass'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=' . PDO_DBNAME, PDO_DBUSER, PDO_DBPASSWORD);
} catch (PDOException $e) {
    die("Shit got a bit fucked while connecting to server. Reason: $e");
}
?>