<?php
require_once 'models/User.php';
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$msg = isset($user) ? $user->error : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/sketchy/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <title>Registration</title>  
</head>
<body>
  <nav class="navbar navbar-dark bg-dark sticky-top">
    <a href="" class="navbar-brand">My PHP website</a>
  </nav>
  <div class="container">
    <h1>Create Account</h1>
    <div class="row d-flex justify-content-center">
      <div class="col-6">
        <form action="./api/user/create.php" method="post">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email">
          </div>
          <div class="form-group">
            <label for="first_name">First name</label>
            <input type="text" class="form-control" name="first_name" id="first_name">
          </div>
          <div class="form-group">
            <label for="last_name">Last name</label>
            <input type="text" class="form-control" name="last_name" id="last_name">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <div class="form-group">
            <label for="confirm">Confirm password</label>
            <input type="password" class="form-control" name="confirm" id="confirm">
          </div>
          <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
          <?php if($msg): ?>
            <p class="text-danger mt-3"><?=$msg?></p>
          <?php endif; ?>
        </form>        
      </div>
    </div>
      
  </div>   
</body>
</html>