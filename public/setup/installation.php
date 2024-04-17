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
        <img src="../assets/img/bran.png" alt="bran" class="logo">
        <h2>lets begin</h2>
      </div>
    </div>
  </div>
</div>
</body>