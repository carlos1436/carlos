<?php
session_start();
include_once("database.php");

$user_fullname = $_SESSION["user_fullname"];
$user_type = $_SESSION["user_type"];
$status = "Pending";

// Assuming $this->conn is your database connection
// $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
// $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
// $stmt->execute();
// $result = $stmt->fetch(PDO::FETCH_ASSOC);
// $user_fullname = $result['user_fullname'];
// $user_type = $result['user_type'];

if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {
        $check_feedback_student = $conn->prepare("
        SELECT *
        FROM feedback
        WHERE feedback_title = ? AND feedback_desc = ?
        AND feedback_type = ? AND feedback_user_type = ?
        AND feedback_user_name_from = ?
    ");
        $check_feedback_student->execute([
            strip_tags($_POST["feedback_title"]),
            strip_tags($_POST["feedback_desc"]),
            strip_tags($_POST["feedback_type"]),
            strip_tags($user_type),
            strip_tags($user_fullname),
        ]);
        if ($check_feedback_student->fetch()) {
            echo "feedback_student_added";
        } else {
            $insert_feedback_student = $conn->prepare("
            INSERT INTO feedback
            (feedback_title,feedback_desc,feedback_type,feedback_status,
            feedback_user_type,feedback_user_name_from)
            VALUES (?,?,?,?,?,?)
            ");
            $inserted = $insert_feedback_student->execute([
                strip_tags($_POST["feedback_title"]),
                strip_tags($_POST["feedback_desc"]),
                strip_tags($_POST["feedback_type"]),
                strip_tags($status),
                strip_tags($user_type),
                strip_tags($user_fullname),
            ]);
            if ($inserted) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}
$check_feedback_student = null;
$insert_feedback_student = null;
$status = null;
$user_type = null;
$user_fullname = null;

?>