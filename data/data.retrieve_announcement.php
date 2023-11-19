<?php
include_once("database.php");
$retrieve_announcement = $conn ->prepare("
        SELECT * FROM announcement
")



?>