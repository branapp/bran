<?php

// Bail early if the form was not submitted directly
if (!isset($_POST['register-submit'])) :
    die("File cannot be directly accessed.");
endif;

require "./connect.inc.php";

// Superglobals
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];
$role = $_POST['role'] ?? 'new_user'; // Default role if not provided

// Validation
if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)) :
    // Catch empty fields
    header("Location: ../register/index.php?error=emptyFields&username=$username&email=$email");
elseif (!preg_match("/^[a-zA-Z0-9_.-]{3,20}$/", $username)) :
    // Catch bad username
    header("Location: ../register/index.php?error=invalidUsername&username=$username&email=$email");
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
    // Catch invalid email
    header("Location: ../register/index.php?error=invalidEmail&username=$username&email=$email");
elseif ($password !== $passwordConfirm) :
    // Catch password mismatch
    header("Location: ../register/index.php?error=passwordMismatch&username=$username&email=$email");
else :
    // All checks passed, fall through to see if username or email is already taken
    $sql_check_username = "SELECT username FROM users WHERE username = :username";
    $stmt_check_username = $pdo->prepare($sql_check_username);
    $stmt_check_username->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt_check_username->execute();

    $sql_check_email = "SELECT email FROM users WHERE email = :email";
    $stmt_check_email = $pdo->prepare($sql_check_email);
    $stmt_check_email->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_check_email->execute();

    if ($stmt_check_username->rowCount() > 0) :
        header("Location: ../register/index.php?error=usernameTaken&username=$username&email=$email");
    elseif ($stmt_check_email->rowCount() > 0) :
        header("Location: ../register/index.php?error=emailTaken&username=$username&email=$email");
    else :
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $pdo->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();

        // Insert a row into the user_data table for the new user
        $query = "INSERT INTO user_data (user_id, theme_accent)
                  VALUES (:user_id, :theme_accent);";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':user_id', $pdo->lastInsertId(), PDO::PARAM_INT);
        $stmt->bindParam(':theme_accent', $theme_accent, PDO::PARAM_STR);

        $theme_accent = 'FF90BC'; // Set the default theme_accent

        // Execute the statement
        $stmt->execute();
    endif;
endif;

/**
 * if all checks out, redirect to dashboard
 */
header("Location: ../dashboard");