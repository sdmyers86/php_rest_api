<?php
require_once './models/User.php';
require_once './include/functions.php';
if(isLoggedIn()) {
  $_GET['id'] = $_SESSION['profile_id'];
}
$profile = getProfile();
// echo ('User Id: '.$_SESSION['user_id'].'. Username: '.$_SESSION['username'].
// 'Profile ID'.$_SESSION['profile_id']);
// $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/sketchy/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <title>Home</title>
</head>
<body>
  <!-- <nav class="navbar navbar-dark bg-dark sticky-top">
      <a href="" class="navbar-brand">My PHP website</a>
  </nav> -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">PHP Website</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php if (isLoggedIn()): ?>
  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="edit-profile.php?id=<?=$_SESSION['user_id']?>">Edit Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>
<?php else: ?>
  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="registration.php">Register</a>
      </li>
    </ul>
  </div>
</nav>
<?php endif; ?>
  <div class="container">
    <?php if (isLoggedIn()): ?>
      <h1>Hello <?=$_SESSION['username']?></h1>
      <img src="get-image.php?id=<?=$_SESSION['profile_id']?>" alt="" height="200">
      <div>
        <p><?=$profile->about_me ?></p>
      </div>

    <?php else: ?>
      <h1>Please log in to view your profile page</h1>
    <?php endif; ?>
  </div>
</body>
</html>