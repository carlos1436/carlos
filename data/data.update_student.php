<?php
// DATABASE CONNECTION
include_once("database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (session_start()) {
    $user_id = $_SESSION["id"];
    $user_fullname = $_SESSION["user_fullname"];
    $user_type = $_SESSION["user_type"];
} else {
    session_start();
}


require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    $value = strip_tags($value);
    return $value;
}
function get_domain($email)
{
    if (strrpos($email, '.') == strlen($email) - 3)
        $num_parts = 3;
    else
        $num_parts = 2;

    $domain = implode(
        '.',
        array_slice(preg_split("/(\.|@)/", $email), -$num_parts)
    );

    return strtolower($domain);
}
$student_fullname = "";
if (isset($_POST["submit"])) {
    if (!empty($_POST["submit"])) {
        $student_id_number_final = "";
        if ($_POST["middlename"] == null) {
            $student_fullname = strip_tags(legal_input($_POST["lastname"])) . ", " . strip_tags(legal_input($_POST["firstname"]));
        } else {
            $student_fullname = strip_tags(legal_input($_POST["lastname"])) . ", " . strip_tags(legal_input($_POST["firstname"])) . " " . strip_tags(legal_input($_POST["middlename"]));
        }
        $random = rand(100000, 999999);
        $code = md5($random);
        //ALLOWED DOMAINS
        $allowed = array('ctu.edu.ph');

        $user_id_final = "";
        // $check_username = $conn->prepare("
        //     SELECT * FROM users WHERE user_fullname =?
        // ");
        // $check_username->execute([
        //     $student_fullname
        // ]);

        // if ($check_username->fetch()) {
        //     echo "username_same_error";
        // } else 
        if (preg_match('/^[a-zA-Z]+$/', $_POST["username"])) {
            echo "username_error";
        } else if (preg_match('/^[a-zA-Z]+$/', $_POST["password"]) && strlen(trim($_POST["password"])) < 8) {
            echo "password_error";
        }
        // } else if (strlen(trim($_POST["ctuid"])) < 5) {
        //     echo "CTU_ID_error";
        // } else if (!in_array(get_domain($_POST["email"]), $allowed)) {
        //     echo "email_error";
        // } 
        else {
            $check_user_id = $conn->prepare("SELECT user_id FROM users WHERE user_fullname =?");
            $check_user_id->execute([strip_tags($_SESSION["user_fullname"])]);
            if ($row = $check_user_id->fetch()) {
                $user_id_final = $row["user_id"];
            }

            $update_student_user = $conn->prepare("
                UPDATE users 
                SET 
                user_password = ?,  
                user_fullname = ?,
                user_contact = ?,
                user_type = ?,
                user_address = ?,
                user_id_number = ?
                WHERE user_id = ?");
            $student_user_updated = $update_student_user->execute([
                strip_tags($_POST["password"]),
                strip_tags($student_fullname),
                strip_tags($_POST["phone_number"]),
                strip_tags("Student"),
                strip_tags($_POST["address"]),
                strip_tags($_POST["ctuid"]),
                strip_tags($user_id_final)
            ]);
            //Create an instance; passing `true` enables exceptions
            // $mail = new PHPMailer(true);

            // try {
            //     //Server settings
            //     // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
            //     $mail->isSMTP(); //Send using SMTP
            //     $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
            //     $mail->SMTPAuth = true; //Enable SMTP authentication
            //     $mail->Username = 'argieabuloc060302@gmail.com'; //SMTP username
            //     $mail->Password = 'ijfv jtfs mutv nvyk'; //SMTP password
            //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            //     $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //     //Recipients
            //     $mail->setFrom('argieabuloc060302@gmail.com');
            //     $mail->addAddress($_POST["email"]); //Add a recipient

            //     //Content
            //     $mail->isHTML(true); //Set email format to HTML
            //     $mail->Subject = 'no reply';
            //     $mail->Body = 'Here is the verification link <b><a href="http://localhost/raw_project_scheduling_email_verification/login_page.php?verification=' . $code . '">http://localhost/raw_project_scheduling_email_verification/login_page.php?verification=' . $code . '</a></b>';

            //     $mail->send();
            //     // echo 'Message has been sent';
            // } catch (Exception $e) {
            //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // }
            if ($student_user_updated) {
                echo 1;
            } else {
                echo 0;
            }
            // CHECK ID NUMBER
            // $check_id_number = $conn->prepare("
            //     SELECT student_id_number
            //     FROM student
            //     WHERE student_id_number = ?
            // ");
            // $check_id_number->execute([
            //     $_POST["ctuid"]
            // ]);

            // if ($check_id_number->fetch()) {
            //     echo "id_number_error";
            // } else {

            $check_student_id_number = $conn->prepare("SELECT student_id_number FROM student WHERE student_fullname =?");
            $check_student_id_number->execute([$_SESSION["user_fullname"]]);
            if ($row = $check_student_id_number->fetch()) {
                $student_id_number_final = $row["student_id_number"];
            }
            $update_student = $conn->prepare("
        UPDATE student 
        SET student_firstname = ?,
            student_middlename = ?,
            student_lastname = ?,
            student_fullname = ?,
            student_course = ?,
            student_year = ?,
            student_section = ?,
            student_status = ?
        WHERE student_id_number = ?
    ");

            $student_updated = $update_student->execute([
                $_POST["firstname"],
                $_POST["middlename"],
                $_POST["lastname"],
                $student_fullname,
                $_POST["course"],
                $_POST["year"],
                $_POST["section"],
                $_POST["status"],
                $student_id_number_final
            ]);

            if ($student_updated) {
                echo 1;
                $_SESSION["user_fullname"] = $student_fullname;
            } else {
                echo 0;
            }

            // }



        }

    }
}

$check_id_number = null;
$insert_student = null;
$conn = null;

?>