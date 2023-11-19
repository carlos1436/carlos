<?php

//DATABASE CONNECTION
include_once("database.connection.php");

//START SESSION
session_start();

class Login extends Connection
{
  public $id;
  public $type;
  public $name;
  public function login($usernameemail, $password)
  {
    $username = strip_tags($_POST['uname']);
    $password = strip_tags($_POST['password']);
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_username = :uname && user_password = :password");
    $stmt->bindParam(':uname', $username);
    $stmt->bindParam(':password', $password);

    // execute the SQL statement
    try {
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($stmt->rowCount() > 0) {
        if ($password == $result["user_password"]) {
          $this->id = $result["user_id"];
          $this->type = $result["user_type"];
          $this->name = $result["user_fullname"];
          if ($result["user_type"] == "Admin" || $result["user_type"] == "admin") {
            return 1;
          } else if ($result["user_type"] == "Teacher" || $result["user_type"] == "teacher") {
            return 2;
          } else if ($result["user_type"] == "Student" || $result["user_type"] == "student") {
            return 3;
          }

        } else {
          return 10;
        }
      } else {
        return 100;
      }
    } catch (PDOException $e) {
      // handle the exception
      echo "Error: " . $e->getMessage();
    }
  }
  public function idUser()
  {
    return $this->id;
  }
  public function TypeUser()
  {
    return $this->type;
  }
  public function NameUser()
  {
    return $this->name;
  }
}

class Select extends Connection
{
  public function selectUserById($id)
  {
    $finalId = null;
    try {
      $stmt2 = $this->conn->prepare("SELECT * FROM users WHERE user_id = :id");
      $stmt2->bindParam(':id', $id);
      $stmt2->execute();
      $result = $stmt2->fetch(PDO::FETCH_ASSOC);
      $finalId = $result['user_id'];
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    return $finalId;
  }
}