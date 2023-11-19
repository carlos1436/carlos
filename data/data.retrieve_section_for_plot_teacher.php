<?php
// DATABAE CONNECTION
include_once("database.php");
session_start();
$user_fullname = strip_tags($_SESSION["user_fullname"]);
if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {

        $retrieve_section_for_plot = $conn->prepare("
               SELECT DISTINCT schedule_section FROM schedule
                LEFT JOIN section
                ON section.section_name = schedule_section
                WHERE schedule_semester =? AND schedule_school_year =? AND schedule_teacher = ?;");
        $retrieve_section_for_plot->execute([
            strip_tags($_POST["semester"]),
            strip_tags($_POST["school_year"]),
            $user_fullname
        ]);
        echo '
                <option value="">Select Section</option>
            ';
        while ($row = $retrieve_section_for_plot->fetch()) {
            // echo '
            //     <option value="'.$row["section_name"].' '.$row["section_program"].'">'.$row["section_name"].' '.$row["section_program"].'</option>
            // ';
            echo '
                    <option value="' . $row["schedule_section"] . '">' . $row["schedule_section"] . '</option>
                ';
        }

    }
}

$retrieve_section_for_plot = null;
$conn = null;
?>