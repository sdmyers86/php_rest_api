<?php
  class Post {
    private $conn;
    private $table = 'post';

    public $id;
    public $user_id;
    public $content;
    public $date_posted;
    public $date_edited;
    public $likes;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function getPosts() {
      
    }
  }