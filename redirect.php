<?php
if (isset($_POST['proceed'])) {
    // The button was clicked, perform any necessary actions here
    
    // For example, you can redirect to another page
    header("Location: register.php");
    exit;
}
?>