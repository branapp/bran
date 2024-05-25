<?php
session_start();
if (!isset($_SESSION['cuid'])) :
    header("Location: ../login");
    exit();
endif;

include "../assets/templates/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/inc/connect.inc.php";
?>

<body>
<div class="row">
    <div class="col-md-2">
        <div class="window">
            <div class="d-flex justify-content-center align-items-center">
                <img src="../assets/img/bran.png" alt="bran" class="logo-sm">
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#general">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#account">Account</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-10">
        <div class="window">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="general">
                    <p class="modal-title fs-5">General</p>
                        <form action="../inc/settings.inc.php" class="login-form mt-3 w-50" method="POST">
                            <label for="ch-username">Change username</label>
                            <input type="text" name="ch-username">
                            <label for="color-theme">Color theme</label>
                            <input type="color" name="color-theme">
                            <input type="submit" value="Save changes" name="settings-submit">
                        </form>
                </div>
                <div class="tab-pane fade" id="account">
                    <p class="modal-title fs-5">Account Settings</p>
                    <!-- Add your account settings content here -->
                </div>
            </div>
        </div>
    </div>
</div>
</body>