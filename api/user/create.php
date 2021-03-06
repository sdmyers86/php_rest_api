<?php
  session_start();
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  $database = new Database();
  $db = $database->connect();

  $user = new User($db);
  $_SESSION['user'] = $user;

  // $data = json_decode(file_get_contents("php://input"));

  $user->first_name = $_POST['first_name'];
  $user->last_name = $_POST['last_name'];
  $user->email = $_POST['email'];
  $user->password = $_POST['password'];
  $user->confirm = $_POST['confirm'];

  if($user->create()) {
    echo json_encode(
      array('message' => 'User Created')
    );
    header('Location: ../../login.php');
  } else {
    echo json_encode(
      array('message' => 'User Not Created',
            'error' => $user->error)
    );
    header('Location: ../../registration.php');
  }

