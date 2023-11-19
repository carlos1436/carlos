<?php
require '../data//login.php';
include_once("../data/database.php");
$select = new Select();
if ($_SESSION["user_type"] != "Admin") {
    session_start();

    session_unset();
    session_destroy();

    header("Location: ../index.php");
} else {
    if (!empty($_SESSION["id"]) && !isset($_SESSION)) {
        $user_id = $select->selectUserById($_SESSION["id"]);
    }
    //RETRIEVING ANNOUNCEMENTS
    $retrieve_announcement = $conn->prepare("
    SELECT * FROM announcement
");
    $retrieve_announcement->execute([]);

    $retrieve_announcement_important = $conn->prepare("
    SELECT * FROM announcement WHERE announcement_type = 'Important'
");
    $retrieve_announcement_important->execute([]);

    $retrieve_announcement_suspensions = $conn->prepare("
    SELECT * FROM announcement WHERE announcement_type = 'Suspensions'
");
    $retrieve_announcement_suspensions->execute([]);

    $retrieve_announcement_events = $conn->prepare("
    SELECT * FROM announcement WHERE announcement_type = 'Events'
");
    $retrieve_announcement_events->execute([]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>

    <!-- BOOTSTRAP CSS LINK -->
    <link rel="stylesheet" href="..//css//main.min.css">
    <!-- BOOTSTRAP ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="..//css//nstyle.css? <?php echo time(); ?>">
    <link rel="stylesheet" href="..//css//teacher_home.css? ">


    <title>ADMIN</title>

</head>

<body>

    <?php include_once("../modals/modals.php") ?>
    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>
    <div id="sidebarContainer"></div>
    <div class="container-fluid p-0 d-flex" style="overflow-x: hidden;">
        <?php include_once("../Components/admin_Sidebar.php") ?>


        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/admin_NavBar.php") ?>

            <div class="container-fluid">

                <div class="row">
                    <div class="image">
                        <img src="logo.jpg" class="img-fluid">
                    </div>
                    <div class="col">
                        <h1><b> Class Schedule <br>Management System </b></h1>
                        <p>The Class Schedule Management System is a comprehensive software platform designed
                            to simplify the process of creating and managing class schedules for educational
                            institutions.<br>
                            With a user-friendly interface and a range of powerful features, this system offers schools
                            a unique opportunity
                            to enhance productivity, improve organization, and deliver a seamless educational experience
                        </p>
                    </div>
                    <div class="col1">



                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- BOOTSTRAP JS LINK -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
        </script>
    <!-- JQUERY JS LINK -->
    <script src="../js//jquery-3.6.4.min.js"></script>
    <script src="../js//datatables.min.js?<?php echo time(); ?>"></script>
    <script src="../js//index.js?<?php echo time(); ?>"></script>
    <script src="../js//time.js?<?php echo time(); ?>"></script>

</body>


</html>