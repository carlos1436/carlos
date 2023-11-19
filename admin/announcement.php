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
        $user_type = $select->selectUserById($_SESSION["user_type"]);
        $user_name = $select->selectUserById($_SESSION["user_fullname"]);
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

    <title>Announcement</title>


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
                    <div class="card rounded-0 border-0 ">
                        <div class="card-header">
                            <strong>Announcement <i class="bi bi-megaphone-fill h5"></i></strong>
                        </div>
                        <div class="card-body">
                            <form id="add-announcement">
                                <div class="row">
                                    <div class="col-12 col col-lg-12">
                                        <div class="mt-2">
                                            <label class="form-label">Annoucement Title</label>
                                            <input type="text" class="form-control shadow-none rounded-0"
                                                placeholder="Announcement Title" name="announcement_title">
                                        </div>
                                        <div class="mt-2">
                                            <label class="form-label">Annoucement Description </label>
                                            <textarea type="text" class="form-control shadow-none rounded-0"
                                                placeholder="Announcement Description"
                                                name="announcement_desc"></textarea>
                                        </div>
                                        <div class="mt-2">
                                            <label class="form-label">Annoucement Type</label>
                                            <select class="form-select shadow-none rounded-0"
                                                placeholder="Announcement Type" name="announcement_type">
                                                <option value="" selected>Select Announcement Type</option>
                                                <option value="Important">Important</option>
                                                <option value="Suspensions">Suspensions</option>
                                                <option value="Events">Events</option>
                                            </select>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6 col col-lg-6">
                                                <label for="" class="form-label">Announcement Start Date</label>
                                                <input type="date" name="announcement_start_date"
                                                    id="announcement_start_date"
                                                    class="form-control rounded-0 shadow-none">
                                            </div>
                                            <div class="col-6 col col-lg-6">
                                                <label for="announcement_end_date" class="form-label">Announcement End
                                                    Date</label>
                                                <input type="date" name="announcement_end_date"
                                                    id="announcement_end_date"
                                                    class="form-control rounded-0 shadow-none">
                                            </div>
                                        </div>
                                        <div class="mt-3 d-grid">
                                            <button type="submit" class="btn btn-primary shadown-none rounded-0"
                                                id="add-announcement-btn">Add Announcement</button>
                                        </div>



                                    </div>
                                    <!-- <div class="col-12 col col-lg-6">
                                        <label class="form-label">To</label>
                                        <select name="" id="" class="form-select rounded-0 shadow-none"></select>
                                    </div> -->
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- Announcement List section -->
                <div class="col-lg-8 col-12 shadow-sm">
                    <div class="card shadow-sm rounded-0 border-0">
                        <div class="card-header">
                            <strong>Announcements List <i class="bi bi-stickies h6"></i></strong>
                        </div>
                        <div class="card-body p-3">
                            <form id="add-announcement-form-filter">
                                <div class="col-lg col col-12">
                                    <strong class="pe-2">Filter:</strong>
                                </div>
                                <div class="row">
                                    <div class="col-6 col col-lg-4 mt-2">
                                        <label for="announcement_filter_start_date" class="form-label">Start
                                            Date:</label>
                                        <input type="date" name="announcement_filter_start_date"
                                            id="announcement_filter_start_date"
                                            class="form-control rounded-0 shadow-none">
                                    </div>

                                    <div class="col-6 col col-lg-4 mt-2">
                                        <label for="announcement_filter_end_date" class="form-label">End Date:</label>
                                        <input type="date" name="announcement_filter_end_date"
                                            id="announcement_filter_end_date"
                                            class="form-control rounded-0 shadow-none">
                                    </div>
                                </div>
                                <div class="col-6 col col-lg-4 mt-3">
                                    <button type="submit" class="btn btn-primary shadown-none rounded-0"
                                        id="add-announcement-btn-filter">Go</button>
                                    <button type="button" class="btn btn-secondary shadown-none rounded-0"
                                        id="reset-filter-btn">Reset</button>
                                </div>
                            </form>
                            <div>
                                <ul class="nav nav-tabs mt-3">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0 active"
                                            id="all-table-tab-announcement" data-bs-toggle="tab"
                                            data-bs-target="#all-table-tab-pane-announcement" type="button" role="tab"
                                            aria-controls="all-table-tab-pane-announcement"
                                            aria-selected="true">All</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0"
                                            id="important-table-tab-annoucement" data-bs-toggle="tab"
                                            data-bs-target="#important-table-tab-pane-announcement" type="button"
                                            role="tab" aria-controls="important-table-tab-pane-announcement"
                                            aria-selected="false">Important</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0"
                                            id="suspensions-table-tab-annoucement" data-bs-toggle="tab"
                                            data-bs-target="#suspensions-table-tab-pane-announcement" type="button"
                                            role="tab" aria-controls="suspensions-table-tab-pane-announcement"
                                            aria-selected="false">Suspensions</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link nav-link-table rounded-0"
                                            id="events-table-tab-annoucement" data-bs-toggle="tab"
                                            data-bs-target="#events-table-tab-pane-announcement" type="button"
                                            role="tab" aria-controls="events-table-tab-pane-announcement"
                                            aria-selected="false">Events</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="all-table-tab-pane-announcement"
                                        role="tabpanel" aria-labelledby="all-table-tab-announcement" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>All</h4>
                                        </div>
                                        <div class="my-2 table-responsive">
                                            <table id="datatable-announcement" class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr class="text-center border-dark" style='font-size: 13px;'>
                                                        <th>Announcement Title</th>
                                                        <th>Announcement Description</th>
                                                        <th>Announcement Type</th>
                                                        <th>Announcement Start Date</th>
                                                        <th>Announcement End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = $retrieve_announcement->fetch()) {
                                                        echo '
                                                            <tr class="text-center">
                                                                <td>' . $row["announcement_title"] . '</td>
                                                                <td>' . $row["announcement_desc"] . '</td>
                                                                <td>' . $row["announcement_type"] . '</td>
                                                                <td>' . $row["announcement_start_date"] . '</td>
                                                                <td>' . $row["announcement_end_date"] . '</td>
                                                                </tr>
                                                        ';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="important-table-tab-pane-announcement"
                                        role="tabpanel" aria-labelledby="important-table-tab-announcement" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Important</h4>

                                        </div>
                                        <div class="my-2 table-responsive">
                                            <table id="datatable-announcement" class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr class="text-center border-dark" style='font-size: 13px;'>
                                                        <th>Announcement Title</th>
                                                        <th>Announcement Description</th>
                                                        <th>Announcement Type</th>
                                                        <th>Announcement Start Date</th>
                                                        <th>Announcement End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = $retrieve_announcement_important->fetch()) {
                                                        echo '
                                                            <tr class="text-center">
                                                                <td>' . $row["announcement_title"] . '</td>
                                                                <td>' . $row["announcement_desc"] . '</td>
                                                                <td>' . $row["announcement_type"] . '</td>
                                                                <td>' . $row["announcement_start_date"] . '</td>
                                                                <td>' . $row["announcement_end_date"] . '</td>
                                                                </tr>
                                                        ';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="suspensions-table-tab-pane-announcement"
                                        role="tabpanel" aria-labelledby="suspensions-table-tab-announcement"
                                        tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Suspensions</h4>
                                        </div>
                                        <div class="my-2 table-responsive">
                                            <table id="datatable-announcement" class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr class="text-center border-dark" style='font-size: 13px;'>
                                                        <th>Announcement Title</th>
                                                        <th>Announcement Description</th>
                                                        <th>Announcement Type</th>
                                                        <th>Announcement Start Date</th>
                                                        <th>Announcement End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = $retrieve_announcement_suspensions->fetch()) {
                                                        echo '
                                                            <tr class="text-center">
                                                                <td>' . $row["announcement_title"] . '</td>
                                                                <td>' . $row["announcement_desc"] . '</td>
                                                                <td>' . $row["announcement_type"] . '</td>
                                                                <td>' . $row["announcement_start_date"] . '</td>
                                                                <td>' . $row["announcement_end_date"] . '</td>
                                                                </tr>
                                                        ';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="events-table-tab-pane-announcement" role="tabpanel"
                                        aria-labelledby="events-table-tab-announcement" tabindex="0">
                                        <div class="my-3 d-flex align-items-center">
                                            <h4>Events</h4>
                                        </div>
                                        <div class="my-2 table-responsive">
                                            <table id="datatable-announcement" class="table table-bordered">
                                                <thead class="bg-primary">
                                                    <tr class="text-center border-dark" style='font-size: 13px;'>
                                                        <th>Announcement Title</th>
                                                        <th>Announcement Description</th>
                                                        <th>Announcement Type</th>
                                                        <th>Announcement Start Date</th>
                                                        <th>Announcement End Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    while ($row = $retrieve_announcement_events->fetch()) {
                                                        echo '
                                                            <tr class="text-center">
                                                                <td>' . $row["announcement_title"] . '</td>
                                                                <td>' . $row["announcement_desc"] . '</td>
                                                                <td>' . $row["announcement_type"] . '</td>
                                                                <td>' . $row["announcement_start_date"] . '</td>
                                                                <td>' . $row["announcement_end_date"] . '</td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>