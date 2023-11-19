<?php
require("./data/database.php");
require("./data/data.verification_email_functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- BOOTSTRAP CSS LINK -->
    <link rel="stylesheet" href=".//css//main.min.css">
    <!-- BOOTSTRAP ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="./css/register_argie_css.css">
    <link rel="stylesheet" href=".//css//bootstrap-switch-button.min.css">
    <link rel="stylesheet" href="..//css//nstyle.css? <?php echo time(); ?>">

</head>

<body>

    <div class="alert toast-container position-fluid  translate-middle-x" id="alert-messages"></div>
    <div class="container-fluid">
        <div class="col-lg-3 col col-13 ">
            <div class="card rounded-1 border-1">

                <div class="card-header">
                    <!-- This is button from register -->
                    <div class="d-flex justify-content-center col-12 ">
                        <div class="button-box">
                            <input type="checkbox" id="roleCheckbox" data-toggle="switchbutton" checked
                                data-onlabel="Student" data-offlabel="Teacher" data-onstyle="success"
                                data-offstyle="danger">
                        </div>
                    </div>
                </div>


                <!-- This is button from register -->

                <div class="card-body">
                    <form id="register-student" class="row">
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Username"
                                name="register-student-username" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="password" class="form-control" placeholder="Password"
                                name="register-student-password" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="CTU-ID" name="register-student-ctuid"
                                id="register-student-ctuid" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="First Name"
                                name="register-student-first-name" id="register-student-first-name" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Last Name"
                                name="register-student-last-name" id="register-student-last-name" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Middle Name"
                                name="register-student-middle-name" id="register-student-middle-name">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Phone Number"
                                name="register-student-phone-number" id="register-student-phone-number" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Email" name="register-student-email"
                                id="register-student-email" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <select type="text" class="form-select" placeholder="Course" name="register-student-course"
                                id="register-student-course" required>
                                <option value="" selected>Select Course</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BIT">BIT</option>
                                <option value="BSMX">BSMX</option>
                            </select>
                        </div>
                        <div class="form-group py-1 col-6">
                            <select class="form-select" placeholder="Year" name="register-student-year"
                                id="register-student-year" required>
                                <option value="" selected>Select Year</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>

                        </div>
                        <div class="form-group py-1 col-6">
                            <select class="form-select" name="register-student-select-ay"
                                id="register-student-select-ay" required>
                                <option value="" selected>Select A.Y.</option>
                            </select>
                        </div>
                        <div class="form-group py-1 col-6">
                            <select class="form-select" name="register-student-select-semester"
                                id="register-student-select-semester" required>
                                <option value="" selected>Select Semester</option>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                            </select>
                        </div>
                        <div class="form-group py-1 col-6">
                            <select name="register-student-section" id="register-student-select-section"
                                class="form-select rounded-0 shadow-none" required>
                                <option value="" selected>Select Section</option>
                            </select>
                        </div>

                        <div class="form-group py-1 col-6">
                            <select name="register-student-status" class="form-select col-6" required>
                                <option value="" selected>Select Status</option>
                                <option value="Regular">Regular</option>
                                <option value="Irregular">Irregular</option>
                            </select>
                        </div>
                        <div class="form-group py-1 col-12">
                            <input type="text" class="form-control" placeholder="Address"
                                name="register-student-address" required>
                        </div>
                        <button type="submit" class="btn btn-primary my-3" id="add-register-student-btn">Register as
                            Student</button>

                    </form>

                    <form id="register-teacher" class="row">
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Username"
                                id="register-teacher-username" name="register-teacher-username" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="password" class="form-control" placeholder="Password"
                                name="register-teacher-password" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="CTU-ID" name="register-teacher-ctuid"
                                id="register-teacher-ctuid" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="First Name"
                                id="register-teacher-first-name" name="register-teacher-first-name" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Last Name"
                                id="register-teacher-last-name" name="register-teacher-last-name" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Middle Name"
                                id="register-teacher-middle-name" name="register-teacher-middle-name">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Address"
                                name="register-teacher-address" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Phone Number"
                                id="register-teacher-phone-number" name="register-teacher-phone-number">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Email" id="register-teacher-email"
                                name="register-teacher-email" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Bachelor"
                                name="register-teacher-bachelor" required>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Master" name="register-teacher-master">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Doctor" name="register-teacher-doctor">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Special"
                                name="register-teacher-special">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Major" name="register-teacher-major">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Minor" name="register-teacher-minor">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Designation"
                                name="register-teacher-designation">
                        </div>
                        <div class="form-group py-1 col-6">
                            <select name="register-teacher-status" class="form-select col-6" required>
                                <option value="" selected>Select Status</option>
                                <option value="Temporary">Temporary</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Organic">Organic</option>
                            </select>
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Research"
                                name="register-teacher-research">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Production"
                                name="register-teacher-production">
                        </div>
                        <div class="form-group py-1 col-6">
                            <input type="text" class="form-control" placeholder="Extension"
                                name="register-teacher-extension">
                        </div>
                        <div class="form-group py-1 col-12">
                            <input type="text" class="form-control" placeholder="Others" name="register-teacher-others">
                        </div>
                        <button type="submit" class="btn btn-primary my-3" id="add-register-teacher-btn">Register as
                            Teacher</button>
                    </form>


                    <p class="buttons"> <a href="./index.php"><b> BACK TO LOGIN</b></a></p>



                </div>

            </div>
        </div>

        <script src="./js/bootstrap.min.js"></script>
        <!-- JQUERY JS LINK -->
        <script src="./js/jquery-3.6.4.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="./js/index.js?<?php echo time(); ?>"></script>
        <script src="./js/bootstrap-switch-button.js"></script>
        <script src="./js/register_argie_js.js"></script>
        <script src="./js/validation.js"></script>
</body>

</html>