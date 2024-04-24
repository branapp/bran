<?php 

include "../assets/templates/header.php"
?>

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