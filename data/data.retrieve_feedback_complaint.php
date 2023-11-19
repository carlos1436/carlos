<?php
include_once("database.php");

$retrieve_feedback_complaint = $conn->prepare("
    SELECT * FROM feedback WHERE feedback_user_type = ?
");
$retrieve_feedback_complaint->execute([]);
echo "
<option value='' selected>Select Feedback Complaint</option>
";

while($row = $retrieve_feedback_complaint->fetch()){
    echo '
        <option value="'.$row["feedback_user_name_from"].'">'.$row["feedback_user_name_from"].'</option>
    ';
}




$retrieve_feedback_complaint = null;
$conn = null;
?>