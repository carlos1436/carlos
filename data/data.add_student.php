<?php
// DATABASE CONNECTION
include_once("database.php");

function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {
        // $student_fullname =  legal_input($_POST["firstname"]) . " " . legal_input($_POST["middlename"]) . " " . legal_input($_POST["lastname"]);
        $student_fullname = strip_tags(legal_input($_POST["lastname"])) . ", " . strip_tags(legal_input($_POST["firstname"]));
        // CHECK ID NUMBER
        $check_id_number = $conn->prepare("
                SELECT student_id_number
                FROM student
                WHERE student_id_number = ?
            ");
        $check_id_number->execute([
            strip_tags($_POST["ctuid"])
        ]);

        if ($check_id_number->fetch()) {
            echo "id_number_error";
        } else {
            $insert_student = $conn->prepare("
                    INSERT INTO student
                    (student_id_number, student_firstname, student_middlename, student_lastname, student_course, student_year, student_section, student_status)
                    VALUES
                    (?,?,?,?,?,?,?,?)
                ");
            $student_added = $insert_student->execute([
                strip_tags($_POST["ctuid"]),
                strip_tags($_POST["firstname"]),
                strip_tags($_POST["middlename"]),
                strip_tags($_POST["lastname"]),
                strip_tags($_POST["course"]),
                strip_tags($_POST["year"]),
                strip_tags($_POST["section"]),
                strip_tags($_POST["status"]),
            ]);

            if ($student_added) {
                echo 1;
            } else {
                echo 0;
            }

            $insert_student_user = $conn->prepare("
                    INSERT INTO users
                    (user_username,user_password,user_fullname,user_contact,user_type,user_address,user_id_number)
                    VALUES
                    (?,?,?,?,?,?,?)
                ");
            $student_user_added = $insert_student_user->execute([
                strip_tags($_POST["username"]),
                strip_tags($_POST["password"]),
                $student_fullname,
                strip_tags($_POST["phone_number"]),
                "Student",
                strip_tags($_POST["address"]),
                strip_tags($_POST["ctuid"]),

            ]);

            if ($student_user_added) {
                echo 1;
            } else {
                echo 0;
            }
        }

    }
}

$check_id_number = null;
$insert_student = null;
$conn = null;

?>