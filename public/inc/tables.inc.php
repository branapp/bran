<?php     
// Set the error mode to PDO::ERRMODE_EXCEPTION
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create the users table
$query = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email TINYTEXT NOT NULL,
    username VARCHAR(32) NOT NULL,
    password TINYTEXT NOT NULL,
    user_join TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role TINYTEXT,
    PRIMARY KEY (id)
);";

$pdo->exec($query);

// Create the user_data table
$query = "CREATE TABLE IF NOT EXISTS user_data (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    nickname VARCHAR(32),
    pfp_path VARCHAR(255) DEFAULT NULL,
    bran_total INT(11) DEFAULT 0,
    bran_daily INT(11) DEFAULT 500,
    theme ENUM('light', 'dark', 'system') DEFAULT 'system',
    theme_accent VARCHAR(7),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);";

$pdo->exec($query);

// create bran_options table and set default values
$query = "CREATE TABLE IF NOT EXISTS bran_options (
    option_name VARCHAR(255) NOT NULL,
    option_value VARCHAR(255) NOT NULL,
    PRIMARY KEY (option_name)
);";

$pdo->exec($query);

$query = "INSERT INTO bran_options (option_name, option_value) VALUES ('motd', 'welcome to bran'),
('user_registration', 'enabled');";

$pdo->exec($query);

// Insert the user data into the users table
$query = "INSERT INTO users (email, username, password, role)
          VALUES (:email, :username, :password, :role);";
$stmt = $pdo->prepare($query);

// Hash the password before binding it
$password = password_hash($post_vars['adminpass'], PASSWORD_DEFAULT);

$stmt->bindParam(':email', $post_vars['adminemail'], PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR); // Now the hashed password is bound
$stmt->bindParam(':role', $role, PDO::PARAM_STR); // Assuming $role is set to 'admin' beforehand
$stmt->bindParam(':username', $post_vars['adminuser'], PDO::PARAM_STR);