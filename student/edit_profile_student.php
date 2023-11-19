<?php
require '../data//login.php';
include_once("../data/database.php");
$select = new Select();
$user_fullname = "";
$user_type = "Student";

if ($_SESSION["user_type"] != "Student") {
    session_start();

    session_unset();
    session_destroy();

    header("Location: ../index.php");
} else {
    $retrieve_student_info = $conn->prepare("
   SELECT * FROM `student`
LEFT JOIN users
ON student.student_fullname = users.user_fullname
WHERE student.student_fullname = ?;
");
    $retrieve_student_info->execute([$_SESSION['user_fullname']]);
    $row = $retrieve_student_info->fetch();
    $user_fullname = $_SESSION["user_fullname"];
    $username = $row["user_username"];
    $password = $row["user_password"];
    $ctuid = $row["student_id_number"];
    $fname = $row["student_firstname"];
    $mname = $row["student_middlename"];
    $lname = $row["student_lastname"];
    $course = $row["student_course"];
    $number = $row["user_contact"];
    $email = $row["user_email"];
    $year = $row["student_year"];
    $section = $row["student_section"];
    $status = $row["student_status"];
    $address = $row["user_address"];
}

if (!empty($_SESSION["id"]) && !isset($_SESSION)) {
    $user_id = $select->selectUserById($_SESSION["id"]);
    // $user_type = $select->selectUserByType($_SESSION["user_type"]);
    // $user_fullname = $select->selectUserByName($_SESSION["user_fullname"]);
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
    <title>Student</title>
</head>

<body class="bg-light">
    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>
    <div class="container-fluid p-0 d-flex" style="overflow-x: hidden;">
        <?php include_once("../Components/student_Sidebar.php") ?>
        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/student_NavBar.php") ?>
            <!-- Modified section for time -->
            <div class="row g-2 px-3 my-1">
                <div class="col-lg-6 col col-12 shadow-sm">
                    <div class="card rounded-0 border-0">
                        <div class="card-header">
                            <strong>Edit Profile</strong>
                        </div>
                        <div class="card-body">
                            <form id="edit-profile-student" class="row">
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Username"
                                        name="edit-profile-student-username"
                                        value="<?php echo htmlentities($username); ?>" required disabled>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="password" class="form-control" placeholder="Password"
                                        name="edit-profile-student-password" required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="CTU-ID"
                                        name="edit-profile-student-ctuid" value="<?php echo htmlentities($ctuid); ?>"
                                        id="edit-profile-student-ctuid" required disabled>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="First Name"
                                        name="edit-profile-student-first-name" id="edit-profile-student-first-name"
                                        value="<?php echo htmlentities($fname); ?>" required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Last Name"
                                        name="edit-profile-student-last-name" id="edit-profile-student-last-name"
                                        value="<?php echo htmlentities($lname); ?>" required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Middle Name"
                                        name="edit-profile-student-middle-name" id="edit-profile-student-middle-name"
                                        value="<?php echo htmlentities($mname); ?>">
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Phone Number"
                                        name="edit-profile-student-phone-number" id="edit-profile-student-phone-number"
                                        value="<?php echo htmlentities($number); ?>" required>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Email"
                                        name="edit-profile-student-email" id="edit-profile-student-email"
                                        value="<?php echo htmlentities($email); ?>" required disabled>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <select type="text" class="form-select" placeholder="Course"
                                        name="edit-profile-student-course" id="edit-profile-student-course" required>
                                        <option value="">Select Course</option>
                                        <option value="BSIT" <?php if ($course == "BSIT")
                                            echo 'selected="selected"'; ?>>BSIT</option>
                                        <option value="BIT" <?php if ($course == "BIT")
                                            echo 'selected="selected"'; ?>>BIT</option>
                                        <option value="BSMX" <?php if ($course == "BSMX")
                                            echo 'selected="selected"'; ?>>BSMX</option>
                                    </select>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <select class="form-select" placeholder="Year" name="edit-profile-student-year"
                                        id="edit-profile-student-year" required>
                                        <option value="" selected>Select Year</option>
                                        <option value="1" <?php if ($year == "1")
                                            echo 'selected="selected"'; ?>>1</option>
                                        <option value="2" <?php if ($year == "2")
                                            echo 'selected="selected"'; ?>>2</option>
                                        <option value="3" <?php if ($year == "3")
                                            echo 'selected="selected"'; ?>>3</option>
                                        <option value="4" <?php if ($year == "4")
                                            echo 'selected="selected"'; ?>>4</option>
                                        <option value="5" <?php if ($year == "5")
                                            echo 'selected="selected"'; ?>>5</option>
                                    </select>

                                </div>
                                <div class="form-group py-1 col-6">
                                    <select class="form-select" name="edit-profile-student-select-ay"
                                        id="edit-profile-student-select-ay" required>
                                        <option value="" selected>Select A.Y.</option>
                                    </select>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <select class="form-select" name="edit-profile-student-select-semester"
                                        id="edit-profile-student-select-semester" required>
                                        <option value="" selected>Select Semester</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                    </select>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <select name="edit-profile-student-select-section"
                                        id="edit-profile-student-select-section"
                                        class="form-select rounded-0 shadow-none" required>
                                        <option value="" selected>Select Section</option>
                                    </select>
                                </div>
                                <div class="form-group py-1 col-6">
                                    <input type="text" class="form-control" placeholder="Address"
                                        name="edit-profile-student-address"
                                        value="<?php echo htmlentities($address); ?>" required>
                                </div>
                                <div class="form-group py-1 col-12">
                                    <select name="edit-profile-student-status" class="form-select col-6" required>
                                        <option value="" selected>Select Status</option>
                                        <option value="Regular" <?php if ($status == "Regular")
                                            echo 'selected="selected"'; ?>>Regular</option>
                                        <option value="Irregular" <?php if ($status == "Irregular")
                                            echo 'selected="selected"'; ?>>Irregular</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary my-3" id="edit-profile-student-btn">Edit
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