<?php
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

                // Insert the user data into the users table
                $query = "INSERT INTO users (email, username, password, role)
                          VALUES (:email, :username, :password, :role);";
                $stmt = $pdo->prepare($query);
                
                $stmt->bindParam(':email', $post_vars['adminemail'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $post_vars['adminpass'], PDO::PARAM_STR); // Note: You will hash the password just before the execute statement.
                $stmt->bindParam(':role', $role, PDO::PARAM_STR); // Assuming $role is set to 'admin' beforehand
                $stmt->bindParam(':username', $post_vars['adminuser'], PDO::PARAM_STR);

                $email = filter_var($post_vars['adminemail'], FILTER_SANITIZE_EMAIL);
                $password = password_hash($post_vars['adminpass'], PASSWORD_DEFAULT);
                $role = 'admin';
                $username = $post_vars['adminuser'];

                // The variables are now assigned, so you can execute the statement
                $stmt->execute();

            } catch (PDOException $e) {
                // How did that happen....
                // Callback to setup pagewith error code from db
                $code = $e->getCode();
                // header("Location: ../setup/installation.php?error=dbError&code=$code");
                die($e->getMessage());
            }
            // if success, redirect to login page
            header("Location: ../login?install=success");
        }

        // begin setup
        bran_setup($post_vars);
    } else {
        header("Location: ../setup/installation.php?error=" . $errors[0]);
    }
}