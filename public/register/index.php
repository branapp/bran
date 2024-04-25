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
        <form action="../inc/signup.inc.php" method="POST" class="login-form">
            <h3 class="inline-form-title">user registration</h3>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="passwordConfirm" class="form-label">Confirm password</label>
                            <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control">
                        </div>
                    </div>
                    <div id="emailHelp" class="form-text text-white ">Password must contain 8 digits, a capital letter, a number, and a special character</div>
                </div>
                <button type="submit" class="btn btn-primary" name="register-submit">Submit</button>
            </form>
        </div>
    </div>
</body>
