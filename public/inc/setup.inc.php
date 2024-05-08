<?php

function update_bran_config($post_vars) {
    $config_file_path = $_SERVER['DOCUMENT_ROOT'] . "/../bran-config.php";
    // Template for the config content
    $config_content = "<?php 
/**
 * You are viewing the bran-config.php file.
 * THIS INFORMATION IS SENSITIVE. KEEP IT SAFE
 */

/* root directory of bran */
define('BASE_PATH', __DIR__.'/public' );

/* bran sql database name */
define('PDO_DBNAME', '{$post_vars['dbname']}');

/* bran sql database username */
define('PDO_DBUSER', '{$post_vars['dbuser']}');

/* bran sql database password */
define('PDO_DBPASSWORD', '{$post_vars['dbpass']}');

/**
 * determine whether bran is installed.
 * WARNING: DO NOT MANUALLY SET TRUE DURING SETUP
 */
\$installed = true;
/* you were warned...  */
?>";

    // Check if the file exists before writing
    if (!file_exists($config_file_path)):
        // Attempt to write the content to the new file
        $write_success = file_put_contents($config_file_path, $config_content);

        if ($write_success === false):
            // Handle the error, for example: log it, display an error message, etc.
            throw new Exception("Failed to create the configuration file.");
        endif;
    else:
        // If the file exists, overwrite it.
        $write_success = file_put_contents($config_file_path, $config_content, LOCK_EX);

        if ($write_success === false):
            // Handle the error, for example: log it, display an error message, etc.
            throw new Exception("Failed to overwrite the configuration file.");
        endif;
    endif;
}

if (isset($_POST['setup-submit'])) {
    $post_vars = array(
        'adminemail' => $_POST['adminemail'],
        'adminuser' => $_POST['adminuser'],
        'adminpass' => $_POST['adminpass'],
        'adminpassconf' => $_POST['adminpassconf'],
        'dbname' => $_POST['dbname'],
        'dbuser' => $_POST['dbuser'],
        'dbpass' => $_POST['dbpass'],
    );

    $errors = [];

    foreach ($post_vars as $key => $value) {
        if (empty($value)):
            $errors[] = 'emptyFields';
            break;
        endif;
    }

    if (empty($errors)) {
        foreach ($post_vars as $key => $value) {
            if ($key == 'adminuser' && !preg_match("/^[a-zA-Z0-9_.-]{3,20}$/", $value)) {
                // Catch bad username
                $errors[] = 'regexError';
                break;
            }

            if ($key == 'adminemail' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                // Catch invalid email
                $errors[] = 'invalidEmail';
                break;
            }

            if ($key == 'adminpass' && $post_vars['adminpass'] !== $post_vars['adminpassconf']) {
                // Catch password mismatch
                $errors[] = 'passwordMismatch';
                break;
            }
        }
    }

    if (empty($errors)) {
        function bran_setup($post_vars) {
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=' . $post_vars['dbname'], $post_vars['dbuser'], $post_vars['dbpass']);
        
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
                    bran_total INT(11) DEFAULT 500,
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
        
                $email = filter_var($post_vars['adminemail'], FILTER_SANITIZE_EMAIL);
                $role = 'admin';
        
                // Execute the statement
                $stmt->execute();
        
                // Get the last inserted ID (the user_id for the new user)
                $lastUserId = $pdo->lastInsertId();
        
                // Insert a row into the user_data table for the new user
                $query = "INSERT INTO user_data (user_id, theme_accent)
                          VALUES (:user_id, :theme_accent);";
                $stmt = $pdo->prepare($query);
        
                $stmt->bindParam(':user_id', $lastUserId, PDO::PARAM_INT);
                $stmt->bindParam(':theme_accent', $theme_accent, PDO::PARAM_STR);
        
                $theme_accent = NULL; // Set the default theme_accent
        
                // Execute the statement
                $stmt->execute();
            } catch (PDOException $e) {
                // Handle the error, for example: log it, display an error message, etc.
                echo "Error: " . $e->getMessage();
            }
            /**
             * @todo add try catch for bran_config
             */
            update_bran_config($post_vars);
            // if success, redirect to login page
            header("Location: ../login?install=success");
        }
        // begin setup
        bran_setup($post_vars);
    } else {
        header("Location: ../setup/installation.php?error=" . $errors[0]);
    }
}