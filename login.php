<?php
require_once 'models/User.php';
require_once './include/functions.php';
// session_start();
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
  <title>Log-in</title>
</head>
<body>
  <nav class="navbar navbar-dark bg-dark sticky-top">
      <a href="" class="navbar-brand">My PHP website</a>
  </nav>
  <div class="container">
    <h1>Log-in</h1>
    <div class="row d-flex justify-content-center">
      <div class="col-6">
        <form action="./api/user/login.php" method="post">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <button type="submit" class="btn btn-block btn-primary">Submit</button>
          <?php if($msg): ?>
            <p class="text-danger mt-3"><?=$msg?></p>
          <?php endif; ?>
        </form>
        Don't have an account? Register <a href="registration.php">here</a>   
      </div>
    </div>
  </div>
  
</body>
</html>