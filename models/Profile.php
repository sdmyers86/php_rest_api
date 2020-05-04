<?php
class Profile {
  private $conn;
  private $table = 'profile';

  public $about_me;

  public function __construct($db) {
    $this->conn = $db;
  }
}