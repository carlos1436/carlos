<?php
include_once("./data/database.php");
$msg = "";
if (isset($_GET['verification'])) {
    $check_verification = $conn->prepare("SELECT * FROM users WHERE user_email_verified =?");
    $check_verification->execute([$_GET['verification']]);
    if ($check_verification->rowCount() > 0) {
        $update_verification = $conn->prepare("UPDATE users SET user_email_verified ='' WHERE user_email_verified =?");
        $update_verification->execute([$_GET['verification']]);

        if ($check_verification) {
            $msg = "<div class = 'alert alert-success'>Email verified successfully. Please login.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="./css/trial.css">
    <title>Login Page </title>
</head>

<body>

<?php echo $msg; ?>
<div class="my-2 toast-container position-fixed top-0 start-50 translate-middle-x" id="login-message"></div>


    <div class="container" id="container">
       
    
            <form id="login-form">

            <div class="image">
                    <img src="logo.jpg" class="img-fluid" alt="Phone image" >
            </div>

                <h1>LOGIN</h1>
               
              
                <input type="text" id="uname" class="form-control form-control-lg py-3" name="username"
                                autocomplete="off" placeholder="Username" style="border-radius:25px ;" />

               <input type="password" id="password" class="form-control form-control-lg py-3"
                                name="password" autocomplete="off" placeholder="Password"
                                style="border-radius:25px ;"/>





                <a href="forgot_password.php"><u>Forgot Your Password?</u></a>
                <button type="submit" name="login" id="form-login-btn">Sign In</button>
                 <br></br>
                <p style="text-align:center;"> Don't have an account? <a href="register.php" class="text-warning"
                            style="font-weight:600;text-decoration:none;"><u>Register Here</u></a></p>
            </form>
        </div>
       
    </div>

   <!-- Bootstrap JavaScript Libraries -->
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
        </script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- JQUERY JS LINK -->
    <script src="./js/jquery-3.6.4.min.js"></script>
    <script src="./js/index.js"></script>

</html>