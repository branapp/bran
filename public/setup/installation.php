<?php 

if ($installed) {
  header("Location: ../login");
  exit();
}

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
        <title><?php echo basename($initial_file_dir) ?> | bran.exe</title>
        <style>
            :root {
                --default-accent: #FF90BC;
            }
            body {
                background-image: url('../<?php $inital_file_dir ?>assets/img/c_fog_darkbluepurupl.png');
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;   
                background-attachment: fixed;
            }
        </style>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-12 d-flex align-items-center justify-content-center vh80">
      <div class="centered-div">
        <div class="login-page">
          <div class="d-flex align-items-center justify-content-center">
            <img src="../assets/img/bran.png" alt="bran" class="logo">
          </div>
          <h2 class="text-center text-header fs-1">bran configuration</h2>  
          <p class="info text-white">Before you begin, please ensure you have created a bran-config.php file in the root of bran, and that all files in bran are owned by www-data. Please consult
<a href="../docs/index.php">the documentation</a> if you are unsure.</p>
          <?php
          if (isset($_GET['error'])) {
              ?><div class="alert alert-danger"><?php
              $error = $_GET['error'];
              switch ($error) {
                  case 'emptyFields':
                      echo '<p class="error text-white">Please fill in all fields.</p>';
                      break;
                  case 'regexError':
                      echo '<p class="error text-white">Invalid username format. Username must be between 3 and 20 characters, and can only contain letters, numbers, underscores, periods, and hyphens.</p>';
                      break;
                  case 'invalidEmail':
                      echo '<p class="error text-white">Invalid email format.</p>';
                      break;
                  case 'passwordMismatch':
                      echo '<p class="error text-white">Passwords do not match.</p>';
                      break;
                  case 'dbError':
                      echo '<p class="error text-white">Database error. Please check your database credentials and try again.</p>';
                      break;
                  default:
                      echo '<p class="error text-white">An error occurred. Please try again.</p>';
              }
              ?></div><?php 
          }
          ?>
          <form action="../inc/setup.inc.php" class="login-form" method="POST">
            <p class="text-white small">Adminstrator account creation</p>
            <label for="adminemail">Email</label><br>
            <input type="email" id="adminemail" name="adminemail">
            <label for="adminuser">Username</label><br>
            <input type="text" id="adminuser" name="adminuser">
            <label for="adminpass">Password</label><br>
            <input type="text" id="adminpass" name="adminpass">
            <label for="adminpassconf">Password confirm</label><br>
            <input type="text" id="adminpassconf" name="adminpassconf">
            <p class="text-white small">Login details for database</p>
            <label for="dbname">Bran database name</label><br>
            <input type="text" id="dbname" name="dbname">
            <label for="dbuser">Username</label><br>
            <input type="text" id="dbuser" name="dbuser">
            <label for="dbpass">Password</label><br>
            <input type="text" id="dbpass" name="dbpass">
            <p class="text-white small">Submitting this form initialises the setup script, please make sure the information provided is correct before continuing.</p>
            <input type="submit" name="setup-submit" class="b-button" value="Install">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>