<?php 
/**
 * requires bran config file.
 * CHECKS IF BRAN IS INSTALLED
 */

 $base_dir = $_SERVER['DOCUMENT_ROOT'] . "/../";
 include "$base_dir/bran-config.php";

 if ($installed == true):
     header("Location: ../login");
     exit;
 endif;

if ($installed === false): 
    header("$base_dir/public/setup/installation.php");
else: 
    header("$base_dir/public/login");
endif;


$included_files = get_included_files();
$initial_file = $included_files[0];
$initial_file_dir = dirname($initial_file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../assets/style/global.css">
    <link rel="stylesheet" href="../assets/style/fonts.css">
<style>
body {
    <?php 
    if($_SERVER['REQUEST_URI'] == '/setup/installation.php' || $_SERVER['REQUEST_URI'] == '/setup/installation.php/'):
        ?>
        background-image: url('../<?php $inital_file_dir ?>assets/img/radial2.jpg');
        background-position: center;
        <?php
    else:
        ?>
        background-image: url('../<?php $inital_file_dir ?>assets/img/c_fog_darkbluepurupl.png');
        background-position: center;
        <?php
    endif;        
    ?>
    background-size: cover;
    background-repeat: no-repeat;   
    background-attachment: fixed;
}
</style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <h2 class="navbar-brand"><?php echo '\\\\bran\\'. basename($initial_file_dir) ?></h2>
                </ul>
                <div class="d-flex">
                    <!-- <p>hi</p> -->
                </div>
                </div>
            </div>
        </nav>
    </header>