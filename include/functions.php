<?php
session_start();

function isLoggedIn(): bool {
  return isset($_SESSION['user_id']);
}

function getUserId(): int {
  return $_SESSION['user_id'] ?? 0;
}
function getConnection() {
  // db connection options: mysqli or pdo
  $conn = new mysqli('localhost', 'phpuser','password','projectdb');

  return $conn;
}

function escapeString(string $str) {
  $conn = getConnection();

  return $conn->escape_string($str);
}

function getResult(string $selectQuery) {
  $conn = getConnection();
  $result = $conn->query($selectQuery);

  if (!$result) {
      echo $conn->error; // ideally would log this error
      return [];
  }

  return $result; // mysqli_result object
}

function getProfile() {
  if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    return null;
  }

  $id = $_GET['id'];

  $query = "SELECT * from profile WHERE user_id = $id";

  $result = getResult($query);

  if ($result->num_rows !== 1) {
    return null;
  }

  $profile = $result->fetch_object();

  $_SESSION['profile_id'] = $id;

  return $profile;

}

//Create profile about me
function createProfile() {
  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return null;
  }

  try {
    $userId = getUserId();

    $profileId = $_POST['profileId'];
    $about = $_POST['about'];
    $about = escapeString($about);

    if(is_numeric($profileId)) {
      $query = "UPDATE profile SET user_id=$userId, about_me='$about'
                WHERE id = $profileId";
    } else {
      $query = "INSERT INTO profile(user_id, about_me) VALUES ($userId, '$about')";
    }

    $conn = getConnection();
    $result = $conn->query($query);

    if(!$result) {
      throw new Exception("Save profile failed");
    }

    if(!is_numeric($profileId)) {
      $profileId = $conn->insert_id;
    }

    uploadImage($profileId);

    header('Location: index.php');
  } catch(Exception $e) {
      return $e->getMessage();
  }
}

function isValidImageType(string $path): bool {
  $acceptedTypes = ['image/jpeg', 'image/png', 'image/gif'];
  $fileInfo = new finfo(FILEINFO_MIME_TYPE);

  return in_array($fileInfo->file($path), $acceptedTypes);
}

function uploadImage(int $profileId) {
  $picture = $_FILES['picture'];
  $name = $picture['name'];
  $type = $picture['type'];
  $size = $picture['size'];
  $error = $picture['error'];
  $tmp = $picture['tmp_name'];

  if (!file_exists($tmp) || $error || !isValidImageType($tmp)) {
      // throw new Exception('Problem uploading image');
      return;
  }

  $stream = fopen($tmp, 'r');
  $data = fread($stream, $size);
  fclose($stream);

  $data = escapeString($data);

  $result = getResult("SELECT * FROM image WHERE profile_id = $profileId");

  if ($result->num_rows) {
      $image = $result->fetch_object();
      getResult("UPDATE image SET filename='$name',filetype='$type',filedata='$data',profile_id=$profileId
          WHERE id = $image->id");
  } else {
      getResult("INSERT image (filename,filetype,filedata,profile_id) VALUES('$name','$type','$data',$profileId)");
  }
}

// Delete Profile

// Delete User