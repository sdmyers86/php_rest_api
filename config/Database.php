<?php
  class Database {
    private $host = 'localhost';
    private $db_name = 'projectdb';
    private $username = 'phpuser';
    private $password = 'password';
    private $conn;

    public function connect() {
      $this->conn = null;

      $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

      return $this->conn;
    }
  }