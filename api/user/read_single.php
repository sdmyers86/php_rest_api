<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  $database = new Database();
  $db = $database->connect();

  $user = new User($db);

  $user->id = isset($_GET['id']) ? $_GET['id'] : die();

  $user->getSingleUser();
  
  $user_arr = array(
    'id' => $user->id,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email,
    'password' => $user->password,
    'dob' => $user->dob,
    'signup_date' => $user->signup_date
  );

  print_r(json_encode($user_arr));
