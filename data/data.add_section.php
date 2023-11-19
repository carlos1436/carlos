<?php
// DATABASE CONNECTION
include_once("database.php");

if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {

        $check_section = $conn->prepare("
                SELECT * 
                FROM section
                WHERE section_name = ? AND section_program = ?
            ");
        $check_section->execute([
            strip_tags($_POST["section_name"]),
            strip_tags($_POST["section_program"])
        ]);

        if ($check_section->fetch()) {
            echo "section_error";
        } else {

            $insert_section = $conn->prepare("
                    INSERT INTO section
                    (section_name, section_program, section_major)
                    VALUES
                    (?,?,?)
                ");
            $inserted = $insert_section->execute([
                strip_tags($_POST["section_name"]),
                strip_tags($_POST["section_program"]),
                strip_tags($_POST["section_major"])
            ]);

            if ($inserted) {
                echo 1;
            } else {
                echo 0;
            }

        }

    }
}

$check_section = null;
$insert_section = null;
$conn = null;
?>