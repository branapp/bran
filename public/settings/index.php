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
<script src="../<?php $base_dir ?>assets/js/greetings.js"></script>
<div class="row">
    <div class="col-md-4">
        <div class="window">
            <div class="d-flex justify-content-center align-items-center">
                        <img src="../assets/img/bran.png" alt="bran" class="logo-sm">
                    </div>
                <p class="ui-title text-center" id="greeting"><?php echo $_SESSION['cuid_username'] ?></p>
                <ul>
                    <li><a href="#general"></a>General</li>
                    <li><a href="#general"></a>Account</li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="window">
                <p class="modal-title fs-5">settings</p>
            </div>
        </div>
    </div>
<div class="d-flex flex-column align-items-center justify-content-center vh80">
</div>
</body>