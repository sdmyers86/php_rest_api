<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  $database = new Database();
  $db = $database->connect();

  $user = new User($db);

  $result = $user->getUsers();
  $num = $result->num_rows;

  // var_dump($result);

  if($num > 0) {
    $user_arr = array();
    $user_arr['data'] = array();

    while($row = $result->fetch_object()) {

      $user_record = array(
        'id' => $row->id,
        'first_name' => $row->first_name,
        'last_name' => $row->last_name,
        'email' => $row->email,
        'password' => $row->password,
        'dob' => $row->dob,
        'signup_date' => $row->signup_date
      );

      array_push($user_arr['data'], $user_record);
    }

    echo json_encode($user_arr);

  } else {
    echo json_encode(
      array('message' => 'No Users Found')
    );
  }