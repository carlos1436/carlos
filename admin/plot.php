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

    <title>Plot</title>



    <!-- BOOTSTRAP ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CSS LINK -->
    <link href="..//css//select2.min.css" rel="stylesheet" />

    <!-- BOOTSTRAP CSS LINK -->
    <link rel="stylesheet" href="..//css//main.min.css">
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
            <div class="row g-2 px-3 my-1">
                <div class="col-lg-4 col-12">
                    <div class="card shadow-sm rounded-0 border-0">
                        <div class="card-header">
                            <strong>Scheduler <i class="bi bi-file-spreadsheet h5"></i></strong>
                        </div>
                        <div class="card-body p-3">
                            <div class="my-2">
                                <form id="add-schedule-form-plot">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Select Semester</label>
                                            <select name="plot_semester" id="select-semester"
                                                class="form-select rounded-0 shadow-none" required>
                                                <option value="" selected>Selected Semester</option>
                                                <option value="1st Semester">1st Semester</option>
                                                <option value="2nd Semester">2nd Semester</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Select A.Y</label>
                                            <select name="plot_school_year" id="select-ay"
                                                class="form-select rounded-0 shadow-none" required>
                                                <option value="" selected>Selected A.Y</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select Room</label>
                                            <select name="plot_room" id="select-room"
                                                class="form-select rounded-0 shadow-none" required>
                                                <option value="" selected>Selected Room</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select Section</label>
                                            <select name="plot_section" id="select-section"
                                                class="form-select rounded-0 shadow-none" required>
                                                <option value="" selected>Selected Section</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select Week Day</label>
                                            <select name="plot_week_day" class="form-select rounded-0 shadow-none"
                                                required>
                                                <option value="" selected>Selected Week Day</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select Teacher</label>
                                            <select name="plot_teacher" id="select-teacher"
                                                class="form-select rounded-0 shadow-none" required>
                                                <option value="" selected>Select Teacher</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select Subject</label>
                                            <select name="plot_subject" id="select-subject"
                                                class="form-select rounded-0 shadow-none" required>
                                                <option value="" selected>Select Subject</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select Start Time Hour</label>
                                            <select class="form-select shadow-none rounded-0"
                                                name="plot_start_time_hour" required>
                                                <option selected value="">Select Hour</option>
                                                <option value="07">07am</option>
                                                <option value="08">08am</option>
                                                <option value="09">09am</option>
                                                <option value="10">10am</option>
                                                <option value="11">11am</option>
                                                <option value="12">12nn</option>
                                                <option value="13">01pm</option>
                                                <option value="14">02pm</option>
                                                <option value="15">03pm</option>
                                                <option value="16">04pm</option>
                                                <option value="17">05pm</option>
                                                <option value="18">06pm</option>
                                                <option value="19">07pm</option>
                                                <option value="20">08pm</option>
                                                <option value="21">09pm</option>
                                                <option value="22">10pm</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select Start Time Minutes</label>
                                            <select class="form-select shadow-none rounded-0"
                                                name="plot_start_time_minute" required>
                                                <option selected value="">Select Minutes</option>
                                                <option value="00">00</option>
                                                <option value="30">30</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Select End Time Hour</label>
                                            <select class="form-select shadow-none rounded-0" name="plot_end_time_hour"
                                                required>
                                                <option selected value="">Select Hour</option>
                                                <option value="07">07am</option>
                                                <option value="08">08am</option>
                                                <option value="09">09am</option>
                                                <option value="10">10am</option>
                                                <option value="11">11am</option>
                                                <option value="12">12nn</option>
                                                <option value="13">01pm</option>
                                                <option value="14">02pm</option>
                                                <option value="15">03pm</option>
                                                <option value="16">04pm</option>
                                                <option value="17">05pm</option>
                                                <option value="18">06pm</option>
                                                <option value="19">07pm</option>
                                                <option value="20">08pm</option>
                                                <option value="21">09pm</option>
                                                <option value="22">10pm</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-2 text-center">
                                            <label class="form-label">Select End Time Minutes</label>
                                            <select class="form-select shadow-none rounded-0"
                                                name="plot_end_time_minute" required>
                                                <option selected value="">Select Minutes</option>
                                                <option value="00">00</option>
                                                <option value="30">30</option>
                                            </select>
                                        </div>
                                        <div class="my-3 d-grid">
                                            <button type="submit" class="btn btn-primary shadown-none rounded-0"
                                                id="add-schedule-btn-plot">Add Schedule</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-12 shadow-sm">
                    <div class="card shadow-sm rounded-0 border-0 table-responsive">
                        <div class="card-header">
                            <strong>TimeTable <i class="bi bi-justify h5"></i></strong>
                        </div>
                        <div class="card-body p-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link nav-link-table rounded-0 active" id="section-table-tab"
                                        data-bs-toggle="tab" data-bs-target="#section-table-tab-pane" type="button"
                                        role="tab" aria-controls="section-table-tab-pane" aria-selected="true">Section
                                        Timetable</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link nav-link-table rounded-0" id="teacher-table-tab"
                                        data-bs-toggle="tab" data-bs-target="#teacher-table-tab-pane" type="button"
                                        role="tab" aria-controls="teacher-table-tab-pane" aria-selected="false">Teacher
                                        Timetable</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link nav-link-table rounded-0" id="room-table-tab"
                                        data-bs-toggle="tab" data-bs-target="#room-table-tab-pane" type="button"
                                        role="tab" aria-controls="room-table-tab-pane" aria-selected="false">Room
                                        Timetable</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="section-table-tab-pane" role="tabpanel"
                                    aria-labelledby="section-table-tab" tabindex="0">
                                    <div class="my-3 d-flex align-items-center">
                                        <h4>Section Timetable</h4>
                                        <select style="width: 300px;" name="" id="select-section-timetable"
                                            class="mx-4 form-select rounded-0 shadow-none">
                                            <option value="" selected>Select Section</option>
                                        </select>
                                    </div>
                                    <div class="my-2" id="section-timetable"></div>
                                </div>
                                <div class="tab-pane fade" id="teacher-table-tab-pane" role="tabpanel"
                                    aria-labelledby="teacher-table-tab" tabindex="0">
                                    <div class="my-3 d-flex align-items-center">
                                        <h4>Teacher Timetable</h4>
                                        <select style="width: 300px;" name="" id="select-teacher-timetable"
                                            class="mx-4 form-select rounded-0 shadow-none">
                                            <option value="" selected>Select Teacher</option>
                                        </select>
                                    </div>
                                    <div class="my-2" id="teacher-timetable"></div>
                                </div>
                                <div class="tab-pane fade" id="room-table-tab-pane" role="tabpanel"
                                    aria-labelledby="room-table-tab" tabindex="0">
                                    <div class="my-3 d-flex align-items-center">
                                        <h4>Room Timetable</h4>
                                        <select style="width: 300px;" name="" id="select-room-timetable"
                                            class="mx-4 form-select rounded-0 shadow-none">
                                            <option value="" selected>Select Room</option>
                                        </select>
                                    </div>
                                    <div class="my-2" id="room-timetable"></div>
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

<script src="../js//time.js?<?php echo time(); ?>"></script>
<script src="../js//select2.min.js"></script>
<script src="../js//index.js?<?php echo time(); ?>"></script>
<script>
    $(function () {
        $("#select-teacher").select2();
    });
    $(function () {
        $("#select-subject").select2();
    });
    $(function () {
        $("#select-section").select2();
    });
    $(function () {
        $("#select-room").select2();
    });
    $(function () {
        $("#select-section-timetable").select2();
    });
    $(function () {
        $("#select-teacher-timetable").select2();
    });
    $(function () {
        $("#select-room-timetable").select2();
    });
</script>

</html>