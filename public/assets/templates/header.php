<?php 
/**
 * requires bran config file.
 * CHECKS IF BRAN IS INSTALLED
 */
session_start();
 $base_dir = $_SERVER['DOCUMENT_ROOT'] . "/../";
 include "$base_dir/bran-config.php";

if ($installed === false): 
    header("$base_dir/public/setup/installation.php");
else: 
    header("$base_dir/public/login");
endif;

$included_files = get_included_files();
$initial_file = $included_files[0];
$initial_file_dir = dirname($initial_file);

if (isset($_SESSION['userid'])):
    include $_SERVER['DOCUMENT_ROOT']."/inc/connect.inc.php";
    $stmt = $pdo->prepare("SELECT theme_accent FROM user_data WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['userid'], PDO::PARAM_INT);
    $stmt->execute();
    $user_pref = $stmt->fetch(PDO::FETCH_ASSOC);
endif;
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
        <link rel="icon" href="../assets/img/bran.png">
        <style>
            :root {
                --default-accent: <?php 
                /**
                 * @todo fix this so it actually works lmao
                 */
                    if(null !== $_SESSION['cuid'] && $user_pref['theme_accent'] !== null):
                        echo $user_pref['theme_accent'];
                    else:
                        echo "#FF90BC";                    
                    endif; ?>
            }
            body {
                background-image: url('../<?php $inital_file_dir ?>assets/img/c_fog_darkbluepurupl.png');
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;   
                background-attachment: fixed;
            }

            .window {
                background-color: <?php 
                    if(null !== $_SESSION['cuid'] && $user_pref['theme_accent'] !== null):
                        echo $user_pref['theme_accent']."10";
                    else:
                        echo "#FF90BC10";                    
                    endif; ?>
            }
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
                        <a class="nav-link" aria-current="page" href="../inc/logout.inc.php">Sign out</a>
                    </div>
                <?php
                endif;
                ?>
                </div>
            </div>
        </nav>
    </header>