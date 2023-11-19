<?php
include_once("database.php");

if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {
        $check_announcement = $conn->prepare("
            SELECT *
            FROM announcement
            WHERE announcement_title = ? AND announcement_desc = ? 
            AND announcement_type = ? AND announcement_start_date = ?
            AND announcement_end_date = ? 
        ");
        $check_announcement->execute([
            strip_tags($_POST["announcement_title"]),
            strip_tags($_POST["announcement_desc"]),
            strip_tags($_POST["announcement_type"]),
            strip_tags($_POST["announcement_start_date"]),
            strip_tags($_POST["announcement_end_date"]),
        ]);

        if ($check_announcement->fetch()) {
            echo "announcement_added";
        } else {
            $insert_announcement = $conn->prepare("
            INSERT INTO announcement
            (announcement_title,announcement_desc,announcement_type,
            announcement_start_date,announcement_end_date)
            VALUES (?,?,?,?,?)
            ");
            $inserted = $insert_announcement->execute([
                strip_tags($_POST["announcement_title"]),
                strip_tags($_POST["announcement_desc"]),
                strip_tags($_POST["announcement_type"]),
                strip_tags($_POST["announcement_start_date"]),
                strip_tags($_POST["announcement_end_date"]),
            ]);

            if ($inserted) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}

$check_announcement = null;
$insert_announcement = null;
$conn = null;

?>