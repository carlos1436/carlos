<?php
//DATABASE CONNECTION
require '../data//login.php';
include_once("../data/database.php");
// RETRIEVING TEACHER LIST 

if ($_SESSION["user_type"] != "Admin") {
    session_start();

    session_unset();
    session_destroy();

    header("Location: ../index.php");
} else {

    $retrieve_teacher_list_plot = $conn->prepare("
 SELECT * 
 FROM teacher
");
    $retrieve_teacher_list_plot->execute([]);

    // RETRIEVING SUBJECT LIST
    $retrieve_subject_list_plot = $conn->prepare("
 SELECT * 
 FROM subject
");
    $retrieve_subject_list_plot->execute([]);

    // RETRIEVE SECTION
    $retrieve_section_list_plot = $conn->prepare("
 SELECT *
 FROM section
");
    $retrieve_section_list_plot->execute([]);
    $select = new Select();

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

    <title>Add Plot</title>



    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP CSS LINK -->

    <link href="..//css//select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="..//css//main.min.css">
    <!-- BOOTSTRAP ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="..//css//nstyle.css? <?php echo time(); ?>">

    <title>ADMIN</title>

</head>

<body class="bg-light">

    <?php include_once("../modals/modals.php") ?>

    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>
    <div class="container-fluid p-0 d-flex" style="overflow-x: hidden;">
        <?php include_once("../Components/admin_Sidebar.php") ?>


        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/admin_NavBar.php") ?>


            <div class="row g-2 px-3 my-1">
                <div class="col-12">
                    <div class="card shadow-sm rounded-0 border-0">
                        <div class="card-header">
                            <strong>Add Plot <i class="bi bi-sign-intersection-fill h5"></i></strong>
                        </div>
                        <div class="card-body">
                            <div class="my-2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0 active" id="add-teacher-plot"
                                            data-bs-toggle="tab" data-bs-target="#add-teacher-plot-pane" type="button"
                                            role="tab" aria-controls="add-teacher-plot-pane"
                                            aria-selected="true">Teacher</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link  nav-link-table rounded-0" id="add-subject-plot"
                                            data-bs-toggle="tab" data-bs-target="#add-subject-plot-pane" type="button"
                                            role="tab" aria-controls="add-subject-plot-pane"
                                            aria-selected="true">Subject</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table  rounded-0" id="add-section-plot"
                                            data-bs-toggle="tab" data-bs-target="#add-section-plot-pane" type="button"
                                            role="tab" aria-controls="add-section-plot-pane"
                                            aria-selected="true">Section</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="add-teacher-plot-pane" role="tabpanel"
                                        aria-labelledby="add-teacher-plot" tabindex="0">
                                        <form id="add-teacher-plot-form">
                                            <div class="my-2 row g-2 align-items-center">
                                                <div class="col-2">
                                                    <label class="form-label">Select Semester</label>
                                                    <select class="form-select rounded-0 shadow-none" name="semester">
                                                        <option value="" selected>Select Semester</option>
                                                        <option value="1st Semester">1st Semester</option>
                                                        <option value="2nd Semester">2nd Semester</option>
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label">Select A.Y.</label>
                                                    <select class="form-select rounded-0 shadow-none" id="select-ay"
                                                        name="school_year">
                                                        <option value="" selected>Select A.Y.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="my-2 table-responsive">
                                                <table id="datatable-teacher" class="table table-bordered">
                                                    <thead class="bg-primary">
                                                        <tr class="text-center border-dark" style='font-size: 13px;'>
                                                            <th>
                                                                <i class="bi bi-check-square-fill h6"></i>
                                                            </th>
                                                            <th>Teacher Firstname</th>
                                                            <th>Teacher Middlename</th>
                                                            <th>Teacher Lastname</th>
                                                            <th>Teacher Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = $retrieve_teacher_list_plot->fetch()) {
                                                            echo '
                                                                <tr class="text-center">
                                                                    <td>
                                                                        <input type="checkbox" name="" id="" value="' . $row["teacher_firstname"] . ' ' . $row["teacher_middlename"] . ' ' . $row["teacher_lastname"] . '">
                                                                    </td>
                                                                    <td>' . $row["teacher_firstname"] . '</td>
                                                                    <td>' . $row["teacher_middlename"] . '</td>
                                                                    <td>' . $row["teacher_lastname"] . '</td>
                                                                    <td>' . $row["teacher_status"] . '</td>
                                                                </tr>
                                                            ';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="my-3 text-end">
                                                <button type="submit" class="btn btn-primary rounded-0 shadow-none"
                                                    id="add-teacher-plot-btn">Add Teacher Plot</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="add-subject-plot-pane" role="tabpanel"
                                        aria-labelledby="add-subject-plot" tabindex="0">
                                        <form id="add-subject-plot-form">
                                            <div class="my-2 row g-2 align-items-center">
                                                <div class="col-2">
                                                    <label class="form-label">Select Semester</label>
                                                    <select class="form-select rounded-0 shadow-none"
                                                        name="select_subject_semester" id="select-semester-subject">
                                                        <option value="" selected>Select Semester</option>
                                                        <option value="1st Semester">1st Semester</option>
                                                        <option value="2nd Semester">2nd Semester</option>
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label">Select A.Y.</label>
                                                    <select class="form-select rounded-0 shadow-none"
                                                        name="select_subject_school_year" id="select-ay-subject">
                                                        <option value="" selected>Select A.Y.</option>
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label">Select Teacher</label>
                                                    <select class="" name="select_subject_teacher"
                                                        id="select-teacher-subject-plot">
                                                        <option value="" selected>Select Teacher</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="my-2 table-responsive">
                                                <table id="datatable-subject" class="table table-bordered">
                                                    <thead class="bg-primary">
                                                        <tr class="text-center border-dark" style='font-size: 13px;'>
                                                            <th>
                                                                <i class="bi bi-check-square-fill h6"></i>
                                                            </th>
                                                            <th>Subject Name</th>
                                                            <th>Subject Title</th>
                                                            <th>Subject Unit</th>
                                                            <th>Subject Lecture Hour</th>
                                                            <th>Subject Laboratory Hour</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = $retrieve_subject_list_plot->fetch()) {
                                                            echo '
                                                                <tr class="text-center">
                                                                    <td>
                                                                        <input type="checkbox" name="" id="subject_plot" value="' . $row["subject_id"] . '">
                                                                    </td>
                                                                    <td>' . $row["subject_name"] . '</td>
                                                                    <td>' . $row["subject_title"] . '</td>
                                                                    <td>' . $row["subject_unit"] . '</td>
                                                                    <td>' . $row["subject_lecture_hour"] . '</td>
                                                                    <td>' . $row["subject_laboratory_hour"] . '</td>
                                                                </tr>
                                                            ';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="my-3 text-end">
                                                <button type="submit" class="btn btn-primary rounded-0 shadow-none"
                                                    id="add-subject-plot-btn">Add Subject Plot</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="add-section-plot-pane" role="tabpanel"
                                        aria-labelledby="add-section-plot" tabindex="0">
                                        <form id="add-section-plot-form">
                                            <div class="my-2 row g-2 align-items-center">
                                                <div class="col-2">
                                                    <label class="form-label">Select Semester</label>
                                                    <select class="form-select rounded-0 shadow-none"
                                                        name="select_section_semester">
                                                        <option value="" selected>Select Semester</option>
                                                        <option value="1st Semester">1st Semester</option>
                                                        <option value="2nd Semester">2nd Semester</option>
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label">Select A.Y.</label>
                                                    <select class="form-select rounded-0 shadow-none"
                                                        name="select_section_school_year" id="select-section-ay">
                                                        <option value="" selected>Select A.Y.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="my-2 table-responsive">
                                                <table id="datatable-section" class="table table-bordered">
                                                    <thead class="bg-primary">
                                                        <tr class="text-center border-dark" style='font-size: 13px;'>
                                                            <th>
                                                                <i class="bi bi-check-square-fill h6"></i>
                                                            </th>
                                                            <th>Section Name</th>
                                                            <th>Section Program</th>
                                                            <th>Section Department</th>
                                                            <th>Section Major</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = $retrieve_section_list_plot->fetch()) {
                                                            echo '
                                                                <tr class="text-center">
                                                                    <td>
                                                                        <input type="checkbox" name="" id="section-plot" value="' . $row["section_id"] . '">
                                                                    </td>
                                                                    <td>' . $row["section_name"] . '</td>
                                                                    <td>' . $row["section_program"] . '</td>
                                                                    
                                                                    <td>' . $row["section_major"] . '</td>
                                                                </tr>
                                                            ';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="my-3 text-end">
                                                <button type="submit" class="btn btn-primary rounded-0 shadow-none"
                                                    id="add-section-plot-btn">Add Section Plot</button>
                                            </div>
                                        </form>
                                    </div>
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
<script src="../js//select2.min.js"></script>
<!-- <script>
$(function() {
    $("#select-teacher-subject-plot").select2({
        width: '30vh',
    });
});
</script> -->


</html>