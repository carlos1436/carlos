<?php
include_once("database.php");
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {
        $random = rand(100000, 999999);
        $code = md5($random);
        $check_email = $conn->prepare("
            SELECT *
            FROM users
            WHERE user_email = ?");
        $check_email->execute([
            strip_tags($_POST["email"])
        ]);

        if ($check_email->fetch()) {
            $update_code = $conn->prepare("UPDATE users SET user_email_verified =? WHERE user_email=?");
            $update_code->execute([
                $code,
                strip_tags($_POST["email"])
            ]);
            if ($update_code) {
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                    $mail->isSMTP(); //Send using SMTP
                    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                    $mail->SMTPAuth = true; //Enable SMTP authentication
                    $mail->Username = 'argieabuloc060302@gmail.com'; //SMTP username
                    $mail->Password = 'ijfv jtfs mutv nvyk'; //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                    $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('argieabuloc060302@gmail.com');
                    $mail->addAddress($_POST["email"]); //Add a recipient

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = 'no reply';
                    $mail->Body = 'Here is the verification link <b><a href="http://localhost/raw_project_scheduling_email_verification/change_password.php?reset=' . $code . '">http://localhost/raw_project_scheduling_email_verification/change_password.php?reset=' . $code . '</a></b>';

                    $mail->send();
                    echo 'email_send_code';

                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        } else {
            echo "email_not_found";
        }
    }
}
?>