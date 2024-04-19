<?php
session_start();
include('../assets/templates/header.php');
if (isset($_SESSION['cuid'])) :
    header("Location: ../dashboard");
    exit();
endif;
?>

<title>bran | login prompt</title>

<body class="login-page">
    <div class="d-flex flex-column align-items-center justify-content-center vh80">
        <div class="animate__animated animate__fadeIn">
            <div class="d-flex align-items-center justify-content-center">
                <img src="../assets/img/bran.png" alt="bran" class="logo">
            </div>
            <form action="../inc/login.inc.php" class="login-form" method="POST">
                <h3 class="inline-form-title">login to bran</h3>
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username" placeholder="Enter username"><br>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Enter password"><br>
                <input type="submit" name="login-submit" class="b-button" value="Login">
                <p class="text-white small">This app is only to be used by authorized users. Please report
suspicious activity to security@tism.team</p>
                <?php include("../inc/gitinfo.inc.php") ?>
                <p><?php echo $git_commit_id ?> on <?php echo $git_branch ?> branch.</p>
            </form>
        </div>
    </div>
</body>
