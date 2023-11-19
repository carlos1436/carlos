<?php
include_once("database.php");

$retrieve_feedback = $conn->prepare("
    SELECT * FROM feedback
");
$retrieve_feedback->execute([]);

?>