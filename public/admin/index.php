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

include $base_dir . 'inc/connect.inc.php';
$query = "SELECT u.*, ud.bran_daily, ud.bran_total FROM users u JOIN user_data ud ON u.id = ud.user_id ORDER BY bran_total DESC LIMIT 10";
$stmt = $pdo->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
<script src="../assets/js/greetings.js"></script>
<div class="row">
    <div class="col-md-2">
        <div class="window">
            <div class="d-flex justify-content-center align-items-center">
                <img src="../assets/img/bran.png" alt="bran" class="logo-sm">
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link active show" data-bs-toggle="tab" href="#dash">dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings">settings</a>
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
                <div class="tab-pane active" id="dash">
                    <h3 class="navbar-brand" id="greeting"><?php echo $_SESSION['cuid_username'] ?></h3>
                    
                </div>
                <div class="tab-pane" id="settings">
                    <p class="modal-title fs-5">general</p>
                    <?php include("../inc/gitinfo.inc.php") ?>
                    <p class="mt-1"><?php echo $git_commit_id ?> on <?php echo $git_branch ?> branch.</p>
                </div>
                <div class="tab-pane" id="moderation">
                    <p class="modal-title fs-5">moderation</p>
                    <div> 
                    <table class="table table-dark table-bordered">
                        <input type="text" id="searchInput" class="" placeholder="find a user">
                        <script>
                        $(document).ready(function() {
                            $('#searchInput').on('input', function() {
                                var searchText = $(this).val().toLowerCase();
                                $('tbody tr').each(function() {
                                    var username = $(this).find('td:first').text().toLowerCase();
                                    if (username.includes(searchText)) {
                                        $(this).show();
                                    } else {
                                        $(this).hide();
                                    }
                                });
                            });
                        });
                        </script>
                        <thead>
                            <tr>
                            <th>user</th>
                            <th>join date</th>
                            <th>role</th>
                            <th>bran total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?php echo $result['username'] ?></td>
                                <td><?php echo $result['user_join'] ?></td>
                                <td><?php echo $result['role'] ?></td>
                                <td><?php echo $result['bran_total'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="tab-pane" id="logging">
                    <p class="modal-title fs-5">logging</p>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#log1">API Logs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#log2"></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="log1">
                            <?php
                            /**
                             * @todo have this live reload
                             */
                            $logFile = "$base_dir../logs/combined.log";
                            $logContent = file_get_contents($logFile);
                            $logLines = explode("\n", $logContent);
                            $logLines = array_reverse($logLines);
                            echo '<pre>' . htmlspecialchars(implode("\n", $logLines)) . '</pre>';
                            ?>
                        </div>
                        <div class="tab-pane" id="log2">
                            <p>Log 2 content</p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>