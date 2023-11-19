<?php
// DATABASE CONNECTION
include_once("database.php");
$_POST["lastname"] . ", " . legal_input($_POST["firstname"]);
function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}
if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {
        $teacher_fullname = strip_tags(legal_input($_POST["lastname"])) . ", " . strip_tags(legal_input($_POST["firstname"]));
        // CHECK ID NUMBER
        $check_id_number = $conn->prepare("
                SELECT teacher_id_number
                FROM teacher
                WHERE teacher_id_number = ?
            ");
        $check_id_number->execute([
            strip_tags($_POST["id_number"])
        ]);

        if ($check_id_number->fetch()) {
            echo "id_number_error";
        } else {
            $insert_teacher = $conn->prepare("
                    INSERT INTO teacher
                    (teacher_id_number, teacher_firstname, teacher_lastname, teacher_middlename, teacher_bachelor, teacher_master, teacher_doctor, teacher_special, teacher_major, teacher_minor, teacher_designation, teacher_status, teacher_research, teacher_production, teacher_extension, teacher_others)
                    VALUES
                    (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                ");
            $teacher_added = $insert_teacher->execute([
                strip_tags($_POST["id_number"]),
                strip_tags($_POST["firstname"]),
                strip_tags($_POST["lastname"]),
                strip_tags($_POST["middlename"]),
                strip_tags($_POST["bachelor"]),
                strip_tags($_POST["master"]),
                strip_tags($_POST["doctor"]),
                strip_tags($_POST["special"]),
                strip_tags($_POST["major"]),
                strip_tags($_POST["minor"]),
                strip_tags($_POST["designation"]),
                strip_tags($_POST["status"]),
                strip_tags($_POST["research"]),
                strip_tags($_POST["production"]),
                strip_tags($_POST["extension"]),
                strip_tags($_POST["others"])
            ]);

            if ($teacher_added) {
                echo 1;
            } else {
                echo 0;
            }
            $insert_teacher_user = $conn->prepare("
                INSERT INTO users
                (user_username,user_password,user_fullname,user_contact,user_type,user_address,user_id_number)
                VALUES
                (?,?,?,?,?,?,?)
            ");
            $teacher_user_added = $insert_teacher_user->execute([
                strip_tags($_POST["username"]),
                strip_tags($_POST["password"]),
                $teacher_fullname,
                strip_tags($_POST["phone_number"]),
                "Teacher",
                strip_tags($_POST["address"]),
                strip_tags($_POST["id_number"]),

            ]);

            if ($teacher_user_added) {
                echo 1;
            } else {
                echo 0;
            }
        }

    }
}

$check_id_number = null;
$insert_teacher = null;
$conn = null;

?>