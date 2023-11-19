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

    <title>Logs</title>


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

    <?php include_once('../modals/modals.php') ?>
    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>
    <div class="container-fluid p-0 d-flex" style="overflow-x: hidden;">
        <?php include_once("../Components/admin_Sidebar.php") ?>


        <div class="position-relative main-content" id="plot-content" style="width: 100%;">
            <?php include_once("../Components/admin_NavBar.php") ?>

            <!-- Modified section for time -->
            <div class="row g-2 px-3 my-1">

                <div class="col-lg-4 col-12 shadow-sm">
                    <div class="card rounded-0 border-0">
                        <div class="card-header">
                            <strong>Logs</strong>
                        </div>
                        <div class="card-body">
                            <div class="my-2">
                                <div class="row">
                                    <div class="col-12 col col-lg-6">
                                        <label class="form-label">From</label>
                                        <select name="" id="" class="form-select rounded-0 shadow-none"></select>
                                    </div>
                                    <div class="col-12 col col-lg-6">
                                        <label class="form-label">To</label>
                                        <select name="" id="" class="form-select rounded-0 shadow-none"></select>
                                    </div>
                                    <div class="col-6 col col-lg-4 mt-3">
                                        <button type="submit" class="btn btn-primary shadown-none rounded-0"
                                            id="add-announcement-btn-filter">Go</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Logs section -->
                <div class="col-lg-8 col-12">
                    <div class="card shadow-sm rounded-0 border-0">
                        <div class="card-header">
                            <strong>Logs List</strong>
                        </div>
                        <div class="card-body">
                            <div class="my-2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0 active" id="all-table-tab-logs"
                                            data-bs-toggle="tab" data-bs-target="#all-table-tab-pane-logs" type="button"
                                            role="tab" aria-controls="all-table-tab-pane-logs"
                                            aria-selected="true">All</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0" id="added-table-tab-logs"
                                            data-bs-toggle="tab" data-bs-target="#added-table-tab-pane-logs"
                                            type="button" role="tab" aria-controls="added-table-tab-pane-logs"
                                            aria-selected="false">Added</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0" id="updated-table-tab-logs"
                                            data-bs-toggle="tab" data-bs-target="#updated-table-tab-pane-logs"
                                            type="button" role="tab" aria-controls="updated-table-tab-pane-logs"
                                            aria-selected="false">Updated</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0" id="deleted-table-tab-logs"
                                            data-bs-toggle="tab" data-bs-target="#deleted-table-tab-pane-logs"
                                            type="button" role="tab" aria-controls="deleted-table-tab-pane-logs"
                                            aria-selected="false">Deleted</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="all-table-tab-pane-logs" role="tabpanel"
                                        aria-labelledby="all-table-tab-logs" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>All</h4>
                                        </div>
                                        <div class="my-2" id="all-timetable-logs"></div>
                                    </div>
                                    <div class="tab-pane fade" id="added-table-tab-pane-logs" role="tabpanel"
                                        aria-labelledby="added-table-tab-logs" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Added</h4>

                                        </div>
                                        <div class="my-2" id="added-timetable-logs"></div>
                                    </div>
                                    <div class="tab-pane fade" id="updated-table-tab-pane-logs" role="tabpanel"
                                        aria-labelledby="updated-table-tab-logs" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Updated</h4>
                                        </div>
                                        <div class="my-2" id="updated-timetable-logs"></div>
                                    </div>
                                    <div class="tab-pane fade" id="deleted-table-tab-pane-logs" role="tabpanel"
                                        aria-labelledby="deleted-table-tab-logs" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Deleted</h4>
                                        </div>
                                        <div class="my-2" id="deleted-timetable-logs"></div>
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