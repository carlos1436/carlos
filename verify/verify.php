<?php
require("../data/database.php");
require("../data/data.verification_email_functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- BOOTSTRAP CSS LINK -->
    <link rel="stylesheet" href="..//css//main.min.css">
    <!-- BOOTSTRAP ICON LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="..//css//verify_css.css" ? <?php echo time(); ?>>
    <link rel="stylesheet" href="./css/bootstrap-switch-button.min.css">
    <link rel="stylesheet" href="..//css//nstyle.css? <?php echo time(); ?>">

</head>

<body>

    <div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="alert-messages"></div>

    <div class="center-container">
        <div class="verify-card">
            <form>
                <h1 class='py-2 text-light'>Verify your email</h1>
                <input type="text" class="form-control my-2" placeholder="Enter verification code">
                <button type="submit" class="btn btn-success mb-2">Verify</button></br>
                <a href="../register.php">Back to Register</a>
            </form>
        </div>
    </div>


    <!-- <div class="row justify-content-center">
        <div class="col-12 col-md-6 d-flex justify-content-center">

            <p class="text-center mt-3">
                <a href="./login_page.php"><b> BACK TO LOGIN</b></a>
            </p>

        </div>
    </div> -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- JQUERY JS LINK -->
    <script src="../js/jquery-3.6.4.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="../js/index.js?<?php echo time(); ?>"></script>
    <script src="../js/bootstrap-switch-button.js"></script>
    <script src="../js/register_argie_js.js"></script>
    <script src="../js/validation.js"></script>
</body>

</html>