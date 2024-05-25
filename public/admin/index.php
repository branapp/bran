<?php
include($_SERVER['DOCUMENT_ROOT'] . '/assets/templates/header.php');
if(!isset($_SESSION['cuid'])):
    header("Location: ../login");
endif;
if (isset($_SESSION['cuid'])) :
    if($_SESSION['cuid_role'] !== 'admin'): // Modified this line
        header("Location: ../dashboard");
    endif;
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
                    <a class="nav-link active show" data-bs-toggle="tab" href="#settings">settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#moderation">moderation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#logging">logging</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-10">
        <div class="window">
            <div class="tab-content">
                <div class="tab-pane active" id="settings">
                    <p class="modal-title fs-5">general</p>
                </div>
                <div class="tab-pane" id="moderation">
                    <p class="modal-title fs-5">moderation</p>
                </div>
                <div class="tab-pane" id="logging">
                    <p class="modal-title fs-5">logging</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>