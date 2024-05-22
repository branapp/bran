<?php 
/**
 * requires bran config file.
 * CHECKS IF BRAN IS INSTALLED
 */
session_start();
$base_dir = __DIR__ . "/../../"; // This climbs up two levels from the current directory.

 include "$base_dir/bran-config.php";
 include $_SERVER['DOCUMENT_ROOT']."/inc/connect.inc.php";

if ($installed === false): 
    header("$base_dir/public/setup/installation.php");
else: 
    header("$base_dir/public/login");
endif;

$included_files = get_included_files();
$initial_file = $included_files[0];
$initial_file_dir = dirname($initial_file);

if (isset($_SESSION['cuid'])):
    $stmt = $pdo->prepare("SELECT * FROM user_data WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['cuid'], PDO::PARAM_INT);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
endif;

// make bran_options globally available

$stmt = $pdo->prepare("SELECT * FROM bran_options");
$stmt->execute();
$bran_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
$bran_options = array_column($bran_options, 'option_value', 'option_name');

if (!is_null($user_data['theme_accent'])):
    $theme_accent = $user_data['theme_accent'];
else:
    $theme_accent = "FF90BC";
endif;

$pluginLoaderPath = "$base_dir/inc/plugins.inc.php";
if (file_exists($pluginLoaderPath)) {
    include $pluginLoaderPath;
} else {
    error_log("Failed to load plugin loader from: " . $pluginLoaderPath);
    // Optionally handle the error more gracefully
}

$pluginLoader = new PluginLoader();
$pluginLoader->loadPlugins();
$pluginLoader->executePlugins();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <link rel="stylesheet" href="../assets/style/global.css">
        <link rel="stylesheet" href="../assets/style/fonts.css">
        <title><?php echo basename($initial_file_dir) ?> | bran.exe</title>
        <style>
            :root {
                --default-accent: #<?php echo $theme_accent ?>
            }
            body {
                background-image: url('../<?php $inital_file_dir ?>assets/img/c_fog_darkbluepurupl.png');
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;   
                background-attachment: fixed;
            }
            
            .form-control:focus {
                background-color: unset;
                color: var(--default-accent);
            }
            .window {
                background-color: #<?php echo $theme_accent ?>30; }
            
            .modal-content {
                background-color: black;
                padding: 1rem;}
            
            .btn {
                background-color: #<?php echo $theme_accent ?>;
                border-color: #<?php echo $theme_accent ?>; }
            
            .btn:hover {
                background-color: #<?php echo $theme_accent ?>;
                border-color: #<?php echo $theme_accent ?>90; }
        </style>
</head>

<body>
<header class="mb-5">
    
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <h2 class="navbar-brand"><?php echo '\\\\bran\\'. basename($initial_file_dir) ?></h2>
        </ul>
        <?php
            if (isset($_SESSION['cuid'])):
                ?>
                <div class="d-flex">
                    <div>
                        <button type="button" class="btn-justtext" data-bs-toggle="modal" data-bs-target="#account">
                            account
                        </button>
                        <div class="modal" id="account" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">directory</h1>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>
                                                <?php if (strpos($_SERVER['REQUEST_URI'], '/admin') !== false): ?>
                                                    <a aria-current="page" href="../dashboard" class="ui">dashboard</a>
                                                <?php else:
                                                    if ($user_data['user_role'] === 'admin'): ?>
                                                        <a aria-current="page" href="../admin">admin</a>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </li>
                                            <li><a href="../inc/logout.inc.php">sign off</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            <?php
            endif;
            ?>
            </div>
        </div>
    </nav>
    
</header>