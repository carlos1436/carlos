<?php

class Connection
{
  public $host = "localhost";
  public $user = "root";
  public $password = "";
  public $db_name = "scheduling_project";
  public $conn;
  public $stmt;

  public function __construct()
  {
 
    try {
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user, $this->password);
      // set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}

?>