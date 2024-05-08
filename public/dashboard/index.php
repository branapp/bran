<?php
session_start();
if (!isset($_SESSION['cuid'])) :
    header("Location: ../login");
    exit();
endif;

include "../assets/templates/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/inc/connect.inc.php";

if (isset($_SESSION['cuid'])):
    $stmt = $pdo->prepare("SELECT * FROM user_data WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['cuid'], PDO::PARAM_INT);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    extract($user_data);
    
    // leaderboard data
    $sql = "SELECT users.username, users.role, user_data.bran_total FROM user_data JOIN users ON user_data.user_id = users.id ORDER BY user_data.bran_total DESC";
    $stmt = $pdo->prepare($sql);

    // Execute the query
    $stmt->execute();

    // Fetch all the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <h6 class="ui text-lowercase"><?php echo $bran_options['motd'] ?? "something aint right..." ?></h6>
                    <h3 class="ui ui-subtitle">BALANCE <?php echo $user_data['bran_daily'] ?? 'idk' ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="window leaderboard">
            <?php $count = 1; ?>
            <table class="leaderboard">
                <tbody>
                    <?php $count = 1; foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td class="text-uppercase"><?php echo htmlspecialchars($row['username']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['bran_total']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>