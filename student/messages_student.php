<?php
require '../data//login.php';
$select = new Select();
if ($_SESSION["user_type"] != "Student") {
    session_start();

    session_unset();
    session_destroy();

    header("Location: ../index.php");
} else {
    if (!empty($_SESSION["id"]) && !isset($_SESSION)) {
        $user_id = $select->selectUserById($_SESSION["id"]);
        $user_type = $select->selectUserById($_SESSION["user_type"]);
        $user_name = $select->selectUserById($_SESSION["user_fullname"]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Messages</title>



    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP CSS LINK -->
    <link rel="stylesheet" href="..//css//main.min.css">
    <!-- BOOTSTRAP ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="..//css//nstyle.css? <?php echo time(); ?>">

    <title>ADMIN</title>

</head>

<body class="bg-gray">


    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>
    <div class="container-fluid p-0 d-flex" style="overflow-x: hidden;">
        <?php include_once("../Components/student_Sidebar.php") ?>


        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/student_NavBar.php") ?>


            <div class="messenger-container">
                <div class="message-list" id="messageList">
                    <!-- List of messages will be displayed here -->
                </div>
                <div class="chat-container">
                    <div class="chat-header">Chats</div>
                    <div class="chat-messages" id="chatMessages">
                        <!-- Chat messages will be displayed here -->
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="Type your message..." id="userInput">
                        <button onclick="sendMessage()">Send</button>
                    </div>
                </div>
            </div>
        </div>


</body>
<!-- BOOTSTRAP JS LINK -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
<!-- JQUERY JS LINK -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.1.2/socket.io.js"></script>
<script src="../js//jquery-3.6.4.min.js"></script>
<script src="../js//datatables.min.js?<?php echo time(); ?>"></script>
<script src="../js//index.js?<?php echo time(); ?>"></script>
<script src="../js//time.js?<?php echo time(); ?>"></script>


</html>