<?php
  session_start();
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


  include_once '../../config/Database.php';
  include_once '../../models/User.php';
  // include_once '../../include/functions.php';

  $database = new Database();
  $db = $database->connect();

  $user = new User($db);
  $_SESSION['user'] = $user;


  if($user->login()) {
    echo json_encode(
      array('message' => 'User Logged In')
    );
    header('Location: ../../index.php');
  } else {
    echo json_encode(
      array('message' => 'User Not Logged In',
            'error' => $user->error)
    );
    header('Location: ../../login.php');
  }