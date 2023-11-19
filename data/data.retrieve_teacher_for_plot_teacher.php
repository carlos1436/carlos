<?php
// DATABASE CONNECTION
include_once("database.php");

if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {

        $retrieve_teacher_for_plot = $conn->prepare("
                SELECT DISTINCT teacher_fullname
                FROM teacher_detail
                WHERE teacher_semester = ? AND teacher_school_year = ? AND teacher_fullname = ?
                ORDER BY teacher_fullname ASC;
            ");
        $retrieve_teacher_for_plot->execute([
            strip_tags($_POST["semester"]),
            strip_tags($_POST["school_year"]),
            strip_tags($_SESSION["user_fullname"])
        ]);

        echo '
                <option value="">Select Teacher</option>
            ';
        while ($row = $retrieve_teacher_for_plot->fetch()) {
            echo '
                    <option value="' . $row["teacher_fullname"] . '">' . $row["teacher_fullname"] . '</option>
                ';
        }

    }
}

$retrieve_teacher_for_plot = null;
$conn = null;