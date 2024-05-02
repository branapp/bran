<?php
session_start();
if (!isset($_SESSION['cuid'])) :
    header("Location: ../login");
    exit();
endif;

include "../assets/templates/header.php";

if (isset($_SESSION['cuid'])):
    include $_SERVER['DOCUMENT_ROOT'] . "/inc/connect.inc.php";
    $stmt = $pdo->prepare("SELECT * FROM user_data WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['cuid'], PDO::PARAM_INT);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    extract($user_data);
endif;
?>
<script src="../<?php $base_dir ?>assets/js/greetings.js"></script>
<div class="dashboard">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <!-- info panel -->
            <div class="window">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="../assets/img/bran.png" alt="bran" class="logo">
                </div>
                <div class="text-center">
                    <h3 class="ui ui-title" id="greeting"><?php echo $_SESSION['cuid_username'] ?></h3>
                    <h6 class="ui text-lowercase">INSERT MOTD HERE</h6>
                    <h3 class="ui ui-subtitle">BALANCE <?php echo $bran_daily ?? '???' ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="window">
                e
            </div>
        </div>
    </div>
</div>