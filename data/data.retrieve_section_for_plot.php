<?php
// DATABAE CONNECTION
include_once("database.php");

if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {

        $retrieve_section_for_plot = $conn->prepare("
                SELECT *
                FROM section_detail
                LEFT JOIN section
                ON section.section_id = section_detail.section_detail_section_id
                WHERE section_detail.section_detail_semester = ? AND section_detail.section_detail_school_year = ?
                ORDER BY section_name ASC;
            ");
        $retrieve_section_for_plot->execute([
            strip_tags($_POST["semester"]),
            strip_tags($_POST["school_year"])
        ]);

        echo '
                <option value="">Select Section</option>
            ';
        while ($row = $retrieve_section_for_plot->fetch()) {
            // echo '
            //     <option value="'.$row["section_name"].' '.$row["section_program"].'">'.$row["section_name"].' '.$row["section_program"].'</option>
            // ';
            echo '
                    <option value="' . $row["section_name"] . '">' . $row["section_name"] . '</option>
                ';
        }

    }
}

$retrieve_section_for_plot = null;
$conn = null;
?>