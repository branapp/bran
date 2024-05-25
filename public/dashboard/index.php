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
    $sql = "SELECT users.username, users.role, user_data.bran_total FROM user_data JOIN users ON user_data.user_id = users.id ORDER BY user_data.bran_total DESC LIMIT 8";
    $stmt = $pdo->prepare($sql);

    // Execute the query
    $stmt->execute();

    // Fetch all the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
endif;

?>
<script src="../<?php $base_dir ?>assets/js/greetings.js"></script>
<script src="../<?php $base_dir ?>assets/js/countdown.js"></script>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#branspend">
                        BALANCE <?php echo $user_data['bran_daily'] ?? 'idk' ?>
                    </button>
                    <p class="ui" id="countdown"></p>
                </div>
            </div>
            <!-- Button trigger modal -->

            <!-- Modal -->
            <div class="modal" id="branspend" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">send bran</h1>
                        </div>
                        <form action="../inc/credits.inc.php" method="POST" class="login-page">
                        <div class="modal-body login-form">
                            <label for="recipient">recipient</label>
                            <input type="text" name="recipient" id="recipient" class="form-control" required>
                            <label for="amount" class="">amount (max <?php echo $bran_daily ?>)</label>
                            <input type="number" name="amount" id="amount" class="form-control" required  max="<?php echo $bran_daily ?>">
                            <script>
                                // this isnt stupid, you're stupid
                                document.getElementById('amount').addEventListener('input', function() {
                                    if (this.value < 1) {
                                        this.value = 1;
                                    } else if (this.value > <?php echo $bran_daily ?>) {
                                        this.value = <?php echo $bran_daily ?>;
                                    }
                                });
                            </script>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                            <button type="submit" class="btn btn-primary">confirm</button>
                        </div>
                    </form>
                    </div>
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
