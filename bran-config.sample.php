<?php 
/**
 * You are viewing the bran-config.php file.
 * THIS INFORMATION IS SENSITIVE. KEEP IT SAFE
 */

/* root directory of bran */
define('BASE_BATH', __DIR__."/public" );

/* bran sql database name */
define('PDO_DBNAME', 'brandb');

/* bran sql database username */
define('PDO_DBUSER', 'admin');

/* bran sql database password */
define('PDO_DBPASSWORD', 'admin');

/**
 * determine whether bran is installed.
 * WARNING: DO NOT MANUALLY SET TRUE DURING SETUP
 */
$installed = false;
/* you were warned...  */

/** enable or disable user registration */
$user_registration_enabled = true;
?>