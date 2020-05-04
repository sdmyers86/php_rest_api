<?php
require("./models/User.php"); 
session_start();
$user = $_SESSION['user'];
$msg = $user->error;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/sketchy/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <title>Change Password</title>
</head>
<body>
  <nav class="navbar navbar-dark bg-dark sticky-top">
      <a href="" class="navbar-brand">My PHP website</a>
  </nav>
  <div class="container">
    <h1>Change Password</h1>
    <div class="row d-flex justify-content-center">
      <div class="col-6">
        <form action="./api/user/change_password.php" method="post">
          <div class="form-group">
            <label for="curPass">Current Password</label>
            <input type="password" class="form-control" name="curPass" id="curPass">
          </div>
          <div class="form-group">
            <label for="newPass"> New Password</label>
            <input type="password" class="form-control" name="newPass" id="newPass">
          </div>
          <div class="form-group">
            <label for="confirmPass"> Confirm Password</label>
            <input type="password" class="form-control" name="confirmPass" id="confirmPass">
          </div>
          <button type="submit" class="btn btn-block btn-primary">Submit</button>
          <?php if($msg): ?>
            <p class="text-danger mt-3"><?=$msg?></p>
          <?php endif; ?>
        </form>   
      </div>
    </div>
  </div>
  
</body>
</html>