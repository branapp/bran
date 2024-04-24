<?php 

include "../../bran-config.php";
if ($installed == true):
    header("Location: ../login");
endif;

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
          <p class="info text-white">Before you begin, please ensure you have created a bran-config.php file in the
root of bran, and that all files in bran are owned by www-data. Please consult
<a href="../docs/index.php">the documentation</a> if you are unsure.</p>
          <form action="../inc/setup.inc.php" class="login-form" method="POST">
            <p class="text-white small">Adminstrator account creation</p>
            <label for="adminemail">Email</label><br>
            <input type="email" id="adminemail">
            <label for="adminuser">Username</label><br>
            <input type="text" id="adminuser">
            <label for="adminpass">Password</label><br>
            <input type="text" id="adminpass">
            <label for="adminpassconf">Password confirm</label><br>
            <input type="text" id="adminpassconf">
            <p class="text-white small">Login details for database</p>
            <label for="dbname">Bran database name</label><br>
            <input type="text" id="dbname">
            <label for="dbuser">Username</label><br>
            <input type="text" id="dbuser">
            <label for="dbpass">Password</label><br>
            <input type="text" id="dbpass">
            <p class="text-white small">Submitting this form initialises the setup script, please make sure the information provided is correct before continuing.</p>
            <input type="submit" name="setup-submit" class="b-button" value="Install">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>