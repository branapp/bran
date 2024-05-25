<?php
include "../assets/templates/header.php";
session_start();
if (!isset($_SESSION['cuid'])) :
    header("Location: ../login");
    exit();
endif;

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
                    <a class="nav-link active show" data-bs-toggle="tab" href="#general">general</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#account">account</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-10">
        <div class="window">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <p class="modal-title fs-5">general</p>
                    <form action="../inc/settings.inc.php" class="login-form mt-3" method="POST"> 
                        <label for="ch-username">Change username</label> 
                        <input type="text" name="ch-username"> 
                        <label for="color-theme">Color theme</label> 
                        <input type="color" name="color-theme"> 
                        <input type="submit" value="Save changes" name="settings-submit">
                    </form>
                </div>
                <div class="tab-pane" id="account">
                    <p class="modal-title fs-5">account</p>
                </div>
            </div>
        </div>
    </div>
</div>