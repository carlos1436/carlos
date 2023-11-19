<?php
 include_once("database.php");

 if(isset($_POST["submit"])){
    if(!empty($_POST["submit"])){
        $retrieve_filter_announcemet = $conn->prepare("
        SELECT * FROM announcement
        WHERE announcement_start_date = ? AND announcement_end_date = ?   
     ");
     $retrieve_filter_announcemet->execute([
        strip_tags($_POST["announcement_start_date"]),
        strip_tags($_POST["announcement_end_date"]),
     ]);
     if($row = $retrieve_filter_announcemet->fetch()){}
    }
 }

?>