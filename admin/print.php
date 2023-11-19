<?php
require '../data//login.php';
$select = new Select();
if ($_SESSION["user_type"] != "Admin") {
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

    <!-- BOOTSTRAP CSS LINK -->
    <link href="..//css//select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/main.min.css">
    <!-- BOOTSTRAP ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/nstyle.css?<?php echo time(); ?>">
    <title>Print</title>
</head>

<body class="bg-light" id="print-page">

    <!-- MODALS -->
    <?php include_once("../modals/modals.php") ?>

    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>
    <div class="container-fluid p-0 d-flex" style="overflow-x: hidden;">
        <?php include_once("../Components/admin_Sidebar.php") ?>


        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/admin_NavBar.php") ?>

            <div class="row g-2 px-3 my-1">
                <div class="col-12 col-lg-4">
                    <div class="card shadow-sm rounded-0 border-0">
                        <div class="card-header">
                            <strong>Filter Print</strong>
                        </div>
                        <div class="card-body">
                            <form id="filter-print-form">
                                <div class="my-2">
                                    <label class="form-label">Select Semester</label>
                                    <select name="print_select_semester" id="print-select-semester"
                                        class="form-select rounded-0 shadow-none">
                                        <option value="">Select Semester</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                    </select>
                                </div>
                                <div class="my-2">
                                    <label class="form-label">Select School Year</label>
                                    <select name="print_select_school_year" id="print-select-school-year"
                                        class="form-select rounded-0 shadow-none">
                                        <option value="">Select School Year</option>
                                    </select>
                                </div>
                                <!-- <div class="my-2">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label">Upload Header</label>
                                            <input type="file" class="form-control shadow-none rounded-0">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Upload Footer</label>
                                            <input type="file" class="form-control shadow-none rounded-0">
                                        </div>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-0 border-0">
                        <div class="card-header">
                            <strong>Print</strong>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active rounded-0" id="section-tab" data-bs-toggle="tab"
                                        data-bs-target="#section-tab-pane" type="button" role="tab"
                                        aria-controls="section-tab-pane" aria-selected="true">Section</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-0" id="teacher-tab" data-bs-toggle="tab"
                                        data-bs-target="#teacher-tab-pane" type="button" role="tab"
                                        aria-controls="teacher-tab-pane" aria-selected="false">Teacher</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-0" id="room-tab" data-bs-toggle="tab"
                                        data-bs-target="#room-tab-pane" type="button" role="tab"
                                        aria-controls="room-tab-pane" aria-selected="false">Room</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="section-tab-pane" role="tabpanel"
                                    aria-labelledby="section-tab" tabindex="0">
                                    <div class="my-3 row justify-content-between">
                                        <div class="col-4 d-flex">
                                            <select class="form-select shadow-none rounded-0" style="width:300px;"
                                                id="print-select-section">
                                                <option value="">Select Section</option>
                                            </select>
                                            <button class="btn btn-light h2 mx-2" id="print-section">
                                                <i class="bi bi-arrow-down-square-fill h2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="my-2" id="print-timetable">
                                        <div class="my-2" id="print-section-timetable"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="teacher-tab-pane" role="tabpanel"
                                    aria-labelledby="teacher-tab" tabindex="0">
                                    <div class="my-3 row justify-content-between">
                                        <div class="col-4 d-flex">
                                            <select class="form-select shadow-none rounded-0" style="width:300px"
                                                id="print-select-teacher">
                                                <option value="">Select Teacher</option>
                                            </select>
                                            <button class="btn btn-light h2 mx-3" id="print-teacher">
                                                <i class="bi bi-arrow-down-square-fill h2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="my-2" id="print-timetable">
                                        <div class="my-2" id="print-teacher-timetable"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="room-tab-pane" role="tabpanel" aria-labelledby="room-tab"
                                    tabindex="0">
                                    <div class="my-3 row justify-content-between">
                                        <div class="col-4 d-flex">
                                            <select class="form-select shadow-none rounded-0" id="print-select-room"
                                                style="width:300px">
                                                <option value="">Select Room</option>
                                            </select>
                                            <button class="btn btn-light h2 mx-3" id="print-room">
                                                <i class="bi bi-arrow-down-square-fill h2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="my-2" id="print-timetable">
                                        <div class="my-2" id="print-room-timetable"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script src="../js/jquery-3.6.4.min.js"></script>
    <!-- SCRIPT -->

    <script src="../js/index.js?<?php echo time(); ?>"></script>
    <script src="../js//time.js?<?php echo time(); ?>"></script>
    <script src="../js//select2.min.js"></script>
    <script>
        $(function () {
            $("#print-select-teacher").select2();
        });
        $(function () {
            $("#print-select-section").select2();
        });
        $(function () {
            $("#print-select-room").select2();
        });
    </script>
</body>

</html>