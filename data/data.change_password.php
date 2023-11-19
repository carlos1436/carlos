<?php
include("database.php");

if (isset($_GET['reset'])) {
    $check_code = $conn->prepare("SELECT * FROM users WHERE user_email_verified =?");
    $check_code->execute([$_GET['reset']]);
    if ($check_code->fetch()) {
        if (isset($_POST['submit'])) {
            if ($_POST['password'] == $_POST['con_password']) {
                $update_password = $conn->prepare("UPDATE users SET user_password =?, user_email_verified='' WHERE user_email_verified =?");
                $update_password->execute(
                    [
                        strip_tags($_POST['password']),
                        strip_tags($_GET['reset'])
                    ]
                );
                if ($update_password) {
                    echo "password_changed";
                } else {
                    echo "password_not_changed";
                }
            }
        }
    } else {
        echo "reset_code_invalid";
    }
} else {
    header("Location:./forgot_password.php");
}
?>