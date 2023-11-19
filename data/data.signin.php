<?php

// DATABASE CONNECTION
include_once("database.php");
// START SESSION
session_start();
$id = 0;
$type = '';
$name = '';
if (isset($_POST["form_login"])) {
    if (!empty($_POST["form_login"])) {

        $check_login = $conn->prepare("
                SELECT * 
                FROM users
                WHERE user_username = ?
            ");
        $check_login->execute([
            strip_tags($_POST['username']),
        ]);

        if ($row = $check_login->fetch()) {
            if ($_POST["password"] == $row["user_password"]) {
                if (empty($row["user_email_verified"])) {
                    if ($row["user_type"] == "Admin") {
                        echo $row["user_type"];
                        $_SESSION["login"] = true;
                        $_SESSION["user_type"] = $row["user_type"];
                        $_SESSION["id"] = $row["user_id"];
                        $_SESSION["user_fullname"] = $row["user_fullname"];
                    } else if ($row["user_type"] == "Teacher") {
                        echo $row["user_type"];
                        $_SESSION["login"] = true;
                        $_SESSION["user_type"] = $row["user_type"];
                        $_SESSION["id"] = $row["user_id"];
                        $_SESSION["user_fullname"] = $row["user_fullname"];
                    } else if ($row["user_type"] == "Student") {
                        echo $row["user_type"];
                        $_SESSION["login"] = true;
                        $_SESSION["user_type"] = $row["user_type"];
                        $_SESSION["id"] = $row["user_id"];
                        $_SESSION["user_fullname"] = $row["user_fullname"];
                    } else {
                        echo $row["user_type"];
                        $_SESSION["user_type"] = $row["user_type"];
                        $_SESSION["id"] = $row["user_id"];
                        $_SESSION["user_fullname"] = $row["user_fullname"];
                    }
                } else if (!empty($row["user_email_verified"]) || $row["user_email_verified"] == ' ') {
                    echo "user_email_not_verified";
                }
            } else {
                echo "error_password";
            }
        } else {
            echo "error_username_email";
        }

    }
}

$check_login = null;
$conn = null;

?>