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
                include "tables.inc.php";
                
                $email = filter_var($post_vars['adminemail'], FILTER_SANITIZE_EMAIL);
                $role = 'admin';
                $query = "INSERT INTO bran_options (option_name, option_value) VALUES ('motd', 'welcome to bran'),
                ('user_registration', 'enabled');";
                
                $pdo->exec($query);
                
                // Insert the user data into the users table
                $query = "INSERT INTO users (email, username, password, role)
                          VALUES (:email, :username, :password, :role);";
                $stmt = $pdo->prepare($query);
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