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
}

if (!empty($_SESSION["id"]) && !isset($_SESSION)) {
    $user_id = $select->selectUserById($_SESSION["id"]);
    // $user_type = $select->selectUserByType($_SESSION["user_type"]);
    // $user_fullname = $select->selectUserByName($_SESSION["user_fullname"]);
}
$retrieve_feedback_student = $conn->prepare("
    SELECT * FROM feedback WHERE feedback_user_type = ? AND feedback_user_name_from = ?
");
$retrieve_feedback_student->execute([
    $user_type,
    $_SESSION["user_fullname"],
]);

$retrieve_feedback_student_completed = $conn->prepare("
    SELECT * FROM feedback WHERE feedback_user_type = ? AND feedback_user_name_from = ? AND feedback_status = 'Fixed';
");
$retrieve_feedback_student_completed->execute([
    $user_type,
    $_SESSION["user_fullname"],
]);
$retrieve_feedback_student_not_completed = $conn->prepare("
    SELECT * FROM feedback WHERE feedback_user_type = ? AND feedback_user_name_from = ? AND feedback_status = 'Pending';
");
$retrieve_feedback_student_not_completed->execute([
    $user_type,
    $_SESSION["user_fullname"],
]);
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
        <?php include_once("../Components/student_Sidebar.php") ?>


        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/student_NavBar.php") ?>

            <!-- Modified section for time -->
            <div class="row g-2 px-3 my-1">

                <div class="col-lg-6 col col-12 shadow-sm">
                    <div class="card rounded-0 border-0">
                        <div class="card-header">
                            <strong>Create Feedback</strong>
                        </div>
                        <div class="card-body">
                            <form id="add-student-feedback">
                                <div class="row">
                                    <div class="mt-2">
                                        <label class="form-label">Feedback Title</label>
                                        <input type="text" class="form-control shadow-none rounded-0"
                                            placeholder="Feedback Title" name="feedback_title">
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Feedback Description</label>
                                        <textarea type="text" class="form-control shadow-none rounded-0"
                                            placeholder="Feedback Description" name="feedback_desc"></textarea>
                                    </div>
                                    <div class="mt-2 col-4 col-lg-6">
                                        <label class="form-label">Feedback Type</label>
                                        <select name="feedback_type" id="feedback_type"
                                            class="form-select rounded-0 shadow-none">
                                            <option value="Selected Type" selected>Selected Type</option>
                                            <option value="Conflict">Conflict</option>
                                            <option value="Suspension">Suspension</option>
                                            <option value="Changing">Changing (Online or Face to Face)</option>

                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary shadown-none rounded-0"
                                            id="add-feedback-btn-student">Add Feedback</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Logs section -->
                <div class="col-lg-6 col-12">
                    <div class="card shadow-sm rounded-0 border-0">
                        <div class="card-header">
                            <strong>Feedback List</strong>
                        </div>
                        <div class="card-body">
                            <div class="my-2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0 active"
                                            id="all-table-tab-feedback" data-bs-toggle="tab"
                                            data-bs-target="#all-table-tab-pane-feedback" type="button" role="tab"
                                            aria-controls="all-table-tab-pane-feedback"
                                            aria-selected="true">All</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0"
                                            id="not-completed-table-tab-feedback" data-bs-toggle="tab"
                                            data-bs-target="#not-completed-table-tab-pane-feedback" type="button"
                                            role="tab" aria-controls="not-completed-table-tab-pane-feedback"
                                            aria-selected="false">Pending</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0"
                                            id="completed-table-tab-feedback" data-bs-toggle="tab"
                                            data-bs-target="#completed-table-tab-pane-feedback" type="button" role="tab"
                                            aria-controls="completed-table-tab-pane-feedback"
                                            aria-selected="false">Fixed</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="all-table-tab-pane-feedback"
                                        role="tabpanel" aria-labelledby="all-table-tab-feedback" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>All</h4>
                                        </div>
                                        <div class="my-2 table-responsive">
                                            <table id="datatable-feedback" class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr class="text-center border-dark" style='font-size: 13px;'>
                                                        <th>Feedback Title</th>
                                                        <th>Feedback Description</th>
                                                        <th>Feedback Type</th>
                                                        <th>Feedback Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = $retrieve_feedback_student->fetch()) {
                                                        echo '
                                                            <tr class="text-center">
                                                                <td>' . $row["feedback_title"] . '</td>
                                                                <td>' . $row["feedback_desc"] . '</td>
                                                                <td>' . $row["feedback_type"] . '</td>
                                                                <td>' . $row["feedback_status"] . '</td>
                                                                </tr>
                                                        ';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="not-completed-table-tab-pane-feedback"
                                        role="tabpanel" aria-labelledby="not-completed-table-tab-feedback" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Pending</h4>
                                        </div>
                                        <div class="my-2 table-responsive">
                                            <table id="datatable-feedback" class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr class="text-center border-dark" style='font-size: 13px;'>
                                                        <th>Feedback Title</th>
                                                        <th>Feedback Description</th>
                                                        <th>Feedback Type</th>
                                                        <th>Feedback Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = $retrieve_feedback_student_not_completed->fetch()) {
                                                        echo '
                                                            <tr class="text-center">
                                                                <td>' . $row["feedback_title"] . '</td>
                                                                <td>' . $row["feedback_desc"] . '</td>
                                                                <td>' . $row["feedback_type"] . '</td>
                                                                <td>' . $row["feedback_status"] . '</td>
                                                                </tr>
                                                        ';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="completed-table-tab-pane-feedback" role="tabpanel"
                                        aria-labelledby="completed-table-tab-feedback" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Fixed</h4>
                                        </div>
                                        <div class="my-2 table-responsive">
                                            <table id="datatable-feedback" class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr class="text-center border-dark" style='font-size: 13px;'>
                                                        <th>Feedback Title</th>
                                                        <th>Feedback Description</th>
                                                        <th>Feedback Type</th>
                                                        <th>Feedback Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = $retrieve_feedback_student_completed->fetch()) {
                                                        echo '
                                                            <tr class="text-center">
                                                                <td>' . $row["feedback_title"] . '</td>
                                                                <td>' . $row["feedback_desc"] . '</td>
                                                                <td>' . $row["feedback_type"] . '</td>
                                                                <td>' . $row["feedback_status"] . '</td>
                                                                </tr>
                                                        ';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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


</html>