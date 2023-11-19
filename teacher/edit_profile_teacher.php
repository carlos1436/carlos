<?php
require '../data//login.php';
include_once("../data/database.php");
$select = new Select();
$user_fullname = "";
$user_type = "Teacher";
if ($_SESSION["user_type"] != "Teacher") {
    session_start();

    session_unset();
    session_destroy();

    header("Location: ../index.php");
} else {
    $retrieve_teacher_info = $conn->prepare("
   SELECT * FROM users
LEFT JOIN teacher
ON users.user_fullname = teacher.teacher_fullname
WHERE teacher.teacher_fullname = ?;
");
    $retrieve_teacher_info->execute([$_SESSION['user_fullname']]);
    $row = $retrieve_teacher_info->fetch();
    $user_fullname = $_SESSION["user_fullname"];
    $ctuid = $row["teacher_id_number"];
    $lname = $row["teacher_lastname"];
    $fname = $row["teacher_firstname"];
    $mname = $row["teacher_middlename"];
    $bachelor = $row["teacher_bachelor"];
    $master = $row["teacher_master"];
    $doctor = $row["teacher_doctor"];
    $special = $row["teacher_special"];
    $major = $row["teacher_major"];
    $minor = $row["teacher_minor"];
    $designation = $row["teacher_designation"];
    $status = $row["teacher_status"];
    $research = $row["teacher_research"];
    $production = $row["teacher_production"];
    $extension = $row["teacher_extension"];
    $others = $row["teacher_others"];

    $username = $row["user_username"];
    $password = $row["user_password"];
    $number = $row["user_contact"];
    $email = $row["user_email"];
    $address = $row["user_address"];

    // if (!empty($_SESSION["id"]) && !isset($_SESSION)) {
//     $user_id = $select->selectUserById($_SESSION["id"]);
//     // $user_type = $select->selectUserByType($_SESSION["user_type"]);
//     // $user_fullname = $select->selectUserByName($_SESSION["user_fullname"]);
// }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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

<body class="bg-light">
    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>
    <div class="container-fluid p-0 d-flex" style="overflow-x: hidden;">
        <?php include_once("../Components/teacher_Sidebar.php") ?>
        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/teacher_NavBar.php") ?>
            <!-- Modified section for time -->
            <div class="row g-2 px-3 my-1">
                <div class="col-lg-6 col col-12 shadow-sm">
                    <div class="card rounded-0 border-0">
                        <div class="card-header">
                            <strong>Edit Profile</strong>
                        </div>
                        <div class="card-body">
                            <form id="edit-profile-teacher" class="row">
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Username"
                                        id="edit-profile-teacher-username" name="edit-profile-teacher-username"
                                        value="<?php echo htmlentities($username); ?>" required disabled>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="password" class="form-control" placeholder="Password"
                                        name="edit-profile-teacher-password" id="edit-profile-teacher-password"
                                        required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="CTU-ID"
                                        name="edit-profile-teacher-ctuid" id="edit-profile-teacher-ctuid"
                                        value="<?php echo htmlentities($ctuid); ?>" required disabled>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="First Name"
                                        id="edit-profile-teacher-first-name" name="edit-profile-teacher-first-name"
                                        value="<?php echo htmlentities($fname); ?>" required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Last Name"
                                        id="edit-profile-teacher-last-name" name="edit-profile-teacher-last-name"
                                        value="<?php echo htmlentities($lname); ?>" required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Middle Name"
                                        id="edit-profile-teacher-middle-name" name="edit-profile-teacher-middle-name"
                                        value="<?php echo htmlentities($mname); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Address"
                                        name="edit-profile-teacher-address" required
                                        value="<?php echo htmlentities($address); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Phone Number"
                                        id="edit-profile-teacher-phone-number" name="edit-profile-teacher-phone-number"
                                        value="<?php echo htmlentities($number); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Email"
                                        id="edit-profile-teacher-email" name="edit-profile-teacher-email"
                                        value="<?php echo htmlentities($email); ?>" required disabled>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Bachelor"
                                        name="edit-profile-teacher-bachelor"
                                        value="<?php echo htmlentities($bachelor); ?>" required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Master"
                                        name="edit-profile-teacher-master" value="<?php echo htmlentities($master); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Doctor"
                                        name="edit-profile-teacher-doctor" value="<?php echo htmlentities($doctor); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Special"
                                        name="edit-profile-teacher-special"
                                        value="<?php echo htmlentities($special); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Major"
                                        name="edit-profile-teacher-major" value="<?php echo htmlentities($major); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Minor"
                                        name="edit-profile-teacher-minor" value="<?php echo htmlentities($minor); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Designation"
                                        name="edit-profile-teacher-designation"
                                        value="<?php echo htmlentities($designation); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <select name="edit-profile-teacher-status" class="form-select col-6" required>
                                        <option value="" selected>Select Status</option>
                                        <option value="Temporary" <?php if ($status == "Temporary")
                                            echo 'selected="selected"'; ?>>Temporary
                                        </option>
                                        <option value="Part-time" <?php if ($status == "Part-time")
                                            echo 'selected="selected"'; ?>>Part-Time
                                        </option>
                                        <option value="Organic" <?php if ($status == "Organic")
                                            echo 'selected="selected"'; ?>>Organic
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Research"
                                        name="edit-profile-teacher-research"
                                        value="<?php echo htmlentities($research); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Production"
                                        name="edit-profile-teacher-production"
                                        value="<?php echo htmlentities($production); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Extension"
                                        name="edit-profile-teacher-extension"
                                        value="<?php echo htmlentities($extension); ?>">
                                </div>
                                <div class="form-group py-1 col-12">
                                    <input type="text" class="form-control" placeholder="Others"
                                        name="edit-profile-teacher-others" value="<?php echo htmlentities($others); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary my-3" id="edit-profile-teacher-btn">Edit
                                    Profile</button>
                            </form>
                        </div>
                    </div>
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
<script src="../js//jquery-3.6.4.min.js"></script>
<script src="../js//datatables.min.js?<?php echo time(); ?>"></script>
<script src="../js//index.js?<?php echo time(); ?>"></script>
<script src="../js//time.js?<?php echo time(); ?>"></script>


</html>