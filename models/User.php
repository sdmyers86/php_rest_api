<?php
  class User {
    private $conn;
    private $table = 'user';

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $dob;
    public $signup_date;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function getUsers() {
      $query = 'SELECT * FROM user';

      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      $result = $stmt->get_result();

      return $result;
    }

    public function getSingleUser() {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE user.id = ? LIMIT 0,1';

      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('i', $this->id);
      $stmt->execute();

      $result = $stmt->get_result();
      $result = $result->fetch_object();

      $this->first_name = $result->first_name;
      $this->last_name = $result->last_name;
      $this->email = $result->email;
      $this->password = $result->password;
      $this->dob = $result->dob;
      $this->signup_date = $result->signup_date;
    }

    public function create() {
      $query = 'INSERT INTO ' . $this->table . ' 
      SET
        first_name = ?,
        last_name = ?,
        email = ?,
        password = ?,
        dob = ?';

      $stmt = $this->conn->prepare($query);

      $this->first_name = htmlspecialchars(strip_tags($this->first_name));
      $this->last_name = htmlspecialchars(strip_tags($this->last_name));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->dob = htmlspecialchars(strip_tags($this->dob));

      $stmt->bind_param('sssss',
        $this->first_name,
        $this->last_name,
        $this->email,
        $this->password,
        $this->dob);

      if($stmt->execute()) {
        return true;
      } else {
        return false;
      }
    }

    public function update() {
      $query = 'UPDATE ' . $this->table . ' 
      SET
        first_name = ?,
        last_name = ?,
        email = ?,
        password = ?,
        dob = ?
      WHERE
        id = ?';

      $stmt = $this->conn->prepare($query);

      $this->first_name = htmlspecialchars(strip_tags($this->first_name));
      $this->last_name = htmlspecialchars(strip_tags($this->last_name));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->dob = htmlspecialchars(strip_tags($this->dob));
      $this->id = htmlspecialchars(strip_tags($this->id));

      $stmt->bind_param('sssssi',
        $this->first_name,
        $this->last_name,
        $this->email,
        $this->password,
        $this->dob,
        $this->id);

      if($stmt->execute()) {
        return true;
      } else {
        return false;
      }
    }

    public function delete() {
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';

      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));

      $stmt->bind_param('i', $this->id);
      
      if($stmt->execute()) {
        return true;
      } else {
        return false;
      }
    }
  }

  

