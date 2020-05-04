<?php
  require_once './include/functions.php';
  if(!isLoggedIn()) {
    header('Location: ./login.php');
  }
  $errorMsg = createProfile();
  $profile = getProfile();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/sketchy/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <title>Welcome</title>
</head>
<body>
  <nav class="navbar navbar-dark bg-dark sticky-top">
      <a href="index.php" class="navbar-brand">My PHP website</a>
  </nav>
  <h1>Edit Profile</h1>
  <div class="row d-flex justify-content-center">
      <div class="col-6">
        <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="profileId" 
            value="<?=$profile ? $profile->id : ''?>">
          <div class="form-group">
            <label for="about">About Me</label>
            <textarea class="form-control" name="about" id="about" rows="3"
            placeholder="Tell us about yourself..."><?=$profile ? $profile->about_me : ''?></textarea>
          </div>
          <div class="form-group">
            <label for="picture">Upload your picture</label>
            <input type="file" name="picture" id="picture">
          </div>
          <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
        </form>        
        <?php if($errorMsg): ?>
          <p class="text-danger mt-3 font-weight-bold"><?=$errorMsg?></p>
        <?php endif; ?>
        <div class="mt-3">
          <a href="changepassword.php" class=>Change Password</a>
        </div>
      </div>
    </div>
</body>
</html>