<?php
  class User {
    private $conn;
    private $table = 'user';

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $profile_id;
    public $dob;
    public $signup_date;
    public $error;

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
      if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
      }
      try {
        if(empty($this->email) || empty($this->first_name) || empty($this->last_name) || empty($this->password) || empty($this->confirm)) {
          throw new Exception('All fields required');
        }
  
        if($this->password !== $this->confirm) {
          throw new Exception('Passwords do not match');
        }
  
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
  
        $hash = password_hash($this->password, PASSWORD_BCRYPT);
        $hash = $this->conn->escape_string($hash);
  
        $query = 'INSERT INTO ' . $this->table . ' 
        SET
          first_name = ?,
          last_name = ?,
          email = ?,
          password = ?';
  
        $stmt = $this->conn->prepare($query);
  
       
  
        $stmt->bind_param('ssss',
          $this->first_name,
          $this->last_name,
          $this->email,
          $hash);

          if(!$stmt->execute()) {
            throw new Exception('Registration failed');
          } else {
            return true;
          }

      } catch(Exception $e) {
        $this->error = $e->getMessage();
        return false;
      }
      

      // if($stmt->execute()) {
      //   return true;
      // } else {
      //   return false;
      // }
    }

    public function login() {
      if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
      }

      try {

        $this->email = $_POST['email'];
        $this->password = $_POST['password'];

        if(empty($this->email) || empty($this->password)) {
          throw new Exception('All fields required');
        }

        $stmt = $this->conn->prepare("SELECT u.*, p.id as profile_id from
        user u
        left join profile p on p.user_id = u.id 
        WHERE email = ?");

        if(!$stmt) {
          throw new Exception('Server error');
        }

        $stmt->bind_param('s', $this->email);

        if(!$stmt->execute()) {
          throw new Exception('Problem logging in');
        }

        $result = $stmt->get_result();

        if($result->num_rows !== 1) {
          throw new Exception('User not found');
        }

        $user = $result->fetch_object();

        if(!password_verify($this->password, $user->password)) {
          throw new Exception('Invalid username or password');
        } else {
          $_SESSION['user_id'] = $user->id;
          $_SESSION['username'] = $user->first_name;
          $_SESSION['profile_id'] = $user->profile_id;
          return true;
        }

      } catch(Exception $e) {
        $this->error = $e->getMessage();
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

    function changePassword() {
      if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
      }
    
      try {
        $user_id = $_SESSION['user_id'];
        $curPass = $_POST['curPass'];
        $newPass = $_POST['newPass'];
        $confirmPass = $_POST['confirmPass'];
    
        if(empty($curPass) || empty($newPass) || empty($confirmPass)) {
          throw new Exception('All fields required');
        }
    
        $query = "SELECT * FROM user
        WHERE id = '$user_id'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if(!$stmt->execute()) {
          throw new Exception('Problem finding user');
        }

        $result = $stmt->get_result();
        $user = $result->fetch_object();

        if(!password_verify($curPass, $user->password)) {
          throw new Exception('Current password invalid');
        }

        if($newPass !== $confirmPass) {
          throw new Exception('New passwords do not match');
        }

        $newPass = htmlspecialchars(strip_tags($newPass));
  
        $hash = password_hash($newPass, PASSWORD_BCRYPT);
        $hash = $this->conn->escape_string($hash);
          
        $sql = "UPDATE user SET password='$hash'
        WHERE id = $user_id";

        $stmt2 = $this->conn->prepare($sql);

        if($stmt2->execute()) {
          return true;
        } else {
          return false;
        }
    
      } catch(Exception $e) {
        $this->error = $e->getMessage();
        return false;
      }
      
    }

   
  }

  

